@extends('layouts/head')
@section('content')
    <br>
    <div class='dark:shadow-gray-500/30 dark:shadow-sm shadow-md bg-white dark:bg-[#262C38] w-[80%] m-auto rounded'><br>
        <h1 class='text-3xl'>Create Host</h1>

        <br>
        <form class='flex flex-col items-center'method='POST' action="/hosts">
            @csrf
            <div class="back">
                <a href="/admin"> <i class="fa-solid fa-arrow-left"></i> Back </a>
            </div>
            <br>
            <input value="{{ old('name') }}"placeholder='Name' name='name' maxlength='30'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'type="text">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <input value="{{ old('ip') }}"placeholder='Ip Address'
                name='ip'class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'
                type="ip">
            @error('ip')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input value="{{ old('location') }}"placeholder='Location'
                name='location'class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'
                type="text">
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <select name='provider'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'>
                @foreach ($providers as $item)
                    <option class="text-black" {{ old('provider') == $item->id . ',' . $item->name ? 'selected' : '' }}
                        value="{{ $item->id }},{{ $item->name }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <select name='type'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'>
                <option {{ old('type') == 'Slow' ? 'selected' : '' }} class="text-black" value="Slow">Slow</option>
                <option {{ old('type') == 'Medium' ? 'selected' : '' }} class="text-black" value="Medium">Medium</option>
                <option {{ old('type') == 'Fast' ? 'selected' : '' }} class="text-black" value="Fast">Fast</option>
            </select>
            <button
                class='rounded bg-sky-500 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-2 font-bold text-2xl mt-5 text-center text-white scale-up-on-hover'
                type='submit'>Create Host</button><br><br>
        </form> <br><br>
    </div><br>
@endsection
