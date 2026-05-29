<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handle Static resources
 */

class ResourceController extends Controller
{
    /**
     * Load a pdf from the docs/ folder
     */
    public function index($file = null)
    {
        $filename='';
        if ($file == null)
            abort(404);
    
        $path = resource_path('views') . '/docs/' . $file;
            
        if (file_exists($path)) {

            return \Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);

        } else {
            abort(404);
        }
    
    }
    
}
