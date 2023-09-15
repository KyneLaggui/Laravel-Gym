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
        return redirect()->route('calorieTracker')->with('success', 'Meal has been Added');
    }


    public function calorieTracker(Request $request)
    {

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

        $totalCarbohydrates = 0;
        $totalProtein = 0;
        $totalFats = 0;

        $totalCaloriesConsumed = $overallCalories;

        
        $calorieGoal = '1700';
        $calorieDifference = $calorieGoal - $overallCalories;

       
        

        foreach ($trackers as $tracker) {
            $totalCarbohydrates += $tracker->carbohydrates;
            $totalProtein += $tracker->protein;
            $totalFats += $tracker->fats;
        }

        
        $previousDate = date('Y-m-d', strtotime($date . ' -1 day'));
        $nextDate = date('Y-m-d', strtotime($date . ' +1 day'));

        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $mealSearch = Meal::where('title', 'LIKE', "%$keyword%")
                ->latest()
                ->get();
        } else {
            $mealSearch = Meal::latest()->get();
        }

        return view('calorieTracker', [
            'trackers' => $trackers,
            'meals' => $meals,
            'breakfastCalories' => $breakfastCalories,
            'lunchCalories' => $lunchCalories,
            'dinnerCalories' => $dinnerCalories,
            'overallCalories' => $overallCalories,
            'selectedDate' => $date,
            'previousDate' => $previousDate,
            'nextDate' => $nextDate,
            'totalCarbohydrates' => $totalCarbohydrates,
            'totalProtein' => $totalProtein,
            'totalFats' => $totalFats,
            'mealSearch' => $mealSearch,
            'calorieGoal' => $calorieGoal,
            'calorieDifference' => $calorieDifference
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

        $existingEvent = Event::where('user_id', $attributes['user_id'])
        ->where('start', $attributes['date'])
        ->where('end', $attributes['date'])
        ->where('title', 'Calorie Tracker')
        ->first();

        if (!$existingEvent) {
            // Create a new event only if it doesn't exist
            Event::create([
                'user_id' => auth()->user()->id,
                'start' => $attributes['date'],
                'end' => $attributes['date'],
                'title' => 'Calorie Tracker',
            ]);
        }
        
        $caloriesPageUrl = '/calorieTracker?date=' . $attributes['date'];

        return redirect($caloriesPageUrl);
    }

    public function deleteTracker(Tracker $tracker, Request $request)
    {
        if (auth()->user()->id === $tracker->user_id) {
            $date = $tracker->date; 
            $tracker->delete();

            $caloriesPageUrl = '/calorieTracker?date=' . $date;

            return redirect($caloriesPageUrl);
        }

    }

    public function deleteMeal(Tracker $tracker, $id)
    {
        $date = $tracker->date; 
       
        Meal::destroy($id);

        $caloriesPageUrl = '/calorieTracker?date=' . $date;

        
        return redirect($caloriesPageUrl)->with('success', 'Tracker deleted successfully');
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
