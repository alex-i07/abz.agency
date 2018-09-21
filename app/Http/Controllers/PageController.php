<?php

namespace App\Http\Controllers;

//use Javascript;
use App\Employee;
use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * Unauthorized users can go to / page
     *
     * PageController constructor.
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function mainPage()
    {

        $collection = Employee::where ('hierarchy_level', '=', 1)->get();


        $firstLevelEmployee = $collection->map(function ($item, $key) {
            return ['text' => $item->name,
                    'childrenNumber' => Employee::find($item->id)->children()->count(),
                    'dbId' => $item->id,
                    'hierarchyLevel' => $item-> hierarchy_level];
        });

        return view('welcome', compact('firstLevelEmployee'));
    }

    public function fetchChildren ($dbId)
    {

        $children = Employee::find($dbId)->children()->get();

        return response($children, 200);

    }
}
