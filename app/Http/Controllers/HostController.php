<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\Host;
use App\Models\Hour;
use App\Models\Ping;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class HostController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'max:40', Rule::unique('hosts', 'name')],
        'ip' => ['required', 'max:40', 'ip'],
        'location' => ['required', 'max:40'],
        'type' => ['required'],
        'provider' => ['required'],
    ]);

    list($providerId, $providerName) = explode(',', $request->provider);

    $host = new Host([
        'name' => $request->name,
        'ip' => $request->ip,
        'location' => $request->location,
        'type' => $request->type,
        'provider_id' => $providerId,
        'provider_name' => $providerName,
    ]);

    $host->save();

    return redirect('/admin')->with('message', 'Host Created successfully');
}
    public function destroy($hostId)
    {
        Host::where('id', $hostId)->delete();
        Ping::where('host_id', $hostId)->delete();
        Error::where('host_id', $hostId)->delete();
        return redirect('/admin')->with('message', 'Host deleted successfully');
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required'],
            'ip' => ['required', 'max:40', 'ip'],
            'location' => ['required', 'max:40'],
            'type' => ['required'],
            'provider_id' => ['required'],
        ]);
        $formFields['updated_at'] = now();


        Host::where('name', $request->name)
            ->update($formFields);

        return redirect('/admin')->with('message', 'Host updated successfully!');
    }
    public function show($hostName)
    {
        $host = Host::where('name', $hostName)->firstOrFail();
        $hourlyData = Hour::where('host_name', $hostName)->orderBy('created_at', 'asc')->get();
        return view('hosts.show', compact('host', 'hourlyData'));
    }
    public function showEdit($hostName)
    {
        $provider = Provider::all();
        $host = Host::all();
        $currenthost = Host::where('id', $hostName)->get();
        return view('hosts.edit', compact('provider', 'host', 'currenthost'));
    }
    public function showCreate(){
        $providers = Provider::all();
        return view('hosts.create', compact('providers'));
    }
}
