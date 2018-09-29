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

//        $result = [ 'id' => 8,
//                    'parent' => 0,
//                   'name' => 'Борисова Анфиса Евгеньевна',
//                   'position' => 'Лингвист',
//                   'date_of_employment' => '1990-12-12',
//                   'salary' => '94691',
//                   'text' => 'Фокин Иннокентий Владимирович123',
//                   'childrenNumber' => 3,
//                   'hierarchyLevel' => 1,
//                   'icon' => 'glyphicon glyphicon-user',
//                   'state' => [
//                       'opened' => false,
//                       'disabled' => false,
//                       'selected' => false,
//                   ],
//                   'li_attr' => [],
//                   'a_attr' => [],
//                    'children' => [],
//                   ];
//
//        return response([8, 20], 200);

        $collection = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')
            ->where('date_of_employment', 'LIKE', ['%' . $str . '%'])
//            ->where('date_of_employment LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('name LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('position LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])
            ->get();

//        $ids = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')
////            ->where('date_of_employment', $str)
//            ->orWhereRaw('name LIKE ?', ['%' . $str . '%'])
//            ->orWhereRaw('position LIKE ?', ['%' . $str . '%'])
//            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])
//            ->get()->pluck('id');

        if($collection->isEmpty()){
            return response('No records found', 200);
        }
//dd($collection);
        $allParents = collect([]);

        $allParentIds = collect([]);

        foreach($collection as $value){

//            $value = $this->format($value);

//            $allParents->push($value);
//dd($value);
            $currentParentId = $value->parent_id;
//
//            $maxParentId = $currentParentId;



            while($currentParentId > 0) {

                $parent = DB::table('employees')->select('id', 'parent_id')->where('id', $currentParentId)->first();
//dd($parent);


                $allParentIds->prepend($parent->id);

//                $tmp = []; $tmp[] = $parent->id;
//dd($tmp);
                $currentParentId = $parent->parent_id;



//                $parent = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')->where('id', $currentParentId)->first();

//                $formattedParent = $this->format($parent);

//                $allParents->push($formattedParent);
//
//                $currentParentId = $formattedParent['parent'];
//
//                if ($maxParentId < $currentParentId){
//                    $maxParentId = $currentParentId;
//                }
            }



        }
//        dd($allParentIds);
        $result = $allParentIds->unique();

//        dd(array_values($result->toArray()));

        $result = array_values($result->toArray());

//        var_dump($result); exit();

//        $allParents = $allParents->unique('id');
////        dd($allParents, $maxParentId);
//        $result = $this->makeTree($allParents->toArray(), $maxParentId);
//        dd($result);
//        foreach($ids as $id) {
//
//            $result->push($this->getAllParents($id));
//        }

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

    public function about (Request $request)
    {
        $id = $request->id;

//        dd($id);

        $employee = Employee::findOrFail($id);



        if ($employee->hierarchy_level == 1){
//            $chiefHierarchy = $employee->hierarchy_level - 1;
            $chiefs = ['Нет начальника'];

            $chief = 'Нет начальника';
        }

        else {
            $chiefHierarchy = $employee->hierarchy_level - 1;

            $chiefs= Employee::where('hierarchy_level', '=', $chiefHierarchy)->get()->pluck('name');

            $chief = $employee->parent()->get()[0]->name;
        }



//        $chiefHierarchy = $employee->hierarchy_level - 1;

//        if ($employee->get()->is)



//        if($chief->isEmpty()){
//            $chief = 'Нет начальника';
//        }
//        else {
//            $chief = $chief[0]->name;
//        }

//        dd($chief);

        return view ('about', compact('employee', 'chief', 'chiefs'));
    }

    protected function format($parent)
    {
        return collect([
            'id' => $parent->id,
            'parent' => $parent->parent_id,
            'name' => $parent->name,
            'position' => $parent->position,
            'date_of_employment' => $parent->date_of_employment,
            'salary' => $parent->salary,
            'text' => '123',
            'childrenNumber' => $childrenNumber = Employee::find($parent->id)->children()->count(),
            'hierarchyLevel' => $parent-> hierarchy_level,
            'icon' => 'glyphicon glyphicon-user',
            'state' => [
                'opened' => false,
                'disabled' => false,
                'selected' => false,
            ],
            'li_attr' => [],
            'a_attr' => [],
        ]);
    }

    protected function makeTree (array $allParents, $maxParentId = 0)
    {

        $array = array_combine(array_column($allParents, 'id'), array_values($allParents));

        foreach ($array as $k => &$v) {
            if (isset($array[$v['parent']])) {
                $array[$v['parent']]['children'][] = &$v;
            }
            unset($v);
        }

//        dd($array);

        return array_filter($array, function($v) use ($maxParentId) {
            return $v['parent'] == $maxParentId;
        });

    }

//    protected function getAllParents($ids)
//    {
//
//        $allParents = [];
//
//        foreach($ids as $id) {
//
//        }
//
//
//
//
//
//
//
////        foreach ($ids as $key => $value){
//
////        $child = Employee::find($id);
//
//        $child = Employee::where('id', $id)->get();
//
//            function getParent($child){
//
////                $child = Employee::find($value);
//
//                $parent = $child[0]->parent()->get();
//
//                $formattedChild = $child->map(function ($item, $key){
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
//                            'children' => $childrenNumber === 0 ? false : true
//                    ];
//
//                });
//
//                $formattedParent = $parent->map(function ($item, $key) use($formattedChild){
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
//                            'children' => $formattedChild,
//                    ];
//
//                });
////dd($formattedParent);
//                if ($formattedParent->parent > 0){
//                    getParent( $formattedParent);
//                }
//
//                    return $formattedParent;
//
//            }
//
//        $allParents = getParent($child);
//            return $allParents;
//
////            $child = Employee::find($value);
////
////            $parent = $child->parent()->get();
////
////            $child = $child->get();
////
////            $formattedChild = (function ($child) {
////                $tmp = $child->map(function ($item, $key){
////                    return ['id' => $item->id,
////                            'parent' => $item->parent_id,
////                            'name' => $item->name,
////                            'position' => $item->position,
////                            'date_of_employment' => $item->date_of_employment,
////                            'salary' => $item->salary,
////                            'text' => null,
//////                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
////                            'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
////                            'hierarchyLevel' => $item-> hierarchy_level,
////                            'icon' => 'glyphicon glyphicon-user',
////                            'state' => [
////                                'opened' => false,
////                                'disabled' => false,
////                                'selected' => false,
////                            ],
////                            'li_attr' => [],
////                            'a_attr' => [],
////                            'children' => false
////                    ];
////
////                });
////
////                return $tmp;
////            });
////
////            $tmp = $parent->map(function ($item, $key) use($formattedChild){
////                return ['id' => $item->id,
////                        'parent' => $item->parent_id,
////                        'name' => $item->name,
////                        'position' => $item->position,
////                        'date_of_employment' => $item->date_of_employment,
////                        'salary' => $item->salary,
////                        'text' => null,
//////                    'text' => '<span>' . $item->name . '   '. $item->position . '   ' . $item->date_of_employment . '   ' . $item->salary . '</span>',
////                        'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
////                        'hierarchyLevel' => $item-> hierarchy_level,
////                        'icon' => 'glyphicon glyphicon-user',
////                        'state' => [
////                            'opened' => false,
////                            'disabled' => false,
////                            'selected' => false,
////                        ],
////                        'li_attr' => [],
////                        'a_attr' => [],
////                        'children' => $formattedChild,
////                ];
////
////            });
////        }
//
//
//    }
}
