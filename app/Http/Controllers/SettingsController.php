<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        $formFields = $request->validate([
            'maxPing' => 'required|numeric|min:0|max:1000',
            'max_consecutive_errors' => 'required|numeric|min:0|max:10',
        ]);


        Settings::update($formFields);

        return redirect('/account-settings')->with('message', 'Settings updated successfully!');
    }
}
