@extends('layout')
@section('content')

<div class="bg-gray-200 p-4 min-h-screen"">
    @if ($message = Session::get('success'))
        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'success',
                title: '{{ $message }}'
            })
        </script>
    @endif
        
        <div class="lg:w-2/4 mx-auto py-8 px-6 bg-white rounded-xl">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('calorieTracker', ['date' => $previousDate]) }}" class="text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous Day
                </a>
                <p class="text-semi-bold text-1xl text-center"> {{ $selectedDate }}</p>
                <a href="{{ route('calorieTracker', ['date' => $nextDate]) }}" class="text-blue-500">
                    Next Day
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <h1 class="font-bold text-5xl text-center mb-2">Calories Tracker</h1>
            @if ($calorieDifference > 0)
                <p class="font-bold text-2xl text-blue-500 text-center mb-5">{{ $calorieGoal }} - {{ $overallCalories }} = {{ $calorieDifference }}</p>
            @else
                <p class="font-bold text-2xl text-red-500 text-center mb-5">{{ $calorieGoal }} - {{ $overallCalories }} = {{ $calorieDifference }}</p>
            @endif
            <div class="flex mb-5 justify-around">
                <h1><span class="text-lg font-semibold">Total Carbohydrates:</span> {{ $totalCarbohydrates }}g</h1>
                <h1><span class="text-lg font-semibold">Total Fats:</span> {{ $totalFats }}g</h1>
                <h1><span class="text-lg font-semibold">Total Protein:</span> {{ $totalProtein }}g</h1>
            </div>
            
            <div class="mb-6">
                <ul class="flex">
                    <li class="mr-4">
                        <button id="counter-tab-btn" class="tab-btn active" data-tab="counter">Track my Meal</button>
                    </li>

                    <li class="mr-4">
                        <button id="foods-tab-btn" class="tab-btn" data-tab="foods">My Meals</button>
                        
                    </li>
                    <li class="mr-4">
                        <button id="tracker-tab-btn" class="tab-btn" data-tab="tracker">Add Meals</button>
                    </li>
                    <li>
                        <a href=" {{ route('taskSchedule') }} ">
                            <button id="tracker-tab-btn" class="tab-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </button>
                        </a> 
                    </li>
  
                </ul>
            </div>
            <div class="tab-content " id="tracker-tab">
                <div class="mb-6">
                    <form class="flex flex-col space-y-4" method="POST" action="/calorieTracker">
                        @csrf
                        <input type="text" name="title" placeholder="Food" class="py-3 px-4 bg-gray-100 rounded-xl">
                        <input type="number" name="calories" placeholder="Calories" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="carbohydrates" placeholder="Carbohydrates" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="fats" placeholder="Fats" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        <input type="number" name="protein" placeholder="Protein" class="py-3 px-4 bg-gray-100 rounded-xl" >
                        
                        </input>
                        
                        <button class="w-28 py-2 px-8 bg-blue-500 text-white rounded-xl">Add</button>
                    </form>
                </div>
            </div>
            <div class="tab-content" id="foods-tab">
                <form method="GET" action="{{ route('calorieTracker') }}" accept-charset="UTF-8" role="search" class="d-flex justify-content-center">
                    <div class="input-group w-full p-3 ">
                        <div class="form-outline">
                          <input type="search" id="form1" class="form-control name="search"  name="search" value="{{ request('search') }}"/>
                          <label class="form-label" for="form1">Search</label>
                        </div>
                        <button type="submit" class="btn btn-primary search-select">
                          <i class="fas fa-search"></i>
                        </button>
                        
                    </div>
                      
                </form>
                @foreach ($mealSearch as $meal)
                    <div class="py-4 flex items-center border-b border-gray-300 px-3">
                        
                        <div class="flex-1 pr-10 ">

                            <h3 class="text-xl font-semibold">{{ $meal->title }}</h3>
                            <div class="flex justify-start gap-4 mt-2">
                                <p class=" text-gray-500">Calories: {{ $meal->calories }}</p>
                                <p class="text-gray-500">Carbohydrates: {{ $meal->carbohydrates }}</p>
                                <p class="text-gray-500">Fats: {{ $meal->fats }}</p>
                                <p class="text-gray-500">Protein: {{ $meal->protein }}</p>
                            </div>
                            

                        </div>
                        <div class="flex space-x-3">
                            <form id="store-tracker-form" method="POST" action="storeTracker" >
                                @csrf
                                <input type="hidden" name="title" placeholder="Calories" value=" {{ $meal->title }} ">
                                <input type="hidden" name="calories" placeholder="Calories" value=" {{ $meal->calories }} ">
                                <input type="hidden" name="carbohydrates" placeholder="Carbohydrates" value=" {{ $meal->carbohydrates }} ">
                                <input type="hidden" name="fats" placeholder="Fats" value=" {{ $meal->fats }} ">
                                <input type="hidden" name="protein" placeholder="Protein" value=" {{ $meal->protein }} ">
                                <input type="hidden" name="date" value=" {{ $selectedDate }} ">
                                <input type="hidden" name="timeline" id="meal-time-input">
                                
                                <button class="py-2 px-2 bg-blue-500 text-white rounded-xl mr-2" onclick="addMeals(event, this.form)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                   
                                </button>
                                
                            </form>
                        </div>
                        @if(Auth::user()->level == 10)
                            <div class="flex space-x-3">
                                <form method="POST" action="{{ route('deleteMeal', ['id' => $meal->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="py-2 px-2 bg-red-500 text-white rounded-xl" onclick="deleteConfirm(event)">
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
            <div class="tab-content" id="counter-tab">
                 
                

                <div class="mb-6">
                    <div class="flex justify-between items-center"> 
                        <h2 class="text-3xl font-semibold">Breakfast</h2>
                        <h3 class="text-2xl font-semibold">{{ $breakfastCalories }}</h3>
                    </div>
                    
                    <hr class="my-2">
                    
                    <div>
                        @foreach ($trackers as $tracker)
                            @if ($tracker->timeline === 'Breakfast')
                                <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                    <div class="flex-1 pr-10 ">

                                        <h3 class="text-xl font-semibold">{{ $tracker->title }}</h3>
                                        <div class="flex justify-start gap-4 mt-2">
                                            <p class=" text-gray-500">Calories: {{ $tracker->calories }}</p>
                                            <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                            <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                            <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>
                                        </div>
                                        

                                    </div>
                                    <div class="flex space-x-3">
                                        <form method="POST" action="/{{ $tracker->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="py-2 px-2 bg-red-500 text-white rounded-xl" onclick="deleteConfirm(event)"> 
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
                    <div class="flex justify-between items-center"> 
                        <h2 class="text-3xl font-semibold">Lunch</h2>
                        <h3 class="text-2xl font-semibold">{{ $lunchCalories }}</h3>
                    </div>
                    
                    <hr class="my-2">
                    
                    <div>
                        @foreach ($trackers as $tracker)
                            @if ($tracker->timeline === 'Lunch')
                                <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                    <div class="flex-1 pr-10 ">

                                        <h3 class="text-xl font-semibold">{{ $tracker->title }}</h3>
                                        <div class="flex justify-start gap-4 mt-2">
                                            <p class=" text-gray-500">Calories: {{ $tracker->calories }}</p>
                                            <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                            <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                            <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>
                                        </div>
                                        

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
                    <div class="flex justify-between items-center"> 
                        <h2 class="text-3xl font-semibold">Dinner</h2>
                        <h3 class="text-2xl font-semibold">{{ $dinnerCalories }}</h3>
                    </div>
                    <hr class="my-2">
                    <div>
                        @foreach ($trackers as $tracker)
                            @if ($tracker->timeline === 'Dinner')
                                <div class="py-4 flex items-center border-b border-gray-300 px-3">
                                    <div class="flex-1 pr-10 ">

                                        <h3 class="text-xl font-semibold">{{ $tracker->title }}</h3>
                                        <div class="flex justify-start gap-4 mt-2">
                                            <p class=" text-gray-500">Calories: {{ $tracker->calories }}</p>
                                            <p class="text-gray-500">Carbohydrates: {{ $tracker->carbohydrates }}</p>
                                            <p class="text-gray-500">Fats: {{ $tracker->fats }}</p>
                                            <p class="text-gray-500">Protein: {{ $tracker->protein }}</p>
                                        </div>
                                        

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
    .tab-btn:hover {
        cursor: pointer;
        background-color: #3b82f6;
        color: white;
        
    }


    .tab-btn.active {
        background-color: #3b82f6;
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .swal2-cancel {
        margin-right: 1em !important;
    }
</style>

<script>
    const tabContents = document.querySelectorAll('.tab-content');
    
    function setActiveTab(tabId) {
        localStorage.setItem('activeTab', tabId);
    }


    function getActiveTab() {
        return localStorage.getItem('activeTab');
    }

   
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {

            tabButtons.forEach((btn) => btn.classList.remove('active'));
            tabContents.forEach((content) => content.classList.remove('active'));
            const tabId = button.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
            button.classList.add('active');

           
            setActiveTab(tabId);
        });
    });


    window.addEventListener('load', () => {
        const lastActiveTabId = getActiveTab();
        if (lastActiveTabId) {
            const lastActiveTabButton = document.getElementById(`${lastActiveTabId}-tab-btn`);
            if (lastActiveTabButton) {
                lastActiveTabButton.click();
            }
        }
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
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                });
                const title = `Meal Added to ${timeline}`;
        
                Toast.fire({
                icon: 'success',
                title: title 
            })
            form.querySelector('#meal-time-input').value = timeline;
            form.submit();
        }
    }
    window.deleteConfirm = function (e)
    {
        e.preventDefault();
        var form = e.target.form;
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
            swalWithBootstrapButtons.fire(
            'Deleted!',
            'Your Meal has been deleted.',
            'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your Meals are safe',
            'error'
            )
        }
        })
    }
</script>

@endsection
