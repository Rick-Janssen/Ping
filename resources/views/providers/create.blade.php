@extends('layouts/head')
@section('content')
    <br>
    <div class='dark:shadow-gray-500/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-[80%] m-auto rounded'><br>
        <h1 class='text-3xl'>Create Provider</h1> <br>
        <form class='flex flex-col items-center' method='POST' action="/providers">
            @csrf
            <div class="back">
                <a href="/admin"> <i class="fa-solid fa-arrow-left"></i> Back </a>
            </div>
            <br>
            <input value="{{old('name')}}"placeholder='Provider Name' name='name'
                class='overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'
                type="text">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button
                class='bg-sky-500 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-2 font-bold text-2xl mt-5 text-center text-white scale-up-on-hover'
                type='submit'>Add Provider</button><br><br>
        </form> <br><br>
    </div>
@endsection
