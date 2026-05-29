<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DistrictTabController extends Controller
{
    public function loadContent(Request $request, $tab = null)
    {
        $viewName = 'old.district_20hs';

        switch ($tab) {
            case 'incumbent':
                $data['loadIncumbent'] = true;
                $viewName='old.incumbent_page_20';
                break;
            case 'campaigns':
                $data['loadCampaigns'] = true;
                $viewName='old.cal_campaigns_20';
                break;
            case 'hot-sheets':
                $data['loadHs'] = true;
                $viewName='old.district_20hs';;
                break;
            // Add more cases if needed

            default:
                // Handle other cases or throw an error
                break;
        }

        return view($viewName, $request->all());
    }

}
