@extends('layouts.head')

@section('content')
    @php
        $providersHosts = [];

        foreach ($host as $providerhost) {
            $providerID = $providerhost->provider_id;
            $hostname = $providerhost->name;
            $errorColorClass = '';
            $errorForHostname = $error->where('host_name', $hostname)->first();

            if ($errorForHostname && $errorForHostname->error == 'No response') {
                $errorColorClass = 'bg-red-500';
            }

            $providersHosts[$providerID][] = [
                'name' => $hostname,
                'location' => $providerhost->location,
                'type' => $providerhost->type,
                'errorColorClass' => $errorColorClass,
                'ip' => $providerhost->ip,
            ];
        }
    @endphp
    <style>
        .navbar {
            display: none;
        }      
    </style>
    <div class="h-[100%] -mt-8">
        <div class="container-all fixed-container marquee {{ $errorColorClass }}">
            <p class="h-10 pt-2" id="message">
                {{ $message }}
            </p>
        </div>
        <div class="mt-20">
            @foreach ($provider as $providers)
                @php
                    $totalHosts = count($providersHosts[$providers->id]);
                    $onlineHosts = count($providersHosts[$providers->id]);

                    foreach ($providersHosts[$providers->id] as $providerhost) {
                        $errorForHost = $error->where('host_name', $providerhost['name'])->first();
                        if ($errorForHost && $errorForHost->error == 'Timed out') {
                            $onlineHosts--;
                        }
                    }
                    $TotalOnline = $onlineHosts . '/' . $totalHosts;
                @endphp

                <h2 class="text-xl font-semibold mb-2">{{ $providers->name }}. Online: {{ $TotalOnline }}</h2>
                <div class="flex flex-wrap server-box-container">
                    @foreach ($providersHosts[$providers->id] as $providerhost)
                        @if (isset($ping[$providerhost['name']]))
                            @php
                                $pingValue = $ping[$providerhost['name']];
                                $hasError = $pingValue < 0 || $pingValue > 120;
                            @endphp
                            <a class="overflow-x-hidden overflow-y-hidden w-40 h-25 p-4 m-4 bg-[#393F4C] dark:bg-[#393F4C] text-white rounded ml- relative">
                                <div class="flex flex-col">
                                    <div id='msg-{{ $providerhost['name'] }}' class="z-10 absolute"
                                        style="right: 10px; width: 20px; height: 20px; border-radius: 100%; font-size: 18px; line-height: 20px; top: 4px;">
                                    </div>
                                    <span id="error-{{ $providerhost['name'] }}"
                                        class="w-full h-2 rounded-md flex items-center justify-center ping-indicator">
                                    </span>
                                    <p class="mt-2 text-white text-lg underline mb-2">{{ $providerhost['name'] }}</p>
                                    <p class="text-white"> {{ $providerhost['location'] }}</p>
                                    <div class='flex flex-row justify-center space-x-2'>
                                        <div id="ping-{{ $providerhost['name'] }}" class="text-white ">
                                            {{ $pingValue === 'N/A' ? 'N/A' : $pingValue }} ms</div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <a class=' rounded underline -mt-[60px] ml-[20px]' href="/dashboard">dashboard</a>
    <script src="/js/static.js"></script>
@endsection
