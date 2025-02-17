@extends('layouts/head')
@section('content')
    </div>
    <br>
    <div class="h-[50rem]">
        <div
            class="dark:shadow-gray-500/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-4/5 m-auto h-full mt-7 rounded">
            <br>
            <h1 class="tracking-tight 2xl:text-[42px] xl:text-4xl; lg:text-3xl p-4"> Ping Statistics </h1>
            <div id="container" class="mt-8 m-auto w-4/5 bg-gray-100 dark:bg-[#2D3442] h-[40rem]">
                <div id="main" class="absolute mt-10 mb-10 ml-5 m-auto h-[50%]"></div>
            </div>
        </div>
    </div>
    <script type="module" src="/js/PingChart.js"></script>
    </body>
@endsection
