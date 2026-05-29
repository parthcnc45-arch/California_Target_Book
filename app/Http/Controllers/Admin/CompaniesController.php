<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Company;
use App\User;
use App\Jobs\SendSubscriptionMarkedPaid;

class CompaniesController extends Controller
{

    public function update(Request $request, $id) {
        $validation = [
            'name' => 'required|string|max:255',
            'address.line1' => 'required|string|max:255',
            'address.line2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.zip_code' => 'required|string|max:255',
        ];
        $data = $request->all();
        $val = Validator::make($data, $validation);
        $val->validate();

        $company = Company::with('address')->find($id);

        $company->update($data);

        if (!empty($data['address'])) {
            if ($company->address()->exists()) {
                $company->address()->update($data['address']);
            } else {
                $addr = $company->address()->create($data['address']);
                $company->address()->associate($addr);
                $company->save();
            }
        }

        return Company::with('address')->find($id);
    }

}
