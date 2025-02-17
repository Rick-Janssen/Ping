@extends('layouts/head')
@section('content')
    <br>
    <br>
    <div class='w-[100%] m-auto'>
        <div
            class="container dark:shadow-white/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-4/5 m-auto h-full mt-7 rounded">
            <h1 class='text-2xl'>Hosts</h1>
            <table id='hostTable' class='w-full table-fixed table responsive hostTableResponsive'>
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Provider</td>
                        <td class='rowDisplay'>IP Address</td>
                        <td class="rowDisplay">Location</td>
                        <td class="rowDisplay">Type</td>
                        <td class='whitespace-nowrap w-[1%]'></td>
                        <td class='whitespace-nowrap w-[1%]'>
                            <a class='text-lime-500' href="/host/create">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div><br>
        <div class='w-[100%] m-auto'>
            <div class="container dark:shadow-white/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-4/5 m-auto h-full mt-7 rounded">
                <h1 class='text-2xl'>Providers</h1>
                <table id='providerTable'class='w-full table-fixed table responsive providerTableResponsive'>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>
                                <a class='text-lime-500 float-right' href="/provider/create">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <br>
            <br>
            <script src="/js/admin.js"></script>
        @endsection
