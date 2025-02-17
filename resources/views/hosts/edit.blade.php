@extends('layouts/head')
@section('content')
    <link href="../../dist/output.css" rel="stylesheet">

    <br>
    <div class='dark:shadow-gray-500/30 dark:shadow-sm shadow-md  bg-white dark:bg-[#262C38] w-[80%] m-auto rounded'><br>

        <h1 class='text-3xl'>Edit {{ $currenthost[0]->name }} </h1>

        <br>
        <form class='flex flex-col items-center'method='POST' action="/host/update">
            @csrf
            <div class="back">
                <a href="/admin"> <i class="fa-solid fa-arrow-left"></i> Back </a>
            </div>
            <br>
            <input name='name'type="hidden" value="{{ $currenthost[0]->name }}">
            <input placeholder='Ip Address' name='ip' value='{{ $currenthost[0]->ip }}'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'type="ip">
            @error('ip')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <input placeholder='Location' name='location'value='{{ $currenthost[0]->location }}'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'
                type="text">
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <select name='provider_id' selected='{{ $currenthost[0]->provider_id }}'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'>
                @foreach ($provider as $item)
                    <option @if ($currenthost[0]->provider_id == $item->id) selected @endif class="text-black"
                        value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <select name='type'
                class='rounded overflow-visible border-2 border-spacing-1 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-4 mb-2 text-black'>
                <option @if ($currenthost[0]->type == 'Slow') selected @endif class="text-black" value="Slow">Slow</option>
                <option @if ($currenthost[0]->type == 'Medium') selected @endif class="text-black" value="Medium">Medium</option>
                <option @if ($currenthost[0]->type == 'Fast') selected @endif class="text-black" value="Fast">Fast</option>
            </select>
            <button
                class='rounded bg-sky-500 h-[10%] w-[30%] shadow-sm shadow-gray-500 p-2 font-bold text-2xl mt-5 text-center text-white scale-up-on-hover'
                type='submit'>Update Host
            </button><br><br>
        </form>
    @endsection
