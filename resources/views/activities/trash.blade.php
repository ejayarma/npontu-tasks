<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-32 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 m-3">
                    @foreach ($activities as $activity)
                        <div class="p-3 m-3 border-2 border-green-200 rounded">
                            <div class="flex flex-column justify-between">
                                <div>
                                    <h6 class="font-bold from-slate-900 text-lg">{{ $activity->title }}</h6>
                                    <p>{{ Str::limit($activity->description, 50) }}</p>
                                </div>
                                <div>
                                    <p class="mb-2">Assigned to | <span
                                            class="font-bold mr-3">{{ $activity->user->name }}</span>
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
                                    <p class="float-right my-3">
                                        <button
                                            onclick="{
                                                let form = document.getElementById('restoreForm');
                                                form.action = `{{ route('activity.restore', $activity->id) }}`;
                                                form.submit();
                                            }"
                                            class="border-2 bg-green-400 p-2 rounded ml-2">
                                            Restore
                                        </button>
                                        <button
                                            onclick="{
                                                if(confirm('Are you sure you want permanently to delete this activity?')){
                                                    let form = document.getElementById('permanentDeleteForm');
                                                    form.action = `{{ route('activity.destroy_forever', $activity->id) }}`;
                                                    form.submit();
                                                }
                                            }"
                                            class="border-2 hover:border-red-400 p-2 rounded ml-2">
                                            Delete Forever
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <form id="restoreForm" action="" method="POST">
                        @csrf
                    </form>
                    <form id="permanentDeleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
