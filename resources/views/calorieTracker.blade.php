@extends('layout')
@section('content')

<div class="bg-gray-200 p-4 min-h-screen"">
        <div class="lg:w-2/4 mx-auto py-8 px-6 bg-white rounded-xl">
            <h1 class="font-bold text-5xl text-center mb-8">Calorie Tracker</h1>
            
            <div class="mb-6">
                <ul class="flex">
                    <li class="mr-4">
                        <button class="tab-btn" data-tab="foods">My Meals</button>
                        
                    </li>
                    <li>
                        <button class="tab-btn active" data-tab="tracker">Add Meals</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content hidden" id="tracker-tab">
                <div class="mb-6">
                    <form class="flex flex-col space-y-4" method="POST" action="/calorieTracker">
                        @csrf
                        <input type="text" name="title" placeholder="Food" class="py-3 px-4 bg-gray-100 rounded-xl">
                        <input type="number" name="calories" placeholder="Calories" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="carbohydrates" placeholder="Carbohydrates" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="fats" placeholder="Fats" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="protein" placeholder="Protein" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        
                        </input>
                        {{-- <select class="browser-default custom-select w-100 p-1 " name="timeline">
                            @foreach(json_decode('{"Breakfast":"Breakfast", "Lunch":"Lunch", "Dinner": "Dinner"}', true) as $optionKey => $optionValue)
                                    <option value="{{ $optionKey }}" >{{ $optionValue}}</option>
                            @endforeach
                        </select> --}}
                        <button class="w-28 py-2 px-8 bg-green-500 text-white rounded-xl">Add</button>
                    </form>
                </div>
            </div>
            <div class="tab-content hidden" id="foods-tab">
                @foreach ($meals as $meal)
                    <div class="py-4 flex items-center border-b border-gray-300 px-3">
                        <div class="flex-1 pr-8">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">{{ $meal->title }}</h3>
                                <p class="text-gray-500">Calories: {{ $meal->calories }}</p>
                            </div>
                            <p class="text-gray-500">Carbohydrates: {{ $meal->carbohydrates }}</p>
                            <p class="text-gray-500">Fats: {{ $meal->fats }}</p>
                            <p class="text-gray-500">Protein: {{ $meal->protein }}</p>

                        </div>
                        <div class="flex space-x-3">
                            <form id="store-tracker-form" method="POST" action="/storeTracker" >
                                @csrf
                                <input type="hidden" name="title" placeholder="Calories" value=" {{ $meal->title }} ">
                                <input type="hidden" name="calories" placeholder="Calories" value=" {{ $meal->calories }} ">
                                <input type="hidden" name="carbohydrates" placeholder="Carbohydrates" value=" {{ $meal->carbohydrates }} ">
                                <input type="hidden" name="fats" placeholder="Fats" value=" {{ $meal->fats }} ">
                                <input type="hidden" name="protein" placeholder="Protein" value=" {{ $meal->protein}} ">
                                <input type="hidden" name="timeline" id="meal-time-input">
                                <button class="py-2 px-2 bg-green-500 text-white rounded-xl" onclick="addMeals(event, this.form)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                   
                                </button>
                                
                            </form>
                        </div>
                        @if(Auth::user()->level == 10)
                            <div class="flex space-x-3">
                                <form method="POST" action="/{{ $meal->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="py-2 px-2 bg-red-500 text-white rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                        
                    </div>
                @endforeach
            </div>
            <h1>Overall Total Calories: {{ $overallCalories }}</h1>
            <div class="mb-6">
                <h2 class="text-3xl font-semibold">Breakfast</h2>
                <hr class="my-2">
                <h3>Calories Result: {{ $breakfastCalories }}</h3>
                <div>
                    @foreach ($trackers as $tracker)
                        @if ($tracker->timeline === 'Breakfast')
                            <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                <div class="flex-1 pr-8">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">{{ $tracker->title }}</h3>
                                        <p class="text-gray-500">Calories: {{ $tracker->calories }}</p>
                                    </div>
                                    <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                    <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                    <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>

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
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="mb-6">
                <h2 class="text-3xl font-semibold">Lunch</h2>
                <hr class="my-2">
                <h3>Calories Result: {{ $lunchCalories }}</h3>
                <div>
                    @foreach ($trackers as $tracker)
                        @if ($tracker->timeline === 'Lunch')
                            <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                <div class="flex-1 pr-8">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">{{ $tracker->title }}</h3>
                                        <p class="text-gray-500">Calories: {{ $tracker->calories }}</p>
                                    </div>
                                    <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                    <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                    <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>

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
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="mb-6">
                <h2 class="text-3xl font-semibold">Dinner</h2>
                <hr class="my-2">
                <h3>Calories Result: {{ $dinnerCalories }}</h3>
                <div>
                    @foreach ($trackers as $tracker)
                        @if ($tracker->timeline === 'Dinner')
                            <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                <div class="flex-1 pr-8">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">{{ $tracker->title }}</h3>
                                        <p class="text-gray-500">Calories: {{ $tracker->calories }}</p>
                                    </div>
                                    <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                    <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                    <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>

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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
</div>

<style>
    .tab-btn {
        cursor: pointer;
        background-color: #f1f1f1;
        padding: 10px 20px;
        border: none;
        outline: none;
        transition: background-color 0.3s;
    }

    .tab-btn.active {
        background-color: #ddd;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>

<script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {
            // Remove the "active" class from all buttons and contents
            tabButtons.forEach((btn) => btn.classList.remove('active'));
            tabContents.forEach((content) => content.classList.remove('active'));

            // Add the "active" class to the clicked button and corresponding content
            const tabId = button.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
            button.classList.add('active');
        });
    });

    window.addMeals = async function (e, form) {
        e.preventDefault();
        
        const { value: timeline } = await Swal.fire({
            title: 'Choose Meal Time',
            input: 'select',
            inputOptions: {
                'Breakfast': 'Breakfast',
                'Lunch': 'Lunch',
                'Dinner': 'Dinner',
            },
            inputPlaceholder: 'Choose Meal Time',
            showCancelButton: true,
        });

        if (timeline) {
            form.querySelector('#meal-time-input').value = timeline;
            form.submit();
        }
    }
</script>

@endsection
