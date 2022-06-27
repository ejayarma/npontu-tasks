<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col justify-center items-center mx-auto sm:px-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
                <div class="p-7">
                    <form method="POST" action="{{ route('activity.update', $activity) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="title" class="block mt-1  w-96" type="text" name="title"
                                value="{{ $activity->title }}" required autofocus autocomplete="title" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description"
                                class="block mt-1 w-96  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                type="text" name="description" required>{{ $activity->description }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="user_id" value="{{ __('Assign To') }}" />
                            <select id="user_id"
                                class="block mt-1 w-96 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                type="" name="user_id" required>
                                <option value="0">Asign task</option>
                                @foreach ($teamMembers as $key => $tm)
                                    <option {{ $tm === $activity->id ? 'selected' : '' }} value="{{ $tm }}">
                                        {{ $tm }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="priority" value="{{ __('Priority') }}" />
                            <select id="priority"
                                class="block mt-1 w-96 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                name="priority" required>
                                <option {{ $activity->priority === 'low' ? 'selected' : '' }} value="low">Low
                                </option>
                                <option {{ $activity->priority === 'medium' ? 'selected' : '' }} value="medium">
                                    Medium
                                </option>
                                <option {{ $activity->priority === 'high' ? 'selected' : '' }} value="high">High
                                </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="status" class="inline" value="{{ __('Status') }}" />
                            <input type="checkbox" {{ $activity->status === '1' ? 'checked' : '' }} id="status"
                                class="ml-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="status" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button class="ml-4">
                                {{ __('Save') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
