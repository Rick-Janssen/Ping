@extends('layouts.head')

@section('content')
    @php
        $providersHosts = [];

        $hostnames = [];
        foreach ($host as $providerhost) {
            $hostnames[] = $providerhost->name;
        }

        foreach ($host as $providerhost) {
            $providerID = $providerhost->provider_id;
            $hostname = $providerhost->name;
            $errorColorClass = 'bg-gray-800';

            if (in_array($hostname, $hostnames)) {
                $errorForHostname = $error->where('host_name', $hostname)->first();

                if ($errorForHostname) {
                    if ($errorForHostname->error == 'Timed out') {
                        $errorColorClass = 'bg-red-800';
                    } else {
                        $errorColorClass = 'bg-orange-500';
                    }
                }
            }

            $providersHosts[$providerID][] = [
                'name' => $hostname,
                'location' => $providerhost->location,
                'type' => $providerhost->type,
                'errorColorClass' => $errorColorClass,
            ];
        }
    @endphp
    <div class="h-[100%]">

        <br>
        <div
            class="container-all dark:shadow-white/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-4/5 m-auto h-full mt-7 rounded">
            <br>
            <h1 class="tracking-tight 2xl:text-[42px] xl:text-4xl; lg:text-3xl p-4">Dashboard</h1>
            <a class='p-1 rounded underline' href="/static">Static</a>
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Host Overview</h2>
                <div class="flex flex-wrap justify-center ">
                    @foreach ($provider as $providers)
                        @if (isset($providersHosts[$providers->id]))
                            @foreach ($providersHosts[$providers->id] as $host)
                                <a class="hostbox ml-2 mt-2
                                    @if ($host['errorColorClass'] === 'bg-green') bg-green
                                    @elseif ($host['errorColorClass'] === 'bg-red-800')bg-red-800
                                    @elseif ($host['errorColorClass'] === 'bg-orange-500')bg-orange-500
                                    @else
                                        bg-green @endif"
                                    href="{{ route('host.info', ['host' => $host['name']]) }}"data-host-name="{{ $host['name'] }}">
                                    <div class="text-center"></div>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="flex">
                <div
                    class="overflow-y-auto max-h-[75vh] min-h-[75vh] container-hosts mt-10 bg-stone-100 dark:bg-[#393F4C] w-[64%] rounded ml-6">
                    <div class="container-hosts w-full rounded text-black dark:text-white bg-[#c4c8ce] dark:bg-[#0a101e;]">
                        <input class="searchinhosts bg-[#c4c8ce] dark:bg-[#0a101e;] w-[100%] h-12 mt-px" type="text"
                            id="host-search" placeholder="  Search hosts...">
                    </div> <br>

                    @foreach ($provider as $providers)
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold mb-2">{{ $providers->name }}</h2>
                            <div class="flex flex-wrap">
                                @if (isset($providersHosts[$providers->id]))
                                    @foreach ($providersHosts[$providers->id] as $host)
                                        <a class="host-link mt-4 mb-4 rounded ml-2.5 w-[32%] {{ $host['errorColorClass'] }}"
                                            href="{{ route('host.info', ['host' => $host['name']]) }}">
                                            <div class="box-container">
                                                <p
                                                    class="text-black dark:text-white text-lg underline mb-2 host-name-style">
                                                    {{ $host['name'] }}
                                                </p>
                                                <p class="text-black dark:text-white">Location: {{ $host['location'] }}</p>
                                                <p class="text-black dark:text-white">Cable Type: {{ $host['type'] }}</p>
                                                <br>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="m-auto">No hosts available for this provider.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="container-errors mt-10 bg-stone-100 dark:bg-[#393F4C] w-[29%] rounded mr-6 ml-6 max-h-[75vh] min-h-[75vh] overflow-y-auto">
                    <br>
                    @foreach ($error as $item)
                        @if ($item->type == 'Error')
                            <form class="mb-4 bg-red-800 m-auto rounded w-[60%]" action="/errors/delete">
                                <input type="hidden" name="id" value="{{ $item->id }}" />
                                <button type="submit" name="{{ $item->id }}">
                                    <p class="text-black dark:text-white text-lg underline"> {{ $item->type }}</p>
                                    <div>{{ $item->host_name }} <br>
                                        ({{ $item->created_at }})
                                        {{ $item->error }}
                                    </div><br>
                                </button>
                            </form>
                        @elseif ($item->type == 'Warning')
                            <form class="mb-4 bg-orange-500 m-auto rounded w-[60%]" action="/errors/delete">
                                <input type="hidden" name="id" value="{{ $item->id }}" />
                                <button type="submit" name="{{ $item->id }}">
                                    <p class="text-black dark:text-white text-lg underline"> {{ $item->type }}</p>
                                    <div>{{ $item->host_name }} :
                                        ({{ $item->created_at }})<br>Warning: {{ $item->error }} <br>
                                        Average response time: {{ $item->ms }} ms
                                    </div>
                                    <br>
                                </button>
                            </form><br>
                        @endif
                    @endforeach
                    @foreach ($pasterrors as $pastError)
                        <form class="mb-4 bg-gray-500 m-auto rounded w-[60%] text-black dark:text-white"
                            action="/PastErrors/delete">
                            <input type="hidden" name="id" value="{{ $pastError->id }}" />
                            <button type="submit" name="{{ $pastError->id }}">
                                <p class="text-lg underline"> Past Error </p>
                                <div>{{ $pastError->host_name }} :
                                    ({{ $pastError->created_at }})
                                    <br>Error: {{ $pastError->error }} <br>
                                    Average response time: {{ $pastError->ms }} ms
                                </div>
                                <br>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
        <script src="/js/dashboard.js"></script>
    @endsection
