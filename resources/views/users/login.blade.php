@extends('layouts/head')
@section('content')
    <br>
    <h1 class='mt-[10%] text-5xl'>Login</h1><br>
    <form class='flex flex-col items-center'method='POST' action="/users/authenticate">
        @csrf
        <input placeholder='Email' name='email'maxlength='40'
            class='h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black'type="email">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <br>
        <div class='w-full relative'>
            <input placeholder='Password' name='password'class='h-[80%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 text-black'
                type="password" id='password-input'>
            <span class='text-black z-20 flex top-2 right-[36%] absolute items-center h-full cursor-pointer' id='showPassword'></span>
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <br>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('showPassword').innerHTML = '<i class="fa-solid fa-eye-slash"></i>';

                $('#showPassword').on("click", function() {
                    var x = $('[id="password-input"]');
                    if (x.attr("type") == "password") {
                        x.attr("type", "text");
                        document.getElementById('showPassword').innerHTML = '<i class="fa-solid fa-eye"></i>';
                    } else {
                        x.attr("type", "password");
                        document.getElementById('showPassword').innerHTML =
                            '<i class="fa-solid fa-eye-slash"></i>';
                    }
                });
            });
        </script>

        <button
            class='bg-sky-500 h-[15%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 font-bold text-2xl text-center text-white transition ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-sky-600 duration-900'
            type='submit'>Login</button><br>
        <a id='link' class="underline mt-4"href="/users/register">Don't have an account?</a>

        <a id='link' class="underline mt-4"href="/forgotpass">Forgot your password?</a>
        </div>
    </form>
@endsection
