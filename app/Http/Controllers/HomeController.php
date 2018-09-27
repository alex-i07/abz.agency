<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Employee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function fetchRoots ()
    {
        $collection = Employee::where ('hierarchy_level', '=', 1)->get();

        $firstLevelEmployees = $collection->map(function ($item, $key) {
            return ['id' => $item->id,
                    'parent' => '#',
                    'name' => $item->name,
                    'position' => $item->position,
                    'date_of_employment' => $item->date_of_employment,
                    'salary' => $item->salary,
                    'text' => null,
//                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => 'glyphicon glyphicon-user',
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

    public function fetchChildren (Request $request)
    {
        $id = $request->id;

        $collection = Employee::find($id)->children()->get();

        $subordinates = $collection->map(function ($item, $key) {
            return ['id' => $item->id,
                    'parent' => $item->parent_id,
                    'name' => $item->name,
                    'position' => $item->position,
                    'date_of_employment' => $item->date_of_employment,
                    'salary' => $item->salary,
                    'text' => null,
//                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => 'glyphicon glyphicon-user',
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

    public function search (Request $request)
    {
        $str = $request->str;

//        $collection = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')
////            ->where('date_of_employment', $str)
//            ->orWhereRaw('name LIKE ?', ['%' . $str . '%'])
//            ->orWhereRaw('position LIKE ?', ['%' . $str . '%'])
//            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])
//            ->get();

        $ids = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')
//            ->where('date_of_employment', $str)
            ->orWhereRaw('name LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('position LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])
            ->get()->pluck('id');

        $result = collect([]);

        foreach($ids as $id) {

            $result->push($this->getAllParents($id));
        }

        return response($result, 200);

//dd($collection);
//        $response = $collection->map(function ($item, $key) {
//            return ['id' => $item->id,
//                    'parent' => $item->parent_id,
//                    'name' => $item->name,
//                    'position' => $item->position,
//                    'date_of_employment' => $item->date_of_employment,
//                    'salary' => $item->salary,
//                    'text' => null,
////                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
//                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
//                    'hierarchyLevel' => $item-> hierarchy_level,
//                    'icon' => 'glyphicon glyphicon-user',
//                    'state' => [
//                        'opened' => false,
//                        'disabled' => false,
//                        'selected' => false,
//                    ],
//                    'li_attr' => [],
//                    'a_attr' => [],
//                    'children' => $childrenNumber === 0 ? false : true,
//            ];
//
//        });





    }

    protected function getAllParents($id)
    {
//        foreach ($ids as $key => $value){

//        $child = Employee::find($id);

        $child = Employee::where('id', $id)->get();

            function getParent($child){

//                $child = Employee::find($value);

                $parent = $child[0]->parent()->get();

                $formattedChild = $child->map(function ($item, $key){
                    return ['id' => $item->id,
                            'parent' => $item->parent_id,
                            'name' => $item->name,
                            'position' => $item->position,
                            'date_of_employment' => $item->date_of_employment,
                            'salary' => $item->salary,
                            'text' => null,
//                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                            'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                            'hierarchyLevel' => $item-> hierarchy_level,
                            'icon' => 'glyphicon glyphicon-user',
                            'state' => [
                                'opened' => false,
                                'disabled' => false,
                                'selected' => false,
                            ],
                            'li_attr' => [],
                            'a_attr' => [],
                            'children' => $childrenNumber === 0 ? false : true
                    ];

                });

                $formattedParent = $parent->map(function ($item, $key) use($formattedChild){
                    return ['id' => $item->id,
                            'parent' => $item->parent_id,
                            'name' => $item->name,
                            'position' => $item->position,
                            'date_of_employment' => $item->date_of_employment,
                            'salary' => $item->salary,
                            'text' => null,
//                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
                            'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                            'hierarchyLevel' => $item-> hierarchy_level,
                            'icon' => 'glyphicon glyphicon-user',
                            'state' => [
                                'opened' => false,
                                'disabled' => false,
                                'selected' => false,
                            ],
                            'li_attr' => [],
                            'a_attr' => [],
                            'children' => $formattedChild,
                    ];

                });
//dd($formattedParent);
                if ($formattedParent->parent > 0){
                    getParent( $formattedParent);
                }

                    return $formattedParent;

            }

        $allParents = getParent($child);
            return $allParents;

//            $child = Employee::find($value);
//
//            $parent = $child->parent()->get();
//
//            $child = $child->get();
//
//            $formattedChild = (function ($child) {
//                $tmp = $child->map(function ($item, $key){
//                    return ['id' => $item->id,
//                            'parent' => $item->parent_id,
//                            'name' => $item->name,
//                            'position' => $item->position,
//                            'date_of_employment' => $item->date_of_employment,
//                            'salary' => $item->salary,
//                            'text' => null,
////                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
//                            'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
//                            'hierarchyLevel' => $item-> hierarchy_level,
//                            'icon' => 'glyphicon glyphicon-user',
//                            'state' => [
//                                'opened' => false,
//                                'disabled' => false,
//                                'selected' => false,
//                            ],
//                            'li_attr' => [],
//                            'a_attr' => [],
//                            'children' => false
//                    ];
//
//                });
//
//                return $tmp;
//            });
//
//            $tmp = $parent->map(function ($item, $key) use($formattedChild){
//                return ['id' => $item->id,
//                        'parent' => $item->parent_id,
//                        'name' => $item->name,
//                        'position' => $item->position,
//                        'date_of_employment' => $item->date_of_employment,
//                        'salary' => $item->salary,
//                        'text' => null,
////                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
//                        'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
//                        'hierarchyLevel' => $item-> hierarchy_level,
//                        'icon' => 'glyphicon glyphicon-user',
//                        'state' => [
//                            'opened' => false,
//                            'disabled' => false,
//                            'selected' => false,
//                        ],
//                        'li_attr' => [],
//                        'a_attr' => [],
//                        'children' => $formattedChild,
//                ];
//
//            });
//        }


    }
}
