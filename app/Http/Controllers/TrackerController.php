<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    public function calorieTracker()
    {
        $tracker = Tracker::all();

        return view('calorieTracker', [
            'trackers' => $tracker
        ]);
    }

    public function storeTracker()
    {
        $attributes = request()->validate ([
            "title" => 'required',
            'description' => 'nullable'
        ]);

        Tracker::create($attributes);
        return redirect('/calorieTracker');
    }

    public function deleteTracker(Tracker $tracker)
    {
        $tracker->delete();
        return redirect('/calorieTracker');
    }
}
