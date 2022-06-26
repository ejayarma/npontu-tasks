<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-20 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 m-3">
                    @foreach ($activities as $activity)
                        <div class="p-3 m-3 border-2 border-green-200 rounded">
                            <h6 class="font-bold from-slate-900 text-lg">{{ $activity->title }}</h6>
                            <p>{{ Str::limit($activity->description, 5, '...') }}</p>
                            <p>{{ dd($activity->assigned_to()) }}</p>
                            <p>{{ $activity->status }}</p>
                            <p>{{ $activity->priority }}</p>
                        </div>
                        <div class="p-3 m-3 border-2 border-yellow-200 rounded">
                            <h6>{{ $activity->title }}</h6>
                            <p>{{ $activity->description }}</p>
                            <p>{{ $activity->assigned_to }}</p>
                            <p>{{ $activity->status }}</p>
                            <p>{{ $activity->priority }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
