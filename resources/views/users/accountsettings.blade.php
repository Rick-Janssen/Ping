@extends('layouts/head')
@section('content')
    <div
        class="dark:shadow-gray-500/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-4/5 m-auto h-full mt-7 rounded">
        <br>
        <h1 class='text-3xl'>{{ Auth::user()->name }}'s Account</h1>
        <br>

        <div class='text-center text-xl'>
            <div class="mb-2.5">
                <strong>Email:</strong>
                {{ Auth::user()->email }}
            </div>
            <div class="mb-2.5">
                <strong>Rank:</strong>
                {{ Auth::user()->rank }}
            </div>
            <div>
                <strong>Created at:</strong>
                {{ Auth::user()->created_at->format('d M Y') }}
            </div>
        </div>
        <br>
        <form class='flex flex-col items-center m-8'method='POST' action="/users/update">
            @csrf
            <h1 class='text-xl'>Change Password</h1>
            <br>
            <input type="hidden" name='email'
                value='{{ \App\Models\User::find(\Illuminate\Support\Facades\Auth::id())->email }}'>

            <div class='w-full relative'>
                <input placeholder='Old Password'
                    name='password'class='h-[80%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 text-black' type="password"
                    id='old-password-input'>
                <span class='text-black z-20 flex top-2 right-[36%] absolute items-center h-full cursor-pointer'
                    id='showOldPassword'></span>

            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <div class='w-full relative'>
                <input placeholder='New Password'
                    name='new_password'class='h-[80%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 text-black' type="password"
                    id='new-password-input'>
                <span class='text-black z-20 flex top-2 right-[36%] absolute items-center h-full cursor-pointer'
                    id='showNewPassword'></span>
            </div>
            @error('new_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <div class='w-full relative'>
                <input placeholder='Confirm New Password'
                    name='new_password_confirmation'class='h-[80%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 text-black'
                    type="password" id='confirm-new-password-input'>
                <span class='text-black z-20 flex top-2 right-[36%] absolute items-center h-full cursor-pointer'
                    id='showConfirmNewPassword'></span>
            </div>

            @error('new_password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button
                class='rounded buttonChange bg-sky-500 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 font-bold text-xl mt-3 text-center text-white '
                type='submit'>Change</button><br>
        </form>

        @can('admin-access', Auth::user())
            <form class='flex flex-col items-center m-8 text-left'method='POST' action="/settings/update">
                @csrf
                <h1 class='text-xl'>Change Settings</h1>
                <br>
                <label for="maxPing">Max Ms for Warnings</label>
                <input id='maxPing' placeholder='maxPing'
                    name='maxPing'class='rounded inputchange h-[8%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black'
                    type="number" value='{{ $settings->maxPing }}'>
                @error('maxPing')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="max_consecutive_errors">Max Consecutive Errors</label>
                <input placeholder='max_consecutive_errors'
                    name='max_consecutive_errors'class='rounded inputchange h-[8%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black'
                    type="number" value='{{ $settings->max_consecutive_errors }}'>
                @error('max_consecutive_errors')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <button
                    class='rounded buttonChange bg-sky-500 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 font-bold text-xl mt-3 text-center text-white '
                    type='submit'>Submit
                </button>
            </form> <br><br><br>
        @endcan
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#showOldPassword').html('<i class="fa-solid fa-eye-slash"></i>');

            $('#showOldPassword').on("click", function() {
                var x = $('#old-password-input');
                if (x.attr("type") == "password") {
                    x.attr("type", "text");
                    $('#showOldPassword').html('<i class="fa-solid fa-eye"></i>');
                } else {
                    x.attr("type", "password");
                    $('#showOldPassword').html('<i class="fa-solid fa-eye-slash"></i>');
                }
            });

            $('#showNewPassword').html('<i class="fa-solid fa-eye-slash"></i>');

            $('#showNewPassword').on("click", function() {
                var x = $('#new-password-input');
                if (x.attr("type") == "password") {
                    x.attr("type", "text");
                    $('#showNewPassword').html('<i class="fa-solid fa-eye"></i>');
                } else {
                    x.attr("type", "password");
                    $('#showNewPassword').html('<i class="fa-solid fa-eye-slash"></i>');
                }
            });


            $('#showConfirmNewPassword').html('<i class="fa-solid fa-eye-slash"></i>');

            $('#showConfirmNewPassword').on("click", function() {
                var x = $('#confirm-new-password-input');
                if (x.attr("type") == "password") {
                    x.attr("type", "text");
                    $('#showConfirmNewPassword').html('<i class="fa-solid fa-eye"></i>');
                } else {
                    x.attr("type", "password");
                    $('#showConfirmNewPassword').html('<i class="fa-solid fa-eye-slash"></i>');
                }
            });
        });
    </script>
@endsection
