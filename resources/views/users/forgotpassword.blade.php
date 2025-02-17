@extends('layouts/head')
@section('content')
    <h1 class="tracking-tight 2xl:text-[42px] xl:text-4xl; lg:text-3xl p-4 mt-52"> Password reset </h1>
    <br>
    <form class='flex flex-col items-center h-[70%]' method='POST' action="{{ route('send.mail') }}">
        @csrf
        <input placeholder='Email' name='email' maxlength='40'
            class='h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 text-black' type="email">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <button Id='EmailPassReset'
            class=' bg-sky-500 h-[15%] w-[30%] shadow-sm shadow-gray-500 mt-4 p-4 font-bold text-2xl text-center text-white transition ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-sky-600 duration-900'
            type='submit'>Email me
        </button>
        <a class='transition ease-in-out bg-sky-800 h-[8%] w-[10%] shadow-sm shadow-gray-500 mt-6 p-1 font-bold text-xl text-center text-white hover:-translate-y-1 hover:scale-110 hover:bg-sky-900 duration-200'
            href="/users/login"> Back </a>
    </form>
@endsection
