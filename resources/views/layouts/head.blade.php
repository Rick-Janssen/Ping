<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Ping
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../dist/output.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon"
        href="https://i.pinimg.com/originals/7e/09/89/7e0989257ba16af335d0e9499494ac6a.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Hebrew&family=Libre+Barcode+39+Extended&family=Oswald&family=Roboto+Slab:wght@300&family=Sanchez&display=swap"
        rel="stylesheet">
    <script src=" https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js "></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="/js/index.js"></script>
    <script src="https://kit.fontawesome.com/356eec8587.js" crossorigin="anonymous"></script>
    
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-300 dark:bg-[#2D333F] text-center text-black dark:text-white font-test">
    @include('layouts/flash-message')
    @if (Auth::check())
        <div class="menu">
            <a class="menu-item text-black dark:text-white" href="/home"><i class="fas fa-house"></i> Home</a>
            <a class="menu-item text-black dark:text-white" href="/dashboard"><i class="fas fa-gauge-simple-high"></i>
                Dashboard</a>
            <a class="menu-item text-black dark:text-white" href="/map"><i class="fa-solid fa-map"></i> Map</a>
            <a href="{{ route('account.settings') }}" class="menu-item text-black dark:text-white"><i
                    class="fa-solid fa-wrench"></i> Settings</a>
            @can('admin-access', Auth::user())
                <a class="menu-item text-black dark:text-white" href="/admin"><i
                        class="fa-solid fa-screwdriver-wrench"></i> Admin</a>
            @endcan
            <a class="menu-item-logout" href="/users/logout">
                <i class="fa-solid fa-right-from-bracket text-red-500"></i> Logout</a>
        </div>
        <div class="navbar">
            <div
                class="sticky top-0 dark:shadow-gray-500/30 dark:shadow-sm shadow-md mt-7 w-[80%] m-auto bg-white dark:bg-[#262C38] xl:h-[4rem] lg:h-[4rem] md:h-[4rem] sm:h-[3rem] rounded-sm z-10">
                <div class="menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <div class="flex flex-row md:flex-column float-left ml-8"> <a
                        class="navbar-item mt-3 transition duration-250 ease-in-out hover:scale-105 text-black dark:text-white rounded-sm h-10 p-2"
                        href="/home">
                        <i class=" fa-solid fa-house"></i> Home</a>
                </div>
                <div class="flex flex-row float-right mr-8">
                    <a class="navbar-item  mt-3  transition duration-250 ease-in-out  hover:scale-105 text-black dark:text-white rounded-sm h-10 p-2 mr-8"
                        href="/dashboard">
                        <i class="fa-solid fa-gauge-simple-high"></i> Dashboard</a>
                    <a class="navbar-item  mt-3  transition duration-250 ease-in-out  hover:scale-105 text-black dark:text-white rounded h-10 p-2 mr-8"
                        href="/map">
                        <i class="fa-solid fa-map"></i> Map</a>
                    <div class="dropdown relative inline-block text-left float-right mr-8 mt-3">
                        <button id="account-dropdown">
                            <div
                                class="button transition duration-250 ease-in-out hover:scale-105 text-black dark:text-white ">
                                <i class="fa-solid fa-user text-black dark:text-white"></i>
                                Account
                            </div>
                        </button>
                        <div id="account-dropdown-menu" class="dropdown-menu">
                            <a href="{{ route('account.settings') }}" class="menu-item text-black dark:text-white"><i
                                    class="fa-solid fa-wrench"></i> Settings</a>
                            @can('admin-access', Auth::user())
                                <a href="/admin" class="menu-item text-black dark:text-white"><i
                                        class="fa-solid fa-screwdriver-wrench p-1"></i>Admin</a>
                            @endcan
                            <a href="/users/logout" class="menu-item-logout logout"> <i
                                    class="fa-solid fa-right-from-bracket p-1"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @yield('content')
