@extends('layouts.base')

@section ('head')
<title>Fattify</title>
@stop

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-to-bl from-emerald-50 to-lime-100">
    <div class="
                fixed
                z-10
                top-0
                inset-x-0
                bg-emerald-50 bg-opacity-80
                backdrop-filter backdrop-blur-[12px]
                border-b border-lime-400 border-opacity-50
            ">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
                <div class="flex flex-1 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a
                            class="inline-flex items-center font-semibold text-base text-black space-x-2"
                            href="{{ route('welcome') }}"
                        >
                            <img
                                class="w-auto h-5"
                                src="/buddy-packman.svg"
                                alt="Fattify"
                            >
                            <span class="text-xl font-extrabold text-emerald-800">Fattify</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-4 md:flex-1 lg:w-0">
                    <a
                        href="{{ route('login') }}"
                        class="
                                whitespace-nowrap
                                bg-green-100
                                hover:bg-green-200
                                rounded-full
                                py-1.5
                                px-3
                                inline-flex
                                items-center
                                justify-center
                                text-xs
                                font-medium
                                text-green-700
                                transition
                                ease-in-out
                                duration-150
                            "
                    > Sign in </a>
                    <a
                        href="{{ route('register') }}"
                        class="
                                whitespace-nowrap
                                bg-green-500
                                hover:bg-green-600
                                rounded-full
                                py-1.5
                                px-3
                                inline-flex
                                items-center
                                justify-center
                                text-xs
                                font-medium
                                text-white
                                transition
                                ease-in-out
                                duration-150
                            "
                    > Sign up for free </a>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden border-b border-gray-400 border-opacity-10 pb-16">
        <div class="max-w-3xl mx-auto pt-48 pb-8 px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-extrabold text-gray-900">
                Track your calories
                <span class="bg-clip-text bg-gradient-to-r from-emerald-600 text-transparent to-lime-700">with ease</span>
            </h1>

            <a
                class="mt-8 block text-center w-full py-3 rounded border border-emerald-500 text-green-900 font-semibold text-sm border-b-emerald-500/60 hover:bg-gradient-to-r transition hover:from-teal-700 hover:to-lime-700 hover:text-white md:text-base"
                href="{{ route('register') }}"
            >Sign Up for Free</a>
        </div>
    </div>
</div>
@stop
