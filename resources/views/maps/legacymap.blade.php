@extends('layouts/head')

@section('content')

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    </head>
    <br>
    <a class='-ml-24  rounded bg-sky-500 h-[50px] w-[150px] shadow-sm shadow-gray-500 p-2 font-bold text-2xl mt-5 text-center text-white scale-up-on-hover absolute'
        type='submit'href="/map">3D map?</a> <br><br><br><br>
    <div
        class="container dark:shadow-gray-500/30 dark:shadow-sm shadow-md w-[80%] m-auto bg-white dark:bg-[#262C38] rounded">

        <br>
        <div id="map" class="m-auto w-[70%] h-[35rem] bg-white dark:bg-[#272C58] z-0"></div>
        <br><br>
    </div>

    <script>
        var geolocationData = @json($geolocationData)
    </script>
    <script src="/js/map.js"></script>
    </body>

    </html>
@endsection
