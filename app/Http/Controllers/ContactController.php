<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessageFrom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    const contacts = [
        'corey' => 'corey@coreysery.io',
        'darry' => 'darry@californiatargetbook.com',
        'tom' => 'tom@californiatargetbook.com',
        'roxanne' => 'roxanne@californiatargetbook.com',
        'rob' => 'rpyers@gmail.com',
    ];

    public function send(Request $request) {
        $data = $request->all();
        $val = Validator::make($data, [
            'from_name' => 'string|required',
            'from_email' => 'string|required|email',
            'subject' => 'string|required',
            'message' => 'string|required',
            'to' => [
                'string',
                'required',
                Rule::in(array_keys(self::contacts)),
            ]
        ]);
        $val->validate();

        $admin = self::contacts[$data['to']];

        dispatch(new SendMessageFrom($admin, $data));

        return 1;
    }

}
