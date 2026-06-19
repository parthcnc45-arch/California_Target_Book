<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\User;

class SyncGHLContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        if (!$user) {
            Log::warning('SyncGHLContact Job: No user object provided.');
            return;
        }

        $ghlToken   = config('app.GHL_TOKEN') ?? 'pit-9edbcb56-3ea3-4e72-b633-a54a943ec8cf';
        $locationId = config('app.GHL_LOCATION_ID') ?? 'Fvvh7SvvoDgMQg4PNPCB';

        // Try creating contact with Active Subscriber tags
        $payload = [
            'locationId' => $locationId,
            'firstName'  => $user->first_name ?? '',
            'lastName'   => $user->last_name ?? '',
            'email'      => $user->email,
            'phone'      => $user->phone_number ?? $user->phone ?? '',
            'tags'       => ['active_subscriber', 'CTB Active'],
        ];

        try {
            Log::info('SyncGHLContact Job: Sending create contact request to GHL', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            $response = Http::withHeaders([
                'Authorization' => "Bearer $ghlToken",
                'Version'       => '2021-07-28',
                'Accept'        => 'application/json',
            ])->post('https://services.leadconnectorhq.com/contacts/', $payload);

            $resData = $response->json();

            Log::info('SyncGHLContact Job: GHL Contact getOrCreate response', [
                'status' => $response->status(),
                'response' => $resData
            ]);

            $contactId = $resData['contact']['id'] ?? $resData['id'] ?? $resData['meta']['contactId'] ?? null;

            // If creation failed or didn't return contact ID (e.g. contact already exists)
            if (!$contactId) {
                Log::info('SyncGHLContact Job: Creation did not return contact ID. Searching contact by email...', [
                    'email' => $user->email
                ]);

                // Try to lookup/search contact by email
                $searchResponse = Http::withHeaders([
                    'Authorization' => "Bearer $ghlToken",
                    'Version'       => '2021-07-28',
                    'Accept'        => 'application/json',
                ])->get('https://services.leadconnectorhq.com/contacts/', [
                    'locationId' => $locationId,
                    'query' => $user->email
                ]);

                $searchData = $searchResponse->json();
                Log::info('SyncGHLContact Job: GHL Contact search response', [
                    'status' => $searchResponse->status(),
                    'response' => $searchData
                ]);

                $contacts = $searchData['contacts'] ?? [];
                if (!empty($contacts)) {
                    $contactId = $contacts[0]['id'] ?? null;
                }
            }

            // If contact already existed, let's update it to add the active_subscriber tags
            if ($contactId && ($response->status() === 400 || !empty($contacts))) {
                Log::info('SyncGHLContact Job: Updating tags for existing contact ID: ' . $contactId);
                Http::withHeaders([
                    'Authorization' => "Bearer $ghlToken",
                    'Version'       => '2021-07-28',
                    'Accept'        => 'application/json',
                ])->put("https://services.leadconnectorhq.com/contacts/{$contactId}", [
                    'tags' => ['active_subscriber', 'CTB Active']
                ]);
            }

            if ($contactId) {
                Log::info('SyncGHLContact Job: GHL Contact successfully synchronized', [
                    'user_id' => $user->id,
                    'ghl_contact_id' => $contactId,
                ]);

                // Update Stripe Customer metadata if stripe_id is available
                if (!empty($user->stripe_id)) {
                    try {
                        \Stripe\Stripe::setApiKey(config("app.STRIPE_KEY"));
                        $cust = \Stripe\Customer::retrieve($user->stripe_id);
                        if ($cust->metadata) {
                            $cust->metadata['ghl_contact_id'] = $contactId;
                        } else {
                            $cust->metadata = ['ghl_contact_id' => $contactId];
                        }
                        $cust->save();

                        Log::info('SyncGHLContact Job: Stripe Customer metadata updated with ghl_contact_id', [
                            'stripe_id' => $user->stripe_id,
                            'ghl_contact_id' => $contactId
                        ]);
                    } catch (\Exception $stripeEx) {
                        Log::error('SyncGHLContact Job: Stripe Customer metadata update failed: ' . $stripeEx->getMessage());
                    }
                }
            } else {
                Log::warning('SyncGHLContact Job: Completed, but no GHL contact ID was found/created.', [
                    'user_id' => $user->id
                ]);
            }

        } catch (\Exception $e) {
            Log::error('SyncGHLContact Job: Exception occurred: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to allow Laravel queue to retry/handle failure
        }
    }
}
