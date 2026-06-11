<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Public Routes
 */
Route::get('/', function () {
    return view('new');
})->name('home');

Route::get('/subscriptions/one-year', function () {
    return view('subscriptions.one_year');
})->name('subscriptions.one-year');

Route::get('/subscriptions/two-year', function () {
    return view('subscriptions.two_year');
})->name('subscriptions.two-year');

Route::get('/home', 'HomeController@index')->name('home.dashboard');

Route::get('/new', function () {
    return view('new');
});

// Route::get('/about', function () {
//     return view('old.about');
// })->name('about');

Route::get('/copyright', function () {
    return view('old.copyright');
});
Route::get('/editors', function () {
    return view('old.editors');
});
Route::get('/subscriber_list', function () {
    return view('old.subscriber_list');
});

Route::get('/releases', function () {
    return view('old.releases');
});

Route::get('/pdi_g18', function () {
    return view('old.pdi_g18');
});

Route::get('/pdi_av', function () {
    return view('old.pdi_av');
});

Route::get('/2020_filing_tracker', function () {
    return view('old.draw_all_e20_ballots');
});



Route::get('/sub2022', function () { return view('sub22'); });

Route::group([ 'prefix' => 'events' ], function () {
    Route::get('/thank-you', 'Admin\EventsController@showThankYou')
        ->name('events.thank-you');
    Route::get('/{event}', 'Admin\EventsController@show');
    Route::post('/{event}', 'Admin\EventsController@rsvp');
});

/*
 * Sample pages
 * */
Route::get('/sample_assembly', function () {
   return view('old.district', ['id' => 'AD30']);
});
Route::get('/sample_senate', function () {
    return view('old.district', ['id' => 'SD12']);
});

Route::get('/sample_congress', function () {
    return view('old.district', ['id' => 'CD49']);
});

Route::get('/sample_county_page', function () {
    return view('old.get_county_page_b', ['id' => 'SAN DIEGO']);
});


/**
 * Auth routes
 */
// Authentication Routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes
Route::get('/signup', function () {
    return view('signup');
})->name('signup');
Route::post('/signup', 'Auth\RegisterController@signup')->name('signup.post');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/register-addon', 'Auth\RegisterController@register_addon')->name('auth.register_addon');
Route::get('/register/thank-you', 'Auth\RegisterController@showThankYou')->name('register.thank-you');
Route::get('/register/coupon/{code}', 'Auth\RegisterController@checkCoupon')->name('register.check-coupon');

// Password Reset Routes
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/set/{token}', 'Auth\ResetPasswordController@markVerifiedAndRedirect');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify')->name('auth.verify');
Route::get('/verifyaddon/{token}', 'Auth\RegisterController@verify_addon')->name('auth.verify_addon');


Route::group([
    'prefix' => 'account',
    'middleware' => ['auth'],
], function () {

    Route::get('/', [
        'uses' => 'Auth\AccountController@index',
        'as' => 'auth.account',
    ]);

    Route::get('/account-info', [
        'uses' => 'Auth\AccountController@accountInfo',
        'as' => 'auth.account.info',
    ]);

    Route::get('/subscriptions', [
        'uses' => 'Auth\AccountController@subscriptions',
        'as' => 'auth.account.subscriptions',
    ]);

    Route::get('/subscriptions/seats', [
        'uses' => 'Auth\AccountController@purchaseSeats',
        'as' => 'auth.account.subscriptions.seats',
    ]);

    Route::get('/subscriptions/add', [
        'uses' => 'Auth\AccountController@addSubscriptionPage',
        'as' => 'auth.account.subscriptions.add',
    ]);

    Route::get('/subscriptions/manage-billing', [
        'uses' => 'Auth\AccountController@manageBilling',
        'as' => 'auth.account.manage_billing',
    ]);

    Route::post('/subscriptions/cancel', [
        'uses' => 'Auth\AccountController@cancelSubscription',
        'as' => 'auth.account.subscriptions.cancel',
    ]);

    Route::post('/subscriptions/addons', [
        'uses' => 'Auth\AccountController@inviteAddon',
        'as' => 'auth.account.subscriptions.addons.invite',
    ]);

    Route::post('/subscriptions/addons/remove', [
        'uses' => 'Auth\AccountController@removeAddon',
        'as' => 'auth.account.subscriptions.addons.remove',
    ]);


    Route::get('/transaction-history', [
        'uses' => 'Auth\AccountController@transactionHistory',
        'as' => 'auth.account.transaction_history',
    ]);

    Route::get('/invoice/{invoice_id}', [
        'uses' => 'Auth\AccountController@viewInvoice',
        'as' => 'auth.account.invoice',
    ]);

    Route::get('/shipping-tracking', [
        'uses' => 'Auth\AccountController@shippingTracking',
        'as' => 'auth.account.shipping_tracking',
    ]);

    Route::get('/settings', [
        'uses' => 'Auth\AccountController@settings',
        'as' => 'auth.account.settings',
    ]);

    Route::get('/help-support', [
        'uses' => 'Auth\AccountController@helpSupport',
        'as' => 'auth.account.help_support',
    ]);

    Route::get('/renew', [
        'uses' => 'Auth\AccountController@showRenew',
        'as' => 'auth.account.renew',
    ]);
    Route::post('/renew', [
        'uses' => 'Auth\AccountController@renewSubscription',
        'as' => 'auth.account.renew',
    ]);
    Route::get('/renew/thank-you', [
        'uses' => 'Auth\AccountController@showRenewThankYou',
        'as' => 'auth.account.renew-thank-you',
    ]);

});


/**
 * Static resources
 */
Route::get('/docs/{file}', [
    'as' => 'docs',
    'middleware' => ['auth'],
    'uses' => 'ResourceController@index',
])
    ->where('file', '(.*)');

/*
 * Book
 * Behind Paywall
 * */
Route::group([
        'prefix' => 'book',
        'middleware' => ['auth', 'active_subscription'],
    ], function() {

    Route::get('/', function () { return view('book.index'); })
        ->name('book');

    Route::group([ 'prefix' => 'hotsheet', 'namespace' => 'Book' ], function () {
        Route::get('/', 'HotsheetController@index')->name('book.hotsheet');
        Route::get('/{article}', 'HotsheetController@showArticle')->name('book.hotsheet.article');
    });

    Route::group([ 'prefix' => 'redist_news', 'namespace' => 'Book' ], function () {
        Route::get('/', 'RedistNewsController@index')->name('book.redist_news');
        Route::get('/{article}', 'RedistNewsController@showArticle')->name('book.redist_news_item.article');
    });


    Route::group([ 'prefix' => 'poll' ], function () {
        Route::get('/', 'PollsController@showCurrentPoll')->name('book.current-poll');
        Route::post('/{id}', 'PollsController@submitAnswersToPoll')->name('book.poll');
    });

    Route::get('/ca_e22_finance_summary', function () { return view('old.ca_e22_finance_summary'); });
    Route::get('/e22_finances', function () { return view('old.e22_finances'); });



    //CANDIDATE DIRECTORIES
    Route::get('/e22_roster', function () { return view('old.e22_roster'); });

    Route::group([ 'prefix' => 'candidates' ], function () {
        Route::get('/', function () { return view('old.candidates_hub'); });

        Route::get('/directory', function () { return view('old.candidate_directory_all'); });
        Route::get('/directory/ca', function () { return view('old.ca_cand_directory'); });
        //SUMMARY OF FEDERAL CANDIDATES & CAMPAIGN FINANCE INFO 2006 - 2018
        Route::get('/directory/house', function () { return view('old.house_cand_nav'); });

        Route::get('/2018/summary', function () { return view('old.ca_candidates_e18_summary'); });
	Route::get('/2020/summary', function () { return view('old.ca_e20_finance_summary'); });
	Route::get('/2022/summary', function () { return view('old.ca_e22_finance_summary'); });



        Route::get('/2018/roster', function () { return view('old.e18_roster'); });
	Route::get('/2020/roster', function () { return view('old.e20_roster'); });
	Route::get('/2022/roster', function () { return view('old.e22_roster'); });



        //ELECTION 2018 CANDIDATE WATCH LIST
        Route::get('/2018/watchlist', function () { return view('old.e18_watchlist'); });
        Route::get('/2020/watchlist', function () { return view('old.e20_watchlist'); });
    });

    //DRAW CANDIDATE PAGE, RETRIEVE ELECTION HISTORY AND ASSOCIATED COMMITTEES
    Route::get('/get_cand_page_t', function () { return view('old.get_cand_page_t'); });

    //CENSUS & REGISTRATION STATISTICS
    Route::get('/stats_hub', function () { return view('old.stats_hub'); });
    Route::get('/ca_census_trends', function () { return view('old.ca_census_trends'); });
    Route::get('/pl94_2020', function () { return view('old.pl94_2020'); });
	


    Route::get('/search', function () { return view('old.search_nav'); });

    Route::get('/acs_delta', function () { return view('old.acs_delta'); });


    //CALIFORNIA CAMPAIGN FINANCE
    Route::get('/state_finance_hub', function () { return view('old.state_finance_hub'); });
    Route::get('/ca_e20_finance_summary', function () { return view('old.ca_e20_finance_summary'); });
    Route::get('/fppc_top_cmtes', function () { return view('old.fppc_top_cmtes'); });
    Route::get('/fppc_lobby_2021', function () { return view('old.fppc_lobby_2021'); });




    //REALTIME FEED OF CA FPPC CAMPAIGN FINANCE FILINGS, LATE CONTRIBUTIONS, INDEPENDENT EXPENDITURES
    Route::get('/realtime_month', function () { return view('old.realtime_month'); });

    //CAMPAIGN FINANCE REPORT GENERATOR
    Route::get('/cmlocal2', function () { return view('old.cmlocal2'); });

    //CALIFORNIA INDEPENDENT EXPENDITURE LISTINGS
    Route::get('/ca_ielist_g20', function () { return view('old.ca_ielist_g20'); });
    Route::get('/ca_ielist_p18', function () { return view('old.ca_ielist_p18'); });
    Route::get('/ca_ielist_p20', function () { return view('old.ca_ielist_p20'); });
    Route::get('/ca_ielist_g18', function () { return view('old.ca_ielist_g18'); });
    Route::get('/ca_ielist_g16', function () { return view('old.ca_ielist_g16'); });
    Route::get('/ca_ielist_p16', function () { return view('old.ca_ielist_p16'); });
    Route::get('/ca_ielist_s17', function () { return view('old.ca_ielist_s17'); });
    Route::get('/cal_ie_hist', function () { return view('old.cal_ie_hist'); });
    Route::get('/iehist', function () { return view('old.iehist'); });
    Route::get('/ca_party_spend_all_g18', function () { return view('old.ca_party_spend_all_g18'); });


    //FEC CAMPAIGN FINANCE DATA
    Route::get('/federal_finance_hub', function () { return view('old.federal_finance_hub'); });
    Route::get('/fec_2020_hub', function () { return view('old.fec_2020_hub'); });


    //FEC FILINGS RSS FEED (PARSED)
    Route::get('/fec_new', function () { return view('old.fec_new'); });
    Route::get('/fec_detailed', function () { return view('old.fec_detailed'); });
    Route::get('/fec_all', function () { return view('old.fec_all'); });


    Route::get('/getfedfilings', function () { return view('old.getfedfilings'); });
    Route::get('/heybigspender_18', function () { return view('old.heybigspender_18'); });

    //PAST SUMMARY DATA FOR SENATE AND CONGRESSIONAL RACES BY ELECTION CYCLE
    Route::get('/g12_fedspend_bystate', function () { return view('old.g12_fedspend_bystate'); });
    Route::get('/g12_fedsumbrowser', function () { return view('old.g12_fedsumbrowser'); });
    Route::get('/g14_fedspend_bystate', function () { return view('old.g14_fedspend_bystate'); });
    Route::get('/g14_fedsumbrowser', function () { return view('old.g14_fedsumbrowser'); });
    Route::get('/g16_fedspend_bystate', function () { return view('old.g16_fedspend_bystate'); });
    Route::get('/g16_fedsumbrowser', function () { return view('old.g16_fedsumbrowser'); });
    Route::get('/g18_fedspend_bystate', function () { return view('old.g18_fedspend_bystate'); });
    Route::get('/g18_fedsumbrowser', function () { return view('old.g18_fedsumbrowser'); });

    //PAST ELECTION RESULTS SECTION
    Route::get('/elections_hub', function () { return view('old.elections_hub'); });


    //MAP SECTION
    Route::get('/maps_hub', function () { return view('old.maps_hub'); });

    //DRAW U.S. CONGRESSIONAL DISTRICT
    Route::get('/drawcd.php', function () { return view('old.drawcd'); });
    Route::get('/drawcd', function () { return view('old.drawcd'); });

    //PRECINCT NAVIGATION & MAPPING FUNCTION (Dual Nav functions, one with navigation bar, one for running headless in iframe)
    Route::get('/precinct_nav', function () { return view('old.precinct_nav'); });
    Route::get('/precinct_nav2', function () { return view('old.precinct_nav2'); });

    //MAP DRAWING PAGE FOR PRECINCT DATA
    Route::get('/precinct_test', function () { return view('old.precinct_test'); });

    //ALL-PURPOSE MAP DRAW FOR ASSEMBLY, STATE SENATE, CA CONGRESSIONAL, BOARD OF EQUALIZATION, AND COUNTY DISTRICTS
    Route::get('/map_nav', function () { return view('old.map_nav'); });
    Route::get('/map_nav.php', function () { return view('old.map_nav'); });
    Route::get('/new_map_nav', function () { return view('old.new_map_nav'); });
    Route::get('/new_map_nav2', function () { return view('old.new_map_nav2'); });
    Route::get('/dmaps', function () { return view('old.dmaps'); });
    Route::get('/pmaps', function () { return view('old.pmaps'); });
    Route::get('/omaps', function () { return view('old.omaps'); });
    Route::get('/geo_nav', function () { return view('old.geo_nav'); });
    Route::get('/rpt_nav', function () { return view('old.rpt_nav'); });
    Route::get('/geo_info', function () { return view('old.geo_info'); });
    Route::get('/blockgroup_nav', function () { return view('old.blockgroup_nav'); });



    //MAP TWO OVERLAPPING DISTRICTS
    Route::get('/overlap_nav', function () { return view('old.overlap_nav'); });
    Route::get('/overlap_nav2', function () { return view('old.overlap_nav2'); });

    //MAIN MAP-DRAWING PAGE FOR NON-PRECINCT DATA
    Route::get('/draw_leg', function () { return view('old.draw_leg'); });

    Route::get('/city_browser2', function () { return view('old.city_browser2'); });
    Route::get('/city_detail_browser', function () { return view('old.city_detail_browser'); });
    Route::get('/draw_all_e18_ballots', function () { return view('old.draw_all_e18_ballots'); });
    Route::get('/draw_all_e20_ballots', function () { return view('old.draw_all_e20_ballots'); });



    //DISTRICT PAGES

    /*
     * District
     * */
    Route::get('/get_ctb_page_b', function() {
        return redirect()->route('book.district', ['id' => $_GET['id']]);
    });
    Route::get('/district/{id}', function($id) {
        return view('old.district', ['id' => $id]);
    })->name('book.district');

    Route::get('/old/{id}', function($id) {
        return view('old.district', ['id' => $id]);
    })->name('book.district');

    Route::get('/new/{id}', function($id) {
        return view('old.district_20', ['id' => $id]);
    })->name('book.new_district');


    /*
     * City
     * */

    Route::get('/city2/{id}', function($id) {
        return view('old.get_county_sub3', ['sub' => $id]);
    })->name('book.city');

    Route::get('/city/{id}', function($id) {
        return view('old.city_page', ['sub' => $id]);
    })->name('book.city2');


    Route::get('/get_city_results.php', function () {
        return view('old.get_city_results', ['id' => $_GET['id']]);
    });
    Route::get('/get_city_results', function () {
        return view('old.get_city_results', ['id' => $_GET['id']]);
    });

    Route::get('/ie/{year}/{id}', function($id, $year) {
	return view('old.draw_ie', [ 'year' => $year, 'id' => $id ] );
    });

    /*
     * District Fed
     * */
    Route::get('/get_fed_page_b', function() {
        return redirect()->route('book.fed', ['id' => $_GET['id']]);
    });
    Route::get('/get_fed_page_b_t', function() {
        return redirect()->route('book.fed', ['id' => $_GET['id']]);
    });
    Route::get('/district-fed/{id}', function($id) {
        return view('old.get_fed_page_b', ['id' => $id]);
    })->name('book.fed');

    /*
     * Counties
     * */

    Route::get('/county2/{id}', function($id) {
        return view('old.get_county_page_b', ['id' => $id]);
    })->name('book.county2');

    Route::get('/county/{id}', function($id) {
        return view('old.county_page', ['id' => $id]);
    })->name('book.county');

    Route::get('/get_county_all', function () {
        return view('old.get_county_all', ['county' => $_GET['id']]);
    });
    Route::get('/get_county_all.php', function () {
        return view('old.get_county_all', ['county' => $_GET['id']]);
    });


    /*
     * FPPC Candidate
     * */

    Route::get('/cand/{id}', function($id) {
        return view('old.get_cand_page_t', ['id' => $id]);
    })->name('book.cand');

    /*
     * CA Campaign Finance Statement
     * */

     Route::get('/f460/{id}', function($id) {
         return view('old.cmlocal2', ['id' => $id]);
     })->name('book.f460');

    //CALIFORNIA DISTRICT PAGE COMPONENTS
    Route::get('/get_cal_org', function () { return view('old.get_cal_org'); });


    //REPORT GENERATOR (CENSUS, ELECTION DETAIL, ETHNIC REGISTRATION, TURNOUT BY AGE, SEX, AND PARTY)
    Route::get('/direct', function () { return view('old.direct'); });

    //ELECTION DETAIL REPORT 2012 - 2016
    Route::get('/g16_sovdone_single', function () { return view('old.g16_sovdone_single'); });

    //INDEPENDENT EXPENDITURE IFRAME FOR A SINGLE ELECTION YEAR
    Route::get('/ie_single', function () { return view('old.ie_single'); });
    Route::get('/ie_state',  function () { return view('old.ie_state');  });
    Route::get('/ie_single2', function () { return view('old.ie_single2'); });
    Route::get('/ie_test', function () { return view('old.draw_ie'); });
    Route::get('/ie_test_old', function () { return view('old.draw_ie_old'); });



    //COUNTY-LEVEL
    Route::get('/get_county_page_b', function () { return view('old.get_county_page_b'); });
    Route::get('/get_supe_dist', function () { return view('old.get_supe_dist'); });


    //FEDERAL CONGRESSIONAL DISTRICT COMPONENTS
    Route::get('/get_fec_bio', function () { return view('old.get_fec_bio'); });
    Route::get('/get_fec_census_detail', function () { return view('old.get_fec_census_detail'); });
    Route::get('/get_fec_demographics', function () { return view('old.get_fec_demographics'); });
    Route::get('/get_fec_elec_table', function () { return view('old.get_fec_elec_table'); });
    Route::get('/get_fec_filed', function () { return view('old.get_fec_filed'); });
    Route::get('/get_fec_headshot', function () { return view('old.get_fec_headshot'); });
    Route::get('/get_fec_ies', function () { return view('old.get_fec_ies'); });
    Route::get('/get_fec_ies2', function () { return view('old.get_fec_ies2'); });
    Route::get('/get_fec_org', function () { return view('old.get_fec_org'); });
    Route::get('/get_fec_socialmedia', function () { return view('old.get_fec_socialmedia'); });
    Route::get('/get_fec_vote_table', function () { return view('old.get_fec_vote_table'); });
    Route::get('/get_fed_page_t', function () { return view('old.get_fed_page_t'); });
    Route::get('/housevote_bydist', function () { return view('old.housevote_bydist'); });

    //PROPOSITION PAGES

    Route::get('/prop_page_b', function () { return view('old.prop_page_b'); });
    Route::get('/pending_prop_page_b', function () { return view('old.pending_prop_page_b'); });
    Route::get('/pending_prop_financials', function () { return view('old.pending_prop_financials'); });

    Route::get('/propositions/{id}', 'Book\PropositionController@show')
        ->name('book.propositions.show');

    //REDISTRICTING HUB
    Route::get('/redistricting', function () { return view('old.redistricting_hub'); });


    //PAST ELECTION RESULTS
    Route::get('/election_results', function () { return view('old.election_results'); });

    //PAST REGISTRATION/ELECTION RESULTS BY COUNTY SUBDIVISION
    Route::get('/get_county_sub2', function () { return view('old.get_county_sub2'); });

    //DIRECTORY OF ARCHIVED CALIFORNIA STATEMENTS OF VOTE 1952 - 2018 IN PDF FORM
    Route::get('/past_sov', function () { return view('old.past_sov'); });

    Route::get('/get_city_census', function () { return view('old.get_city_census'); });
    Route::get('/get_city_demographics', function () { return view('old.get_city_demographics'); });
    Route::get('/get_city_results', function () { return view('old.get_city_results'); });
    Route::get('/get_county_all', function () { return view('old.get_county_all'); });



    Route::get('/fed_browser', function () { return view('old.fed_browser'); });
    Route::get('/spending_history', function () { return view('old.spending_history'); });
    Route::get('/list_house_cands', function () { return view('old.list_house_cands'); });



//    Route::get('/expired', function () { return view('old.expired'); });
//    Route::get('/p16_mapped_ad', function () { return view('old.p16_mapped_ad'); });
//    Route::get('/pri_vs_gen', function () { return view('old.pri_vs_gen'); });



    /*
     * Untouched ports of old pages via iframe
     * */


    Route::get('/e18_house_target_financials', function () { return view('old.e18_house_target_financials'); });

    Route::get('/ca_registration_feb_2019', function () { return view('old.ca_registration_feb_2019'); });
    Route::get('/ca_registration_nov_2018', function () { return view('old.ca_registration_nov_2018'); });
    Route::get('/ca_registration_oct_2018', function () { return view('old.ca_registration_oct_2018'); });
    Route::get('/ca_registration_feb_2017', function () { return view('old.ca_registration_feb_2017'); });
    Route::get('/ca_registration_feb_2018', function () { return view('old.ca_registration_feb_2018'); });
    Route::get('/ca_registration_apr_2018', function () { return view('old.ca_registration_apr_2018'); });
    Route::get('/ca_registration_may_2018', function () { return view('old.ca_registration_may_2018'); });
    Route::get('/ca_registration_oct_2016', function () { return view('old.ca_registration_oct_2016'); });
    Route::get('/ca_registration_sep_2016', function () { return view('old.ca_registration_sep_2016'); });
    Route::get('/ca_registration_jul_2016', function () { return view('old.ca_registration_jul_2016'); });
    Route::get('/p18_hub', function () { return view('old.p18_hub'); });
    Route::get('/g18_hub', function () { return view('old.g18_hub'); });
    Route::get('/p20_hub', function () { return view('old.p20_hub'); });
    Route::get('/g20_hub', function () { return view('old.g20_hub'); });
    Route::get('/party_spend', function () { return view('old.ca_e20_party_target_summary'); });
    Route::get('/past_county', function () { return view('old.past_county'); });
    Route::get('/compare_past_legislative_registration', function () { return view('old.compare_past_legislative_registration'); });
    Route::get('/compare_past_legislative_registration_detailed', function () { return view('old.compare_past_legislative_registration_detailed'); });
    Route::get('/compare_past_city_registration', function () { return view('old.compare_past_city_registration'); });
    Route::get('/vote_progress', function () { return view('old.vote_count_nav'); });
    Route::get('/f497', function () { return view('old.weekly_f497'); });
    Route::get('/newsom_recall', function () { return view('old.newsom_recall_2021'); });




    Route::get('/fed_spending_2017_2018_ca', function () { return view('old.fed_spending_2017_2018_ca'); });
    Route::get('/fed_spending_2017_2018_all', function () { return view('old.fed_spending_2017_2018_all'); });
    Route::get('/fed_spending_2020_ca', function () { return view('old.fed_spending_2020_ca'); });
    Route::get('/fed_spending_2020_all', function () { return view('old.fed_spending_2020_all'); });


    Route::get('/city_and_county_past_all', function () { return view('old.city_and_county_past_all'); });
    Route::get('/city_past_all', function () { return view('old.city_past_all'); });
    Route::get('/county_past_all', function () { return view('old.county_past_all'); });
    Route::get('/cityreg_past_all', function () { return view('old.cityreg_past_all'); });


    Route::get('/fppc_county_party', function () { return view('old.fppc_county_party'); });
    Route::get('/fppc_all', function () { return view('old.fppc_all'); });
    Route::get('/fppc_legislator_ballot_cmtes', function () { return view('old.fppc_legislator_ballot_cmtes'); });
    Route::get('/fppc_past_prop_spending', function () { return view('old.fppc_past_prop_spending'); });
    Route::get('/fppc_active', function () { return view('old.fppc_active'); });
    Route::get('/f3_summaries', function () { return view('old.f3_summaries'); });
    Route::get('/fec_act_blue', function () { return view('old.fec_act_blue'); });
    Route::get('/fec_act_blue_monthly', function () { return view('old.fec_act_blue_monthly'); });
    Route::get('/fec_cmte_directory', function () { return view('old.fec_cmte_directory'); });
    Route::get('/e20_prop_financials', function () { return view('old.e20_prop_financials'); });
    Route::get('/e20_prop_financials2', function () { return view('old.e20_prop_financials2'); });
    Route::get('/fppc_top_lobby', function () { return view('old.fppc_top_lobby'); });

    Route::get('/targets', function () { return view('old.current_targets'); });

    Route::get('/ca_census_compare', function () { return view('old.ca_census_compare'); });
    Route::get('/us_census_compare', function () { return view('old.us_census_compare'); });


    Route::get('/ca_census_compare', function () { return view('old.ca_census_compare'); });
    Route::get('/us_census_compare', function () { return view('old.us_census_compare'); });
    Route::get('/apr3_special_draw', function () { return view('old.apr3_special_draw'); });
    Route::get('/dist_ads', function () { return view('old.dist_ads'); });
    Route::get('/campaign_ads', function () { return view('old.campaign_ads'); });
    Route::get('/dist_ads_panel', function () { return view('old.dist_ads_panel'); });
    Route::get('/uv', function () { return view('old.uv'); });
    Route::get('/f6_by_donor', function () { return view('old.f6_by_donor'); });
    Route::get('/f6_by_cmte', function () { return view('old.f6_by_cmte'); });

    Route::get('/incumbent_nav', function () { return view('old.incumbent_nav'); });

    Route::get('/commissioners', function () { return view('old.commissioners'); });
    Route::get('/redist_timelines', function () { return view('old.redist_timelines'); });

    Route::get('/viz_sd_a_laco', function () { return view('old.viz_sd_a_laco'); });
    Route::get('/viz_sd_a_socal', function () { return view('old.viz_sd_a_socal'); });
    Route::get('/viz_sd_a_norcal', function () { return view('old.viz_sd_a_norcal'); });
    Route::get('/viz_sd_a_coast', function () { return view('old.viz_sd_a_coast'); });
 
    Route::get('/viz_sd_b_laco', function () { return view('old.viz_sd_b_laco'); });
    Route::get('/viz_sd_b_socal', function () { return view('old.viz_sd_b_socal'); });
    Route::get('/viz_sd_b_norcal', function () { return view('old.viz_sd_b_norcal'); });
    Route::get('/viz_sd_b_coast', function () { return view('old.viz_sd_b_coast'); });



    Route::get('/viz_ad_a_laco', function () { return view('old.viz_ad_a_laco'); });
    Route::get('/viz_ad_a_socal', function () { return view('old.viz_ad_a_socal'); });
    Route::get('/viz_ad_a_norcal', function () { return view('old.viz_ad_a_norcal'); });
    Route::get('/viz_ad_a_coast', function () { return view('old.viz_ad_a_coast'); });
 
    Route::get('/viz_ad_b_laco', function () { return view('old.viz_ad_b_laco'); });
    Route::get('/viz_ad_b_socal', function () { return view('old.viz_ad_b_socal'); });
    Route::get('/viz_ad_b_norcal', function () { return view('old.viz_ad_b_norcal'); });
    Route::get('/viz_ad_b_coast', function () { return view('old.viz_ad_b_coast'); });


    Route::get('/viz_cd_a_laco', function () { return view('old.viz_cd_a_laco'); });
    Route::get('/viz_cd_a_socal', function () { return view('old.viz_cd_a_socal'); });
    Route::get('/viz_cd_a_norcal', function () { return view('old.viz_cd_a_norcal'); });
    Route::get('/viz_cd_a_coast', function () { return view('old.viz_cd_a_coast'); });
 
    Route::get('/viz_cd_b_laco', function () { return view('old.viz_cd_b_laco'); });
    Route::get('/viz_cd_b_socal', function () { return view('old.viz_cd_b_socal'); });
    Route::get('/viz_cd_b_norcal', function () { return view('old.viz_cd_b_norcal'); });
    Route::get('/viz_cd_b_coast', function () { return view('old.viz_cd_b_coast'); });



    /*
     * District Ads
     * */

    Route::get('/ads/{id}', function($id) {
        return view('old.dist_ads', ['id' => $id]);
    })->name('book.ads');


    /*
     * Endpoints from .php files
     * */
    Route::get('/ca_cand_autocomplete', function () {return view('old.ca_cand_autocomplete');});
    Route::get('/fec_cand_autocomplete', function () { return view('old.fec_cand_autocomplete'); });
    Route::get('/get_ca_roster.php', function () { return view('old.get_ca_roster'); });
    Route::get('/get_ca_roster', function () { return view('old.get_ca_roster'); });
    Route::get('/get_cds', function () { return view('old.get_cds'); });
    Route::get('/get_subdivisions', function () { return view('old.get_subdivisions'); });
    Route::get('/get_subdivisions2', function () { return view('old.get_subdivisions2'); });
    Route::get('/get_us_roster', function () { return view('old.get_us_roster'); });
    Route::get('/precinct_test_t', function () { return view('old.precinct_test_t'); });


    Route::get('/live_hub', function () {
        return view('old.live_hub');
    })->name('book.live_hub');

   Route::get('/viz2/{type}/{geo}', function($type, $geo) {
	return view('old.viz2', [ 'type' => $type, 'geo' => $geo ] );
    });

   Route::get('/viz3/{type}/{geo}', function($type, $geo) {
	return view('old.viz3', [ 'type' => $type, 'geo' => $geo ] );
    });

   Route::get('/viz4/{type}/{geo}', function($type, $geo) {
	return view('old.viz4', [ 'type' => $type, 'geo' => $geo ] );
    });

   Route::get('/draft/{type}/{geo}', function($type, $geo) {
	return view('old.viz5', [ 'type' => $type, 'geo' => $geo ] );
    });

   Route::get('/viz6/{type}/{geo}', function($type, $geo) {
	return view('old.viz6', [ 'type' => $type, 'geo' => $geo ] );
    });

   Route::get('/viz7/{type}/{geo}', function($type, $geo) {
	return view('old.viz7', [ 'type' => $type, 'geo' => $geo ] );
    });



   Route::get('/block_report/{id}', function($id) {
	return view('old.block_report', [ 'id' => $id ] );
    });

   Route::get('/block_report_v1208/{id}', function($id) {
	return view('old.block_report_v1208', [ 'id' => $id ] );
    });

   Route::get('/block_report_v1217/{id}', function($id) {
	return view('old.block_report_v1217', [ 'id' => $id ] );
    });

   Route::get('/block_report_v1218/{id}', function($id) {
	return view('old.block_report_v1218', [ 'id' => $id ] );
    });


   Route::get('/map_analysis', function () { return view('old.map_analysis'); });
   Route::get('/draft_map_v1_summary', function () { return view('old.draft_map_v1_summary'); });
   Route::get('/draft_map_v1_cvap', function () { return view('old.draft_map_v1_cvap'); });
   Route::get('/draft_map_v1_interactive', function () { return view('old.draft_map_v1_interactive'); });
   Route::get('/draft_map_viz_1206_summary', function () { return view('old.draft_map_viz_1206_summary'); });
   Route::get('/draft_map_viz_1206_cvap', function () { return view('old.draft_map_viz_1206_cvap'); });
   Route::get('/draft_map_viz_1206_interactive', function () { return view('old.draft_map_viz_1206_interactive'); });

   Route::get('/draft_map_viz_1208_summary', function () { return view('old.draft_map_viz_1208_summary'); });
   Route::get('/draft_map_viz_1208_cvap', function () { return view('old.draft_map_viz_1208_cvap'); });
   Route::get('/draft_map_viz_1208_interactive', function () { return view('old.draft_map_viz_1208_interactive'); });

   Route::get('/draft_map_viz_1211_summary', function () { return view('old.draft_map_viz_1211_summary'); });
   Route::get('/draft_map_viz_1211_cvap', function () { return view('old.draft_map_viz_1211_cvap'); });
   Route::get('/draft_map_viz_1211_interactive', function () { return view('old.draft_map_viz_1211_interactive'); });

   Route::get('/draft_map_viz_1217_summary', function () { return view('old.draft_map_viz_1217_summary'); });
   Route::get('/draft_map_viz_1217_cvap', function () { return view('old.draft_map_viz_1217_cvap'); });
   Route::get('/draft_map_viz_1217_interactive', function () { return view('old.draft_map_viz_1217_interactive'); });

   Route::get('/draft_map_viz_1218_summary', function () { return view('old.draft_map_viz_1218_summary'); });
   Route::get('/draft_map_viz_1218_cvap', function () { return view('old.draft_map_viz_1218_cvap'); });
   Route::get('/draft_map_viz_1218_interactive', function () { return view('old.draft_map_viz_1218_interactive'); });

   Route::get('/draft_map_viz_1220_summary', function () { return view('old.draft_map_viz_1220_summary'); });
   Route::get('/draft_map_viz_1220_cvap', function () { return view('old.draft_map_viz_1220_cvap'); });
   Route::get('/draft_map_viz_1220_interactive', function () { return view('old.draft_map_viz_1220_interactive'); });

   Route::get('/sandbox', function () { return view('sandbox'); });
   Route::get('/new_districts', function () { return view('old.new_districts'); });



   Route::get('/dashboard', function () { return view('old.dashboard'); });
   Route::get('/watchlist', function () { return view('old.p22_watchlist'); });
   Route::get('/list', function () { return view('old.list22'); });
   Route::get('/open', function () { return view('old.open22'); });
   Route::get('/calendar', function () { return view('old.calendar'); });
   Route::get('/ballots', function () {return view('old.draw_all_e22_ballots'); });




});


/**
 * Legacy server is not https,
 *  so it can't be embedded into the pages.
 *
 * This will proxy that server, so the requests can be https
 */
Route::group(['prefix' => 'ctb-legacy'], function() {
    Route::get('/{path}', 'LegacyController@index')
        ->where('path', '(.*)');
});


Route::group([
        'prefix' => 'ctb-admin',
        'middleware' => ['auth', 'admin'],
    ], function() {

        Route::get('/new-subscription', 'AdminController@newSubscription');
        Route::get('/', 'AdminController@index');
        Route::get('/{file}', 'AdminController@index')
            ->where('file', '(.*)');

});


/**
 * Redirects for legacy
 *  Separated for organization
 */
$redirects = [
    // old candidates routes
    '/book/candidates_hub' => '/book/candidates',
    '/book/ca_cand_directory' => '/book/candidates/directory/ca',
    '/book/candidate_directory_all' => '/book/candidates/directory',
    '/book/e18_roster' => '/book/candidates/2018/roster',
    '/book/ca_candidates_e18_summary' => '/book/candidates/2018/summary',
    '/book/ca_e20_finance_summary' => '/book/candidates/2020/summary',
    '/book/house_cand_nav' => '/book/candidates/directory/house',
    '/book/e18_watchlist' => '/book/candidates/2018/watchlist',
    '/book/e20_watchlist' => '/book/candidates/2020/watchlist',
    '/book/viz_rpt/{id}' => '/ctb-legacy/block_results?id={$id}'

];

foreach ($redirects as $start => $end) {
    Route::get($start, function () use ($end) {
        return redirect($end);
    });
}

Route::post('/account/delete', function(\Illuminate\Http\Request $request) {
    $user = auth()->user();
    
    if ($user) {
        // Soft delete the user by setting deleted_at to now()
        \Illuminate\Support\Facades\DB::table('users')
            ->where('id', $user->id)
            ->update(['deleted_at' => now()]);
            
        // Log out the user if they were using session auth
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
            
        return response()->json(['success' => true]);
    }
    
    return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
});
Route::post('/submit-subscription', 'Auth\RegisterController@submitSubscription')->name('submit-subscription');
