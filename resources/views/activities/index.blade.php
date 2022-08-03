<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-32 sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-5">
                <div class="p-3 m-3">
                    <div class="mb-3 ml-3">
                        <h2 class="text-slate-800 text-lg font-bold">Sort and Filter</h2>
                    </div>
                    <form id="sort-and-filter-form" class="pb-5 pr-3" action="" method="GET">
                        @csrf
                        <div class="flex flex-row justify-between px-3 pb-1">
                            <div class="flex flex-col">
                                <label class="mb-2" for="start-date">Start Date</label>
                                <input id="start-date" type="date" name="start_date"
                                    value="{{ isset($startDate) ? $startDate : '' }}">
                            </div>
                            <div class="flex flex-col">
                                <label class="mb-2" for="end-date">End Date</label>
                                <input id="end-date" type="date" name="end_date"
                                    value="{{ isset($endDate) ? $endDate : '' }}">
                            </div>
                            <div class="flex flex-col">
                                <label class="mb-2" for="sort-by">Sort By</label>
                                <select name="sort_by" id="sort-by">
                                    <option selected value="created_at">Date Created</option>
                                    <option value="title">Title</option>
                                    <option value="status">Status</option>
                                    <option value="prority">Priority</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <div class="mb-2">
                                    <label for="">Order By</label>
                                </div>
                                <div class="mb-1">
                                    <span><input class="border-2 w-5 h-5" type="radio" name="order_by" id="asc"
                                            value="asc"></span>
                                    <label class="inline" for="asc">Ascending</label>
                                </div>
                                <div>
                                    <span><input class="border-2 w-5 h-5" type="radio" name="order_by" id="desc"
                                            value="desc" checked></span>
                                    <label class="inline" for="desc">Descending</label>
                                </div>
                            </div>
                        </div>
                        <div
                            class="float-left p-3 ml-3 mt-3 mb-7 border-green-500 border-2 transition-colors hover:bg-green-500 hover:text-white">
                            <button id="sub-button" type="submit">Sort and Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-3 m-3">
                    @foreach ($activities as $activity)
                        <div class="p-3 m-3 border-2 border-green-200 rounded">
                            <div class="flex flex-column justify-between">
                                <div>
                                    <h6 class="font-bold from-slate-900 text-lg">{{ $activity->title }}</h6>
                                    <p>{{ Str::limit($activity->description, 50) }}</p>
                                </div>
                                <div class="m-2">
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
                                    <p class="float-right mt-3">
                                        <span class="border-2 hover:border-blue-400 p-2 rounded ml-2"><a
                                                href="{{ route('activity.show', $activity) }}">Details</a></span>
                                        <span class="border-2 hover:border-blue-400 p-2 rounded ml-2"><a
                                                href="{{ route('activity.edit', $activity) }}">Edit</a></span>
                                        <button
                                            onclick="{
                                                if(confirm('Are you sure you want to delete this activity?')){
                                                    let form = document.getElementById('deleteForm');
                                                    form.action = `{{ route('activity.destroy', $activity) }}`;
                                                    form.submit();
                                                }
                                            }"
                                            class="border-2 hover:border-red-400 p-2 rounded ml-2">
                                            Delete
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            let subButton = document.getElementById('sub-button');
            let startDate = document.getElementById('start-date');
            let endDate = document.getElementById('end-date');
            let sortBy = document.getElementById('sort-by');
            let orderBy = document.getElementById('order-by');
            let sortAndFilterForm = document.getElementById('sort-and-filter-form');
            subButton.addEventListener('click', (e) => {
                e.preventDefault();
                sortAndFilterForm.action = `{{ route('activity.sf_index') }}`;
                console.log(sortAndFilterForm.elements, sortAndFilterForm.action, sortBy.value);
                sortAndFilterForm.submit();
            });
        </script>
    @endpush
</x-app-layout>
