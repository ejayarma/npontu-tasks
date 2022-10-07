<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Npontu Tasks') }}
            <div class="float-right relative bottom-5">
                @if (Route::has('login'))
                    <div class="px-6 py-4 sm:block">
                        @auth
                            <a href="{{ route('activity.index') }}"
                                class="text-base text-gray-700 dark:text-gray-500 hover:underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-base text-gray-700 dark:text-gray-500 hover:underline">Log
                                in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 text-base text-gray-700 dark:text-gray-500 hover:underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <p>hello</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
