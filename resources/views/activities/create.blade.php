<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a new activity') }}
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
                    <form method="POST" action="{{ route('activity.store') }}">
                        @csrf

                        <div>
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="title" class="block mt-1  w-96" type="text" name="title"
                                :value="old('title')" required autofocus autocomplete="title" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description"
                                class="block mt-1 w-96  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                type="text" name="description" :value="old('description')" required>
                            </textarea>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="user_id" value="{{ __('Assign To') }}" />
                            <select id="user_id"
                                class="block mt-1 w-96 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                type="" name="user_id" required>
                                <option value="0">Asign task</option>
                                @foreach ($teamMembers as $key => $tm)
                                    <option value="{{ $tm }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="priority" value="{{ __('Priority') }}" />
                            <select id="priority"
                                class="block mt-1 w-96 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                name="priority" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="status" class="inline" value="{{ __('Status') }}" />
                            <x-jet-checkbox id="status" class="mt-1" name="status">
                            </x-jet-checkbox>
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
