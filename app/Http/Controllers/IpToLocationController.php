<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Host;
use App\Models\Ping;
use Illuminate\Support\Facades\Auth;

class IpToLocationController extends Controller
{
    public function getLocation(Request $request)
    {
        $hostsInfo = Host::get();

        $geolocationData = [];

        foreach ($hostsInfo as $hostInfo) {
            $ipAddress = $hostInfo->ip;

            $latestPing = Ping::select('ms')
                ->where('host_id', $hostInfo->id)
                ->orderBy('created_at', 'DESC')
                ->first();


            $client = new Client();
            $response = $client->get("http://ip-api.com/json/{$ipAddress}");
            $data = json_decode($response->getBody(), true);

            if (!empty($data['lat']) && !empty($data['lon'])) {
                $latitude = $data['lat'];
                $longitude = $data['lon'];
                $hostName = $hostInfo->name;
            }
            $goodms = $latestPing ? $latestPing->ms : null;

            $geolocationData[] = [
                'id' => $hostInfo->id,
                'lat' => $latitude,
                'lon' => $longitude,
                'host_name' => $hostName,
                'ms' => $goodms,
            ];
        }

        return view('maps/map', ['geolocationData' => $geolocationData]);
    }

    public function legacymap()
    {
        $userId = Auth::id();

        $hostsInfo = Host::get();

        $geolocationData = [];

        foreach ($hostsInfo as $hostInfo) {
            $ipAddress = $hostInfo->ip;

            $latestPing = Ping::select('ms')
                ->where('host_id', $hostInfo->id)
                ->orderBy('created_at', 'DESC')
                ->first();


            $client = new Client();
            $response = $client->get("http://ip-api.com/json/{$ipAddress}");
            $data = json_decode($response->getBody(), true);

            if (!empty($data['lat']) && !empty($data['lon'])) {
                $latitude = $data['lat'];
                $longitude = $data['lon'];
                $hostName = $hostInfo->name;
            }

            $goodms = $latestPing ? $latestPing->ms : null;

            $geolocationData[] = [
                'id' => $hostInfo->id,
                'lat' => $latitude,
                'lon' => $longitude,
                'host_name' => $hostName,
                'ms' => $goodms,
            ];
        }

        return view('maps/legacymap', ['geolocationData' => $geolocationData,]);
    }
}
