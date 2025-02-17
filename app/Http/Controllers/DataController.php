<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Host;
use App\Models\Hour;
use App\Models\Ping;
use App\Models\Error;
use App\Models\PastError;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DataController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $provider = Provider::get();
        $host = Host::get();
        $ping = Ping::where('ms', 'Timed Out')->latest('ms')->get();
        $error = Error::All();
        $hours = Hour::where('created_at', '>=', now()->subDay())->select('created_at', 'host_name', 'minMS', 'maxMS', 'avg')->get();
        $pasterrors = PastError::All();

        return view('dashboard', compact('provider', 'host', 'ping', 'error', 'hours', 'user', 'pasterrors'));
    }


    public function admin()
    {
        $job = Job::where('active', 1)->get();
        return view('admin', compact('job'));
    }
    public function home()
    {
        return view(
            'home'
        );
    }
    public function static()
    {

        $provider = Provider::get();
        $error = Error::All();
        $host = Host::get();
        $error = Error::latest()->get();

        $pingData = [];
        foreach ($host as $providerhost) {
            $latestPing = Ping::where('host_id', $providerhost->id)
                ->where('ms', 'not like', 'Timed Out')
                ->latest('created_at')
                ->first();

            if (!$latestPing) {

                $latestPing = Ping::where('host_id', $providerhost->id)
                    ->where('ms', 'not like', 'Timed Out')
                    ->latest('created_at')
                    ->first();
            }

            $msValue = $latestPing ? $latestPing['ms'] : 'N/A';

            $ping[$providerhost->name] = $msValue;
        }

        asort($ping);
        $messagecontent = '';
        $marqueeColor = 'background-color: #383f4c;';

        if ($error->isNotEmpty()) {
            $messagecontent = '';
            foreach ($error as $err) {
                $messagecontent .= "\n {$err->error} | {$err->host_name} on {$err->created_at->format('D d M')} at {$err->created_at->format(' H:i')}.\n";
                $marqueeColor = 'background-color: #d32323;';
            }
        } else {
            $messagecontent = "All is working properly";
            $marqueeColor;
        }

        $message = $messagecontent;
        return view('static', compact('provider', 'host', 'ping', 'error', 'message', 'marqueeColor'));
    }

    public function hostData(DataTables $dataTables)
    {
        $model = Host::query();
        $hosts = $dataTables->eloquent($model)->toJson();

        $originalData = json_decode($hosts->content(), true);

        $modifiedData = collect($originalData['data'])->map(function ($host) {
            $host['edit'] = '<a href="/host/edit/' . $host['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
            $host['delete'] = '<a onclick="message(' . $host['id'] . '); return false;" class="text-red-500" href="/hosts/delete/' . $host['id'] . '"><i class="fa-solid fa-trash"></i></a>';
            return $host;
        });

        $originalData['data'] = $modifiedData;
        return response()->json($originalData);
    }
    public function providerData(DataTables $dataTables)
    {
        $model = Provider::query();
        $providers = $dataTables->eloquent($model)->toJson();

        $originalData = json_decode($providers->content(), true);

        $modifiedData = collect($originalData['data'])->map(function ($provider) {
            $provider['delete'] = '<a onclick="message(' . $provider['id'] . '); return false;" class="text-red-500 float-right" href="/provider/delete/' . $provider['id'] . '"><i class="fa-solid fa-trash"></i></a>';
            return $provider;
        });

        $originalData['data'] = $modifiedData;
        return response()->json($originalData);
    }
    public function pingData()
    {

        $pingData = Ping::select('pings.host_name', 'pings.created_at', 'pings.ms')
            ->join('hosts', 'pings.host_id', '=', 'hosts.id')
            ->selectRaw('(SELECT COUNT(*) FROM pings as p2 WHERE p2.host_id = pings.host_id AND p2.id >= pings.id) as ping_count')
            ->whereRaw('(SELECT COUNT(*) FROM pings as p2 WHERE p2.host_id = pings.host_id AND p2.id >= pings.id) <= 50')
            ->orderBy('pings.host_id')
            ->orderByDesc('pings.created_at')
            ->get();

        $pingData = $pingData->reverse();

        $formattedData = [];
        foreach ($pingData as $ping) {
            $formattedData[] = [
                'date' => date('H:i', strtotime($ping->created_at)),
                'ping' => $ping->ms,
                'host_name' => $ping->host_name,
            ];
        }


        return compact('formattedData');
    }

    public function staticData()
    {
        $user = Auth::user();

        $provider = Provider::all();
        $error = Error::All();

        $host = Host::all();

        $pingData = [];
        foreach ($host as $providerhost) {
            $latestPing = Ping::where('host_id', $providerhost->id)
                ->where('ms', 'not like', 'Timed Out')
                ->latest('created_at')
                ->first();

            if (!$latestPing) {

                $latestPing = Ping::where('host_id', $providerhost->id)
                    ->where('ms', 'not like', 'Timed Out')
                    ->latest('created_at')
                    ->first();
            }

            $msValue = $latestPing ? $latestPing['ms'] : 'N/A';

            $ping[$providerhost->name] = $msValue;
        }

        asort($ping);
        $messagecontent = '';
        $marqueeColor = 'background-color: #383f4c;';

        if ($error->isNotEmpty()) {
            $messagecontent = '';
            foreach ($error as $err) {
                $messagecontent .= "\n {$err->error} | {$err->host_name} on {$err->created_at->format('D d M')} at {$err->created_at->format(' H:i')}.\n";
                $marqueeColor = 'background-color: #d32323;';
            }
        } else {
            $messagecontent = "All is working properly";
            $marqueeColor;
        }

        $message = $messagecontent;

        $error = Error::latest()->get();

        return compact('provider', 'host', 'ping', 'error', 'user', 'message', 'marqueeColor');
    }
}
