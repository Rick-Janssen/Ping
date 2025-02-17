@extends('layouts/head')
@section('content')
    <br>
    <h1 class='text-5xl mt-[10%]'>Change Password</h1><br>
    <form class='flex flex-col items-center w-[80%] m-auto' method='POST' action="{{ route('password.change') }}">
        @csrf
        <input placeholder='Email' name='email' maxlength='40'
            class='h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black' type="email">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <br>
        <input placeholder='New Password' name='password' maxlength='255'
            class='h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black' type="password">
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <br>
        <input placeholder='Confirm Password' name='password_confirmation' maxlength='255'
            class='h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black' type="password">
        <button
            class='bg-sky-500 h-[15%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 font-bold text-2xl text-center text-white transition ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-sky-600 duration-900'
            type='submit'>Change Password
        </button>
    </form>
@endsection
