@extends('layouts/head')

@section('content')
    <div>
        <canvas class="webgl"></canvas>
        <a class='-ml-12 rounded bg-sky-500 h-[50px] w-[150px] shadow-sm shadow-gray-500 p-2 font-bold text-2xl m-auto mt-5 text-center text-white scale-up-on-hover absolute '
            type='submit' href="/legacymap">2D map?</a>
    </div>
    <script>
        const geolocationData = @json($geolocationData);
        const webglElement = document.querySelector('.webgl');
        webglElement.setAttribute('data-geolocation-data', JSON.stringify(geolocationData));
        //console.log(geolocationData)
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.min.js"></script>
    <script type="module" src="/js/globe.js"></script>
    </body>

    </html>
@endsection
