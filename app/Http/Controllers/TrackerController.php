<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use App\Models\Meal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class TrackerController extends Controller
{   
    // public function mealTracker()
    // {
    //     $meal = Meal::all();

    //     return view('calorieTracker', [
    //         'meal' => $meal,
    //     ]);
    // }

    public function storeMeal()
    {
        $meals = request()->validate ([
            "title" => 'required',
            'calories' => 'required',
            'carbohydrates' => 'required',
            'fats' => 'required',
            'protein' => 'required'
        ]);

        Meal::create($meals);
        return redirect('/calorieTracker');
    }


    public function calorieTracker(Request $request)
    {
        
        // Retrieve all trackers
        
        $date = $request->input('date', now()->format('Y-m-d'));

        $trackers = Tracker::where([
            ['user_id', auth()->id()],
            ['date', $date],
        ])->get();

        $meals = Meal::all();

        $breakfastCalories = $this->getTotalCalories('Breakfast', $trackers);
        $lunchCalories = $this->getTotalCalories('Lunch', $trackers);
        $dinnerCalories = $this->getTotalCalories('Dinner', $trackers);

        $overallCalories = $breakfastCalories + $lunchCalories + $dinnerCalories;


        return view('calorieTracker', [
            'trackers' => $trackers,
            'meals' => $meals,
            'breakfastCalories' => $breakfastCalories,
            'lunchCalories' => $lunchCalories,
            'dinnerCalories' => $dinnerCalories,
            'overallCalories' => $overallCalories,
            'selectedDate' => $date
        ]);
    }

    public function storeTracker(Request $request)
    {
        $attributes = request()->validate ([
            "title" => 'required',
            'timeline' => 'required',
            'calories' => 'required',
            'carbohydrates' => 'required',
            'fats' => 'required',
            'protein' => 'required',
            'date' => 'required'
        ]);

        $attributes['user_id'] = auth()->user()->id;

       

        Tracker::create($attributes);

        Event::create([
            'user_id' => auth()->user()->id,
            'start' => $attributes['date'],
            'end' => $attributes['date'],
            'title' => 'Calorie Tracker',
        ]);

        $caloriesPageUrl = '/calorieTracker?date=' . $attributes['date'];

        return redirect($caloriesPageUrl);
    }

    public function deleteTracker(Tracker $tracker, Request $request)
    {
        if (auth()->user()->id === $tracker->user_id) {
            $tracker->delete();
        }

        $caloriesPageUrl = '/calorieTracker?date=' . $attributes['date'];

        return redirect($caloriesPageUrl);

        
    }

    public function getTotalCalories($category, $trackers) {
        $totalCalories = 0;
        foreach ($trackers as $tracker) {
            if ($tracker->timeline === $category) {
                $totalCalories += $tracker->calories;
            }
        }
        return $totalCalories;
    }
    
    
    
}
