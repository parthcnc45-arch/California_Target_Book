<?php

namespace Tests\Feature;

use App\User;
use App\Subscription;
use App\BookSubscription;
use App\Transaction;
use App\DigitalAddonOrder;
use App\Company;
use App\Address;
use App\Cycle;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SubscriptionPurchaseTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        \Stripe\Stripe::setApiKey(config("app.STRIPE_KEY"));
    }

    /** @test */
    public function test_new_user_1_year_online_only_subscription()
    {
        $email = 'test_1y_online_' . uniqid() . '@example.com';
        
        $response = $this->postJson('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'company' => [
                'name' => 'Test Company LLC',
                'address' => [
                    'line1' => '123 Test St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'book_addresses' => [],
            'addons' => [],
            'payment_method' => 'stripe',
            'stripe_token' => 'tok_visa',
            'subscription_length' => 12,
            'subscription_cost' => config('subscriptions.one_year_online') * 100,
            'custom_total_amount' => config('subscriptions.one_year_online') * 100,
        ]);

        if ($response->status() !== 200) {
            file_put_contents(base_path('scratch/redirect_debug.txt'), 
                "Status: " . $response->status() . "\n" .
                "Location: " . $response->headers->get('Location') . "\n" .
                "Errors: " . json_encode(session()->get('errors') ? session()->get('errors')->getMessages() : []) . "\n" .
                "Content: " . $response->getContent()
            );
        }

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert Database State
        $user = User::where('email', $email)->firstOrFail();
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertNotEmpty($user->stripe_id);

        $subscription = $user->latestSubscription();
        $this->assertNotNull($subscription);
        $this->assertEquals(12, $subscription->frequency);
        $this->assertEquals('active', $subscription->status);
        $this->assertStringStartsWith('sub_', $subscription->wordpress_subscription_id);

        $cycle = $subscription->getCurrentCycle();
        $this->assertNotNull($cycle);
        $this->assertEquals('stripe', $cycle->payment_method);
        $this->assertStringStartsWith('in_', $cycle->invoice_id);

        // No shipments should be created
        $this->assertEquals(0, BookSubscription::where('user_id', $user->id)->count());

        // Assert Transaction
        $transaction = Transaction::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals($subscription->id, $transaction->subscription_id);
        $this->assertEquals($cycle->invoice_id, $transaction->stripe_invoice_id);
        $this->assertEquals(config('subscriptions.one_year_online') * 100, $transaction->amount);
        $this->assertEquals('Completed', $transaction->status);
        $this->assertEquals('Subscription - 1 Year', $transaction->plan);

        // Run background email dispatching
        $emailResponse = $this->postJson('/register-emails');
        if ($emailResponse->status() !== 200) {
            file_put_contents(base_path('scratch/redirect_debug.txt'), 
                "Status: " . $emailResponse->status() . "\n" .
                "Location: " . $emailResponse->headers->get('Location') . "\n" .
                "Errors: " . json_encode(session()->get('errors') ? session()->get('errors')->getMessages() : []) . "\n" .
                "Content: " . $emailResponse->getContent()
            );
        }
        $emailResponse->assertStatus(200);
        $emailResponse->assertJson(['success' => true]);
    }

    /** @test */
    public function test_new_user_1_year_print_subscription_with_addons()
    {
        $email = 'test_1y_print_' . uniqid() . '@example.com';
        $addonEmail1 = 'addon1_' . uniqid() . '@example.com';
        
        $response = $this->postJson('/register', [
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'company' => [
                'name' => 'Print Comp',
                'address' => [
                    'line1' => '100 Billing St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'book_addresses' => [
                [
                    'line1' => '200 Mailing St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'addons' => [$addonEmail1],
            'payment_method' => 'stripe',
            'stripe_token' => 'tok_visa',
            'subscription_length' => 12,
            'deck_qty' => 1,
            'deck_types' => [
                config('subscriptions.deck_only'),
                config('subscriptions.deck_presentation') . '_presentation'
            ],
            'subscription_cost' => config('subscriptions.one_year_print') * 100,
            'custom_total_amount' => (config('subscriptions.one_year_print') + config('subscriptions.additional_seat') + config('subscriptions.deck_only') + config('subscriptions.deck_presentation')) * 100,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user = User::where('email', $email)->firstOrFail();
        $subscription = $user->latestSubscription();
        $this->assertNotNull($subscription);
        $this->assertEquals('active', $subscription->status);

        // Check add-on seats
        $this->assertEquals(1, $subscription->addons()->count());
        $addonUser = $subscription->addons()->first();
        $this->assertEquals($addonEmail1, $addonUser->email);

        // Check physical book subscription (shipment)
        $this->assertEquals(1, BookSubscription::where('user_id', $user->id)->count());
        $bookSub = BookSubscription::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals('California Target Book', $bookSub->item_name);
        $this->assertEquals('200 Mailing St', $bookSub->address->line1);

        // Check DigitalAddonOrders are created for digital addons
        $this->assertEquals(2, DigitalAddonOrder::where('user_id', $user->id)->count());
        $this->assertTrue(DigitalAddonOrder::where('user_id', $user->id)->where('item_name', 'like', '%Deck%')->exists());
        $this->assertTrue(DigitalAddonOrder::where('user_id', $user->id)->where('item_name', 'like', '%Presentation%')->exists());

        // Check Transaction
        $transaction = Transaction::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals((config('subscriptions.one_year_print') + config('subscriptions.additional_seat') + config('subscriptions.deck_only') + config('subscriptions.deck_presentation')) * 100, $transaction->amount);
    }

    /** @test */
    public function test_new_user_2_year_print_subscription()
    {
        $email = 'test_2y_print_' . uniqid() . '@example.com';
        
        $response = $this->postJson('/register', [
            'first_name' => 'Bob',
            'last_name' => 'Jones',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'company' => [
                'name' => 'Two Year Corp',
                'address' => [
                    'line1' => '200 Billing St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'book_addresses' => [
                [
                    'line1' => '200 Mailing St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'addons' => [],
            'payment_method' => 'stripe',
            'stripe_token' => 'tok_visa',
            'subscription_length' => 24,
            'subscription_cost' => config('subscriptions.two_year_print') * 100,
            'custom_total_amount' => config('subscriptions.two_year_print') * 100,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user = User::where('email', $email)->firstOrFail();
        $subscription = $user->latestSubscription();
        $this->assertNotNull($subscription);
        $this->assertEquals(24, $subscription->frequency);
        $this->assertEquals('active', $subscription->status);

        $bookSub = BookSubscription::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals('California Target Book', $bookSub->item_name);

        $transaction = Transaction::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals(config('subscriptions.two_year_print') * 100, $transaction->amount);
        $this->assertEquals('Subscription - 2 Year', $transaction->plan);
    }

    /** @test */
    public function test_book_only_purchase_digital_and_physical()
    {
        $email = 'test_book_only_' . uniqid() . '@example.com';
        
        $response = $this->postJson('/purchase-book-only', [
            'first_name' => 'Charlie',
            'last_name' => 'Brown',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'stripe_token' => 'tok_visa',
            'custom_total_amount' => (config('subscriptions.deck_only') + config('subscriptions.deck_presentation') + config('subscriptions.additional_printed_book')) * 100,
            'deck_types' => [
                config('subscriptions.deck_only'),
                config('subscriptions.deck_presentation') . '_presentation',
                config('subscriptions.additional_printed_book') . '_book'
            ],
            'deck_qty' => 1,
            'deck_addresses' => [
                [
                    'line1' => '300 Book St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user = User::where('email', $email)->firstOrFail();

        // Transaction check
        $transaction = Transaction::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals((config('subscriptions.deck_only') + config('subscriptions.deck_presentation') + config('subscriptions.additional_printed_book')) * 100, $transaction->amount);

        // Digital addon orders checks (Deck Only and Presentation should be created)
        $this->assertEquals(2, DigitalAddonOrder::where('user_id', $user->id)->count());
        $deckOrder = DigitalAddonOrder::where('user_id', $user->id)->where('item_name', 'like', '%Deck Only%')->firstOrFail();
        $this->assertEquals(config('subscriptions.deck_only') * 100, $deckOrder->amount);
        $this->assertEquals('Paid', $deckOrder->payment_status);

        // Physical Book subscription check (Additional Printed Book should be created)
        $this->assertEquals(1, BookSubscription::where('user_id', $user->id)->count());
        $bookSub = BookSubscription::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals('Additional Printed Book', $bookSub->item_name);
        $this->assertEquals('300 Book St', $bookSub->address->line1);
    }

    /** @test */
    public function test_existing_user_repurchase_cancels_old_subscription()
    {
        // 1. Setup existing active subscription
        $email = 'test_existing_repurchase_' . uniqid() . '@example.com';
        
        $user = User::create([
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => bcrypt('secret123'),
            'stripe_id' => 'cus_test_' . uniqid(),
            'company_id' => Company::firstOrCreate(['name' => 'None'])->id,
        ]);

        $oldSubscription = Subscription::create([
            'account_id' => $user->id,
            'frequency' => 12,
            'status' => 'active',
            'wordpress_subscription_id' => 'sub_old_' . uniqid(),
            'next_payment' => now()->addYear()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
        ]);
        $user->subscriptions()->attach($oldSubscription->id, ['role' => 'subscriber']);
        
        $oldCycle = $oldSubscription->cycles()->create([
            'payment_method' => 'stripe',
            'starts_on' => now()->subMonth()->toDateString(),
            'ends_on' => now()->addYear()->toDateString(),
        ]);
        $oldCycle->activate();

        $this->assertTrue($oldSubscription->isActive());

        // 2. Perform new checkout for same user
        $this->actingAs($user);
        
        $response = $this->postJson('/register', [
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => $email,
            'phone_number' => '1234567890',
            'company' => [
                'name' => 'None',
                'address' => [
                    'line1' => '123 Test St',
                    'city' => 'Sacramento',
                    'state' => 'CA',
                    'zip_code' => '95814',
                ]
            ],
            'book_addresses' => [],
            'addons' => [],
            'payment_method' => 'stripe',
            'stripe_token' => 'tok_visa',
            'subscription_length' => 24,
            'subscription_cost' => config('subscriptions.two_year_online') * 100,
            'custom_total_amount' => config('subscriptions.two_year_online') * 100,
        ]);

        $response->assertStatus(200);

        // Assert old subscription is canceled
        $oldSubscription->refresh();
        $this->assertEquals('expired', $oldSubscription->status);
        $oldCycle->refresh();
        $this->assertTrue(now()->subDay()->toDateString() >= $oldCycle->ends_on);

        // Assert new subscription is active
        $newSubscription = $user->latestSubscription();
        $this->assertNotEquals($oldSubscription->id, $newSubscription->id);
        $this->assertEquals('active', $newSubscription->status);
        $this->assertEquals(24, $newSubscription->frequency);
    }

    /** @test */
    public function test_existing_user_addon_checkout_creates_digital_order()
    {
        $email = 'test_addon_checkout_' . uniqid() . '@example.com';
        
        $stripeCustomer = \Stripe\Customer::create([
            'email' => $email,
            'name' => 'Addon Buyer',
        ]);

        $user = User::create([
            'first_name' => 'Addon',
            'last_name' => 'Buyer',
            'email' => $email,
            'phone_number' => '1234567890',
            'password' => bcrypt('secret123'),
            'stripe_id' => $stripeCustomer->id,
            'company_id' => Company::firstOrCreate(['name' => 'None'])->id,
        ]);

        $subscription = Subscription::create([
            'account_id' => $user->id,
            'frequency' => 12,
            'status' => 'active',
            'wordpress_subscription_id' => 'sub_active_' . uniqid(),
            'next_payment' => now()->addYear()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
        ]);
        $subscription->users()->attach($user->id, ['role' => 'subscriber']);

        $this->actingAs($user);

        $response = $this->postJson('/account/addon-checkout/process', [
            'stripe_token' => 'tok_visa',
            'qty' => 1,
            'addon_price' => config('subscriptions.deck_presentation'),
            'addon_name' => 'Post-Election Deck Presentation',
            'addresses' => [], // Digital addon has no shipping addresses
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Verify DigitalAddonOrder is created
        $this->assertEquals(1, DigitalAddonOrder::where('user_id', $user->id)->count());
        $digitalOrder = DigitalAddonOrder::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals('Post-Election Deck Presentation', $digitalOrder->item_name);
        $this->assertEquals(config('subscriptions.deck_presentation') * 100, $digitalOrder->amount);

        // Verify Transaction record is created
        $transaction = Transaction::where('user_id', $user->id)->firstOrFail();
        $this->assertEquals($digitalOrder->transaction_id, $transaction->id);
        $this->assertEquals('Add-on - One-Time', $transaction->plan);
        $this->assertEquals(config('subscriptions.deck_presentation') * 100, $transaction->amount);

        // Verify NO BookSubscription was created
        $this->assertEquals(0, BookSubscription::where('user_id', $user->id)->count());

        // Verify admin endpoints filter properly
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_' . uniqid() . '@example.com',
            'phone_number' => '1111111111',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
        ]);
        $adminToken = $adminUser->api_token;

        // Hit Admin digital-orders API
        $digitalOrdersResponse = $this->getJson('/api/subscriptions/digital-orders', [
            'Authorization' => 'Bearer ' . $adminToken
        ]);
        $digitalOrdersResponse->assertStatus(200);
        $digitalOrdersList = $digitalOrdersResponse->json();
        $this->assertNotEmpty($digitalOrdersList);
        $this->assertEquals('Post-Election Deck Presentation', $digitalOrdersList[0]['item']) ;

        // Hit Admin hard-copies (shipments) API and assert that digital addon does NOT appear
        $hardCopiesResponse = $this->getJson('/api/subscriptions/hard-copies', [
            'Authorization' => 'Bearer ' . $adminToken
        ]);
        $hardCopiesResponse->assertStatus(200);
        $hardCopiesList = $hardCopiesResponse->json();
        if (is_array($hardCopiesList) && isset($hardCopiesList['data'])) {
            $hardCopiesList = $hardCopiesList['data'];
        }
        
        // Assert none of the shipments listed contains "Presentation" or "Deck" in item name
        if (is_array($hardCopiesList)) {
            foreach ($hardCopiesList as $shipment) {
                $this->assertStringNotContainsString('Presentation', $shipment['item_name'] ?? '');
                $this->assertStringNotContainsString('Deck', $shipment['item_name'] ?? '');
            }
        }
    }
}
