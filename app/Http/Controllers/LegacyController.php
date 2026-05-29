<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

ini_set('memory_limit', '4048M');

/**
 * Provide proxy to CTB legacy server
 */

class LegacyController extends Controller
{

    public function index(Request $request, $resource)
    {

        $fullUrl = $request->fullUrl();
        $i = strpos($fullUrl, '?');
	$redirect = FALSE;

	$blacklist = Array("SELECT", "WHERE", "CHAR", "EVAL", "IFNULL", "FROM");

        if (is_numeric($i)) {
            $query = substr($fullUrl, $i);
        } else {
            $query = '';
        }

	foreach($blacklist as $bad) {
		if(strpos($query, $bad)) {
			$redirect = TRUE;
		}
	}

        Log::info($query);

	if($redirect) {
		$url = 'https://bobby-tables.com/';
		exit;
	} else {            
	        $url = "http://198.74.49.22/$resource" . $query;
	}
        Log::info($url);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        
        // if 404 check if php resource
        if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 404) {
            curl_close($curl);
            $curl = curl_init("http://198.74.49.22/$resource.php" . $query);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $data = curl_exec($curl);
        }

        $mime_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        curl_close($curl);

        return response($data)
            ->header('Content-Type', $mime_type);
    }

}
