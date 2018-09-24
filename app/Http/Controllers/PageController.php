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

//        $collection = Employee::where ('hierarchy_level', '=', 1)->get();
//
//
//        $firstLevelEmployee = $collection->map(function ($item, $key) {
//            return ['id' => $item->id,
//                    'parent' => '#',
//                    'text' => $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary,
//                    'childrenNumber' => Employee::find($item->id)->children()->count(),
//                    'hierarchyLevel' => $item-> hierarchy_level,
//                    'icon' => false,
//                    'state' => [
//                        'opened' => false,
//                        'disabled' => false,
//                        'selected' => false,
//                    ],
//                    'li_attr' => [],
//                    'a_attr' => [],
//                ];
//
//        });



//        $collection = Employee::where ('hierarchy_level', '=', 1)->get();
//
//
//        $firstLevelEmployee = $collection->map(function ($item, $key) {
//            return ['text' => $item->name,
//                    'childrenNumber' => Employee::find($item->id)->children()->count(),
//                    'dbId' => $item->id,
//                    'hierarchyLevel' => $item-> hierarchy_level];
//        });



        return view('welcome');
    }

    public function fetchChildren ($id)
    {

        $collection = Employee::find($id)->children()->get();

        $subordinates = $collection->map(function ($item, $key) {
            return ['id' => $item->id,
                    'parent' => $item->parent_id,
                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'state' => [
                        'opened' => false,
                        'disabled' => false,
                        'selected' => false,
                    ],
                    'li_attr' => [],
                    'a_attr' => [],
                    'children' => $childrenNumber === 0 ? false : true,
            ];

        });

        return response($subordinates, 200);

    }

    public function fetchRoots()
    {

        $collection = Employee::where ('hierarchy_level', '=', 1)->get();


        $firstLevelEmployees = $collection->map(function ($item, $key) {
            return ['id' => $item->id,
                    'parent' => '#',
                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => false,
                    'state' => [
                        'opened' => false,
                        'disabled' => false,
                        'selected' => false,
                    ],
                    'li_attr' => [],
                    'a_attr' => [],
                    'children' => $childrenNumber === 0 ? false : true,
            ];

        });

        return response($firstLevelEmployees, 200);
    }

}
