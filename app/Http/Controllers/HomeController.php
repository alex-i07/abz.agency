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

    public function aboutInfo (Request $request)
    {
        $id = $request->id;

//        dd($id);

        $employee = Employee::findOrFail($id);



        if ($employee->hierarchy_level == 1){
//            $chiefHierarchy = $employee->hierarchy_level - 1;
            $chiefs = serialize([
                ['id' => '0' , 'name' => 'Нет начальника']
            ]);

//            $chief = 'Нет начальника';
        }

        else {
            $chiefHierarchy = $employee->hierarchy_level - 1;

            $chiefs= serialize(Employee::where('hierarchy_level', '=', $chiefHierarchy)->get()->transform(function ($item, $key) { return ['id' => $item->id, 'name' => $item->name];}));

//            $chief = $employee->parent()->get()[0]->name;
        }



//        $chiefHierarchy = $employee->hierarchy_level - 1;

//        if ($employee->get()->is)



//        if($chief->isEmpty()){
//            $chief = 'Нет начальника';
//        }
//        else {           $chief = $chief[0]->name;
//        }

//        dd($chief);

        return view ('about', compact('employee', 'chiefs'));
    }

    public function aboutEdit (Request $request)
    {

//        dd($request->all());

        $this->validate(request(), [
            'name' => 'required|string',
            'email'     => 'required|email',
            'position'     => 'required|string',
            'date_of_employment'     => 'required|date',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
        ]);

//        try {

        Employee::where('email', '=', $request->email)->update([
            'name'    => $request->name,
            'email'    => $request->email,
            'position'       => $request->position,
            'date_of_employment' => $request->date_of_employment,
            'salary' => $request->salary,
            'parent_id' => $request->parent_id,
        ]);


//        $employee = Employee::where('email', '=', $request->email);
//
//        $employee = Employee::updateOrCreate(
//                [
//                    'email' => $request->email
//                ],
//                [
//                    'name'    => $request->name,
//                    'email'    => $request->email,
//                    'position'       => $request->position,
//                    'date_of_employment' => $request->date_of_employment,
//                    'salary' => $request->salary,
//                    'chief' => $request->chief,
//                ]);
//        }


//catch exception
//        catch(Exception $e) {
//            echo 'Message: ' .$e->getMessage();
//        }


//        return redirect('/home');
        return back();
//        return response ('Your changes has been successfully submitted!', 201);


    }

    public function deleteEmployee(Request $request)
    {
//        dd($request->email);

//        DB::table('employees')->where('email', '=', $request->email)->delete();

        $employee = DB::table('employees')->where('email', '=', $request->email);

        $id = DB::table('employees')->where('email', '=', $request->email)->first()->id;

        $idsToRemove = collect([]);

        $idsToRemove->push($id);

        $ids = DB::table('employees')->where('parent_id', '=', $id)->get()->pluck('id');
dd($ids);
//        array_merge($idsToRemove, $ids);
//
//        $ids2 = DB::table('employees')->where('parent_id', '=', $ids)->get()->pluck('id');
//call isNotEmpty() on array?! МОжно сделать проверку по уровню иерархии. Не так изящно, но...
        
        while($ids->isNotEmpty()){
            $ids = DB::table('employees')->where('parent_id', '=', $ids)->get()->pluck('id')->toArray();

            $idsToRemove->merge($ids)->unique();

//            $idsToRemove = array_merge($idsToRemove, $ids);

//            $ids2 = DB::table('employees')->where('parent_id', '=', $ids)->get()->pluck('id');
//
//            $idsToRemove = array_merge($idsToRemove, $ids2);
        }

        dd($idsToRemove);

    }

    public function createForm()
    {
        $hierarchyLevels = Employee::select('hierarchy_level')->distinct()->get();

        $chiefsPerLevel = [1 => [['id' => 0, 'name' => 'Нет начальника']]];

        $i = 2;

        for ($j = 0; $j < $hierarchyLevels->count() - 1; $j++){

            $hierarchyLevel = $hierarchyLevels[$j]->hierarchy_level;

            $temp = Employee::where('hierarchy_level', '=', $hierarchyLevel)->get()->map(function($item) {
                return ['id' => $item->id, 'name' => $item->name];
            });
//dd($temp);
            $chiefsPerLevel[$i] = $temp;  $i++;

        }

//        foreach ($hierarchyLevels as $hierarchyLevel){
//
//            $hierarchyLevel = $hierarchyLevel->hierarchy_level;
//
//            $temp = Employee::where('hierarchy_level', '=', $hierarchyLevel)->get()->map(function($item) {
//                return ['id' => $item->id, 'name' => $item->name];
//            });
//
//            $chiefsPerLevel[$i] = $temp; $i++;
//        }

        $chiefsPerLevel = json_encode($chiefsPerLevel);

        return view('create', compact('chiefsPerLevel'));
    }

    public function createNewEmployee (Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|',
            'position'     => 'required|string',

            'date_of_employment' => 'required|date',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
            'hierarchy_level' => 'required|numeric'

        ]);

        $employee = new Employee;

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->position = $request->position;
        $employee->date_of_employment = $request->date_of_employment;
        $employee->salary = $request->salary;
        $employee->parent_id = $request->parent_id;
        $employee->hierarchy_level = $request->hierarchy_level;
        $employee->password = bcrypt($request->password);

        $employee->save();

//        $employee = Employee::create([
//            'name'    => $request->name,
//            'email'    => $request->email,
//            'position'       => $request->position,
//            'date_of_employment' => $request->date_of_employment,
//            'salary' => $request->salary,
//            'parent_id' => $request->chief,
//            'hierarchy_level' => $request->hierarchy_level
//        ]);
//dd($employee);
//        return response ('$employee->id', 201);
        return redirect('/about/' . $employee->id .'/edit');
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
