<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($activity->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-32 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-5">
                <div class="p-3 m-3">
                    <div class="p-3 m-3 border-2 border-green-200 rounded">
                        <div class="flex flex-column justify-between">
                            <div>
                                <h6 class="font-bold from-slate-900 text-lg">{{ $activity->title }}</h6>
                                <p>{{ Str::limit($activity->description, 50) }}</p>
                            </div>
                            <div>
                                <p class="mb-2">Assigned to | <span
                                        class="font-bold">{{ $activity->user->name }}</span></p>
                                <p>
                                    <span>
                                        @switch($activity->priority)
                                            @case('high')
                                                <span class="bg-red-300 rounded p-1">{{ $activity->priority }}</span>
                                            @break

                                            @case('low')
                                                <span class="bg-gray-300 rounded p-1">{{ $activity->priority }}</span>
                                            @break

                                            @default
                                                <span class="bg-purple-300 rounded p-1">{{ $activity->priority }}</span>
                                        @endswitch
                                    </span>
                                    <span>
                                        @if ($activity->status == 'pending')
                                            <span class="bg-yellow-300 rounded p-1">{{ $activity->status }}</span>
                                        @else
                                            <span class="bg-green-300 rounded p-1">{{ $activity->status }}</span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 m-3">
                    <h2 class="text-gray-900">History</h2>
                </div>
                <div class="p-3 m-3">
                    @foreach ($audits as $audit)
                        <p>{{ $audit->title->new }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
