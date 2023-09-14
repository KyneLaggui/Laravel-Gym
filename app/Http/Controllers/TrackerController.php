<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use App\Models\Meal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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


    public function calorieTracker()
    {
        
        // Retrieve all trackers
        $allTrackers = Tracker::all();

        // Filter trackers to show only those belonging to the authenticated user
        $trackers = $allTrackers->filter(function ($tracker) {
            return auth()->check() && auth()->user()->id === $tracker->user_id;
        });

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
            'overallCalories' => $overallCalories
        ]);
    }

    public function storeTracker()
    {
        $attributes = request()->validate ([
            "title" => 'required',
            'timeline' => 'required',
            'calories' => 'required',
            'carbohydrates' => 'required',
            'fats' => 'required',
            'protein' => 'required'
        ]);

        $attributes['user_id'] = auth()->user()->id;
        Tracker::create($attributes);
        return redirect('/calorieTracker');
    }

    public function deleteTracker(Tracker $tracker)
    {
        if (auth()->user()->id === $tracker->user_id) {
            $tracker->delete();
        }
        
        return redirect('/calorieTracker');
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
