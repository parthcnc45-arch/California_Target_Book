<?php

namespace App\Http\Controllers\Admin;

use App\Classified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClassifiedsController extends Controller
{
    /**
     * Display a listing of classified ads.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        
        // 1. Calculate global stats (always computed globally for the dashboard cards)
        $allAds = Classified::get();
        
        $pendingCount = $allAds->where('status', 'Pending')->count();
        
        $activeAds = $allAds->filter(function($a) use ($today) {
            if ($a->status !== 'Active') return false;
            $start = $a->starts_on ? $a->starts_on->format('Y-m-d') : '';
            $end = $a->ends_on ? $a->ends_on->format('Y-m-d') : '';
            return ($start <= $today) && ($end >= $today);
        });
        $activeCount = $activeAds->count();

        $in3Days = date('Y-m-d', strtotime('+3 days'));
        $expiringCount = $allAds->filter(function($a) use ($today, $in3Days) {
            if ($a->status !== 'Active') return false;
            $start = $a->starts_on ? $a->starts_on->format('Y-m-d') : '';
            $end = $a->ends_on ? $a->ends_on->format('Y-m-d') : '';
            return ($start <= $today) && ($end >= $today && $end <= $in3Days);
        })->count();

        // Calculate Revenue for current month
        $currentMonth = date('m');
        $currentYear = date('Y');
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        
        $revenue = 0;
        foreach ($allAds as $ad) {
            if ($ad->status === 'Active') {
                $adStart = $ad->starts_on ? $ad->starts_on->format('Y-m-d') : '';
                $adEnd = $ad->ends_on ? $ad->ends_on->format('Y-m-d') : '';
                
                $overlaps = (!$adStart || $adStart <= $endOfMonth) && (!$adEnd || $adEnd >= $startOfMonth);
                if ($overlaps) {
                    $rateOption = $ad->rateOption; // Belongs to ClassifiedRate
                    if ($rateOption) {
                        $rateAmt = floatval($rateOption->rate_amount);
                        if ($rateOption->type === 'weekly') {
                            $revenue += $rateAmt * 4.33;
                        } else {
                            $revenue += $rateAmt;
                        }
                    } else {
                        // Fallback parsing for legacy records
                        $rateAmt = floatval($ad->rate_amount);
                        if ($rateAmt > 0) {
                            if ($ad->rate && (str_contains($ad->rate, '/wk') || str_contains(strtolower($ad->rate), 'week'))) {
                                $revenue += $rateAmt * 4.33;
                            } else {
                                $revenue += $rateAmt;
                            }
                        } else {
                            $rateStr = strtolower($ad->rate);
                            if (str_contains($rateStr, '165')) {
                                $revenue += 165 * 4.33;
                            } elseif (str_contains($rateStr, '585')) {
                                $revenue += 585;
                            }
                        }
                    }
                }
            }
        }
        $revenue = round($revenue);

        // 2. Build filtered query for the table
        $query = Classified::with('rateOption');

        // Search text filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('advertiser_email', 'like', "%{$search}%");
            });
        }

        // Category filter
        $category = $request->input('category', 'all');
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // Status filter (including Expired check)
        $statusVal = $request->input('status', 'all');
        if ($statusVal !== 'all') {
            if ($statusVal === 'pending') {
                $query->where('status', 'Pending');
            } elseif ($statusVal === 'inactive') {
                $query->where('status', 'Inactive');
            } elseif ($statusVal === 'active') {
                $query->where('status', 'Active')
                      ->where('ends_on', '>=', $today);
            } elseif ($statusVal === 'expired') {
                $query->where('status', 'Active')
                      ->where('ends_on', '<', $today);
            }
        }

        // Date range select filter
        if ($dateRange = $request->input('date_range')) {
            if ($dateRange === 'this_month') {
                $query->whereBetween('starts_on', [date('Y-m-01'), date('Y-m-t')]);
            } elseif ($dateRange === 'last_month') {
                $lastMonthStart = date('Y-m-d', strtotime('first day of last month'));
                $lastMonthEnd = date('Y-m-d', strtotime('last day of last month'));
                $query->whereBetween('starts_on', [$lastMonthStart, $lastMonthEnd]);
            } elseif ($dateRange === 'this_year') {
                $query->whereBetween('starts_on', [date('Y-01-01'), date('Y-12-31')]);
            }
        }

        // Order by created_at desc (newest ads first)
        $query->orderBy('created_at', 'desc');

        // CSV Export check
        if ($request->input('export') == 1) {
            $allFiltered = $query->get();
            return response()->json($allFiltered);
        }

        // Paginate results
        $limit = $request->input('limit', 8);
        $paginated = $query->paginate($limit);

        return response()->json([
            'data' => $paginated->items(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'from' => $paginated->firstItem(),
                'to' => $paginated->lastItem(),
            ],
            'stats' => [
                'active' => $activeCount,
                'pending' => $pendingCount,
                'expiring' => $expiringCount,
                'revenue' => $revenue
            ]
        ]);
    }

    /**
     * Retrieve active, filtered classified ads for the public directory (via AJAX).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublicClassifieds(Request $request)
    {
        $today = date('Y-m-d');
        
        // Base query for active ads
        $query = Classified::with('rateOption')->where('status', 'Active')
            ->where('starts_on', '<=', $today)
            ->where('ends_on', '>=', $today);

        // 1. Search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // 2. Category filter
        $category = $request->input('category', 'all');
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // 3. Sort logic
        $sort = $request->input('sort', 'newest');
        if ($sort === 'expiring') {
            $query->orderBy('ends_on', 'asc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('starts_on', 'asc');
        } else {
            $query->orderBy('starts_on', 'desc');
        }

        // 4. Calculate counts for ALL categories under the search filter (without category constraint)
        $countQuery = Classified::where('status', 'Active')
            ->where('starts_on', '<=', $today)
            ->where('ends_on', '>=', $today);
            
        if ($search) {
            $countQuery->where(function($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }
        
        $allActiveAdsForCounts = $countQuery->get();
        $counts = [
            'all' => $allActiveAdsForCounts->count(),
            'jobs' => $allActiveAdsForCounts->where('category', 'Jobs')->count(),
            'office' => $allActiveAdsForCounts->where('category', 'Office Space')->count(),
            'consulting' => $allActiveAdsForCounts->where('category', 'Consulting')->count(),
            'other' => $allActiveAdsForCounts->where('category', 'Other')->count(),
        ];

        // 5. Pagination
        if ($category === 'all') {
            $jobsQuery = clone $query;
            $officeQuery = clone $query;
            $consultingQuery = clone $query;
            $otherQuery = clone $query;

            $jobs = $jobsQuery->where('category', 'Jobs')->limit(3)->get();
            $office = $officeQuery->where('category', 'Office Space')->limit(3)->get();
            $consulting = $consultingQuery->where('category', 'Consulting')->limit(3)->get();
            $other = $otherQuery->where('category', 'Other')->limit(3)->get();

            return response()->json([
                'type' => 'grouped',
                'counts' => $counts,
                'data' => [
                    'Jobs' => $jobs,
                    'Office Space' => $office,
                    'Consulting' => $consulting,
                    'Other' => $other
                ]
            ]);
        } else {
            // Paginate the specific category query
            $paginated = $query->paginate(9);

            return response()->json([
                'type' => 'paginated',
                'counts' => $counts,
                'data' => $paginated->items(),
                'pagination' => [
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                    'from' => $paginated->firstItem(),
                    'to' => $paginated->lastItem(),
                ]
            ]);
        }
    }

    /**
     * Retrieve a specific classified ad.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $classified = Classified::findOrFail($id);
        return response()->json($classified);
    }

    /**
     * Store a newly created classified ad.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();

        unset($data['rate']);
        if (isset($data['rate_amount'])) {
            $data['rate_amount'] = floatval($data['rate_amount']);
        }

        $classified = Classified::create($data);

        return response()->json($classified, 201);
    }

    /**
     * Update the specified classified ad.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $classified = Classified::findOrFail($id);
        
        $data = $request->all();
        $this->validator($data)->validate();

        unset($data['rate']);
        if (isset($data['rate_amount'])) {
            $data['rate_amount'] = floatval($data['rate_amount']);
        }

        $classified->update($data);

        return response()->json($classified);
    }

    /**
     * Remove the specified classified ad.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $classified = Classified::findOrFail($id);
        $classified->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get a validator for an incoming classified ad request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'status' => 'required|string|in:Pending,Active,Inactive',
            'category' => 'required|string',
            'organization_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'link_url' => 'nullable|url|max:255',
            'starts_on' => 'required|date',
            'ends_on' => 'required|date|after_or_equal:starts_on',
            'advertiser_email' => 'required|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'classified_rate_id' => 'nullable|integer|exists:classified_rates,id',
            'rate_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
            'payment_status' => 'required|string|in:Paid (via GHL),Pending Payment,Invoiced,Complimentary',
        ], [
            'link_url.url' => 'Please enter a valid URL (including http:// or https://).',
            'ends_on.after_or_equal' => 'The end date must be on or after the start date.',
        ]);

        $validator->after(function ($validator) use ($data) {
            $body = $data['body'] ?? '';
            $words = preg_split('/\s+/', trim($body));
            $wordCount = empty(trim($body)) ? 0 : count($words);
            if ($wordCount > 100) {
                $validator->errors()->add('body', 'The body text must not exceed 100 words. (Current word count: ' . $wordCount . ')');
            }
        });

        return $validator;
    }

    /**
     * Retrieve pre-defined classified rate options.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRates()
    {
        $rates = \App\Models\ClassifiedRate::where('status', 'Show')->orderBy('created_at', 'asc')->get();
        return response()->json($rates);
    }

    /**
     * Retrieve all classified categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        $categories = \App\Models\ClassifiedCategory::orderBy('created_at', 'desc')->get();
        return response()->json($categories);
    }

    /**
     * Store a newly created classified category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:classified_categories,name|max:255',
            'status' => 'nullable|string|in:Show,Hide'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = \App\Models\ClassifiedCategory::create([
            'name' => $request->name,
            'status' => $request->status ?? 'Show'
        ]);

        return response()->json($category, 201);
    }

    /**
     * Update the specified classified category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategory(Request $request, $id)
    {
        $category = \App\Models\ClassifiedCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:classified_categories,name,' . $id,
            'status' => 'nullable|string|in:Show,Hide'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * Remove the specified classified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCategory($id)
    {
        $category = \App\Models\ClassifiedCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Retrieve all classified rates.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllRates()
    {
        $rates = \App\Models\ClassifiedRate::orderBy('created_at', 'asc')->get();
        return response()->json($rates);
    }

    /**
     * Store a newly created classified rate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'days' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:Show,Hide'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $amount = $request->amount !== null ? floatval($request->amount) : 0;
        $rate = \App\Models\ClassifiedRate::create([
            'title' => $request->title,
            'rate_amount' => $amount,
            'days' => $request->days ? intval($request->days) : null,
            'status' => $request->status ?? 'Show'
        ]);

        return response()->json($rate, 201);
    }

    /**
     * Update the specified classified rate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRate(Request $request, $id)
    {
        $rate = \App\Models\ClassifiedRate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'days' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:Show,Hide'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $amount = $request->amount !== null ? floatval($request->amount) : 0;
        $rate->update([
            'title' => $request->title,
            'rate_amount' => $amount,
            'days' => $request->days ? intval($request->days) : null,
            'status' => $request->status ?? 'Show'
        ]);

        return response()->json($rate);
    }

    /**
     * Remove the specified classified rate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRate($id)
    {
        $rate = \App\Models\ClassifiedRate::findOrFail($id);
        $rate->delete();

        return response()->json(['success' => true]);
    }
}
