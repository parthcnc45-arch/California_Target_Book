<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function newSubscription()
    {
        return view('admin.new_subscription');
    }

    public function index(string $file = null)
    {
        if ($file == null) {
            return view('admin.index', ['admin_user' => Auth::user()]);
        }

        $path = resource_path('views') . '/admin/' . $file;

        if (file_exists($path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path);

            $extension = pathinfo($path, PATHINFO_EXTENSION);
            switch ($extension) {
                case 'css':
                    $mime = 'text/css';
                    break;
                case 'js':
                    $mime = 'application/javascript';
                default:
                    break;
            }

            finfo_close($finfo);
            return \Response::make(file_get_contents($path), 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $file . '"',
            ]);
        }

        return view('admin.index', [
            'admin_user' => Auth::user(),
        ]);
    }
}
