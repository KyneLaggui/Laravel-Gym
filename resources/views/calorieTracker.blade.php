@extends('layout')
@section('content')

<div class="bg-gray-200 p-4 min-h-screen"">
        <div class="lg:w-2/4 mx-auto py-8 px-6 bg-white rounded-xl">
            <h1 class="font-bold text-5xl text-center mb-8">Calorie Tracker</h1>
            <div class="mb-6">
                <form class="flex flex-col space-y-4" method="POST" action="/calorieTracker">
                    @csrf
                    <input type="text" name="title" placeholder="The todo title" class="py-3 px-4 bg-gray-100 rounded-xl">
                    <textarea name="description" id="description" placeholder="The todo description" class="py-3 px-4 bg-gray-100 rounded-xl" >
Calories:
Protein:
Fat:
Carbohydrates:
                    </textarea>
                    <select class="browser-default custom-select w-100 p-1 " name="category">
                        @foreach(json_decode('{"Breakfast":"Breakfast", "Lunch":"Lunch", "Dinner": "Dinner"}', true) as $optionKey => $optionValue)
                                <option value="{{ $optionKey }}" >{{ $optionValue}}</option>
                        @endforeach
                    </select>
                    <button class="w-28 py-2 px-8 bg-green-500 text-white rounded-xl">Add</button>
                </form>
            </div>
            <hr>
            <div class="mt-2">
                @foreach ($trackers as $tracker)
                    <div class="py-4 flex items-center border-b border-gray-300 px-3">
                        <div class="flex-1 pr-8">
                            <h3 class="text-lg font-semibold">{{ $tracker->title }}<h3>
                                <p class="text-gray-500">{{ $tracker->description }}</p>
                        </div>

                        <div class="flex space-x-3">
                            <form method="POST" action="/{{ $tracker->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="py-2 px-2 bg-red-500 text-white rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>

@endsection