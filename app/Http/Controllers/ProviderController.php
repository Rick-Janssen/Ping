<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Ping;
use App\Models\Error;
use App\Models\provider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:40', Rule::unique('providers', 'name')],
        ]);

        Provider::create($formFields);

        return redirect('/admin')->with('message', 'Provider Created');
    }

    public function destroy($providerId)
    {
        Provider::where('id', $providerId)->delete();
        $hosts = Host::where('provider_id', $providerId)->get();
        foreach ($hosts as $host) {
            Ping::where('host_id', $host->id)->delete();
            Error::where('host_id', $host->id)->delete();
        }
        Host::where('provider_id', $providerId)->delete();

        
        return redirect('/admin')->with('message', 'Provider deleted successfully');
    }
    public function showCreate(){
        return view('providers/create');
    }
}
