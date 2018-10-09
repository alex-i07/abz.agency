<?php

namespace App\Http\Controllers;

use JavaScript;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * Access to these methods only for authorized users
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
        JavaScript::put([
            'foo' => 'bar',
            'user' => Employee::first(),
            'age' => 29
        ]);

        return view('home');
    }

    /**
     * Gets all roots
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

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
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => ($item->avatar !== NULL) ? './storage/users-avatars/' . $item->avatar : 'glyphicon glyphicon-user',
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

//        $firstLevelEmployees = [['id'=>'1', 'text'=>'NOde1', 'children' =>  ['id'=>'12', 'text'=>'NOde12']], ['id'=>'2', 'text'=>'NOde2']];

        return response($firstLevelEmployees, 200);
    }

    /**
     * Fetches all children nodes for a given root
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

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
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => ($item->avatar !== NULL) ? './storage/users-avatars/' . $item->avatar : 'glyphicon glyphicon-user',
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

    /**
     * Implements a search using given word
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response\
     */

    public function search (Request $request)
    {
        $str = $request->str;

        $collection = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')
            ->where('date_of_employment', 'LIKE', ['%' . $str . '%'])
            ->orWhereRaw('name LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('position LIKE ?', ['%' . $str . '%'])
            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])->get();

        if($collection->isEmpty()){
            return response('No records found', 200);
        }

        $allParentIds = collect([]);

        foreach($collection as $value){

            $currentParentId = $value->parent_id;

            while($currentParentId > 0) { //or >=0?

                $parent = DB::table('employees')->select('id', 'parent_id')->where('id', $currentParentId)->first();

                if ($parent !==null){

                    $id = $parent->id;
                    $allParentIds->prepend($id);

                    $currentParentId = $parent->parent_id;
                }
                else {
                    return response ('Ошибка, возможно был удалён родитель, а дочерние узлы остались', 500);
                }
            }

        }

        $result = $allParentIds->unique();

        $result = array_values($result->toArray());

        return response($result, 200);

    }

    /**
     * Displays about page with information about employee from DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function getInfo (Request $request)
    {
        $id = $request->id;

        $employee = Employee::findOrFail($id);

        if ($employee->hierarchy_level == 1){

            $chiefs = serialize([
                ['id' => '0' , 'name' => 'Нет начальника']
            ]);

        }

        else {
            $chiefHierarchy = $employee->hierarchy_level - 1;

            $chiefs= serialize(Employee::where('hierarchy_level', '=', $chiefHierarchy)->get()
                ->transform(function ($item, $key) {
                    return ['id' => $item->id, 'name' => $item->name];
                })
            );

        }

        JavaScript::put(['employee' => $employee]);

        return view ('about', compact('employee', 'chiefs'));
    }

    /**
     * Saves information to DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function editInfo (Request $request)
    {

        $this->validate(request(), [
            'avatar' => 'mimes:jpg,jpeg,png,bmp,svg,gif|max:3072',
            'name' => 'required|string',
            'email'     => 'required|email',
            'position'     => 'required|string',
            'date_of_employment'     => 'required|date',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
        ]);

        $employee = Employee::where('email', '=', $request->email);

        $id = $employee->get()[0]->id;

        if ($request->avatar) {

            $path = $employee->get()[0]->avatar;

            //delete previous file if exists

            if(Storage::exists('public/users-avatars/' . $path)){   //здесь нужно добавлять public/users-avatars/
                Storage::delete('public/users-avatars/' . $path);         //ссылка должна быть http://abz.agency.local/storage/users-avatars/8KNVwG3E1btp2QOoJEEgZH7p8RTmm8qwPkAzADNv.jpeg
            }

            $request->file('avatar')->store('public/users-avatars');
//            $path = Storage::putFile('public/users-avatars', $request->file('avatar'));
            $path = $request->file('avatar')->hashName();  // буду в БД только имя записывать

//            $path = Storage::url($path);

        }
        else {
            $path = null;
        }
//dd($path);
        $employee->update([
            'avatar' => $path,
            'name'    => $request->name,
            'email'    => $request->email,
            'position'       => $request->position,
            'date_of_employment' => $request->date_of_employment,
            'salary' => $request->salary,
            'parent_id' => $request->parent_id,
        ]);

        if($request->ajax()){
            return response('/employee/' . $id .'/edit', 201);
        }

        return redirect('/employee/' . $id .'/edit');

    }

    /**
     * Deletes employee and deletes all it subordinates if they are
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function deleteEmployee(Request $request)
    {

//        $ids = DB::table('employees')->where('email', '=', $request->email)->first()->id;

//        $employee = DB::table('employees')->where('email', '=', $request->email)->first();

        $employee = Employee::where('email', '=', $request->email)->first();

        $this->distributeSubordinates($employee);

//        $subordinatesIds = $employee->children()->get()->pluck('id');
//
//        if ($subordinatesIds->count() !== 0 ) {
//
//            if ($employee->parent_id === 0){
//                $siblings = DB::table('employees')->where('hierarchy_level', '=', $employee->hierarchy_level)->get()->pluck('id');
//            }
//            else{
//                $parent = Employee::find($employee->parent_id);
//
//                $siblings = $parent->children()->get()->pluck('id');
//
//                if ($siblings->count() <=1 ){
//                    $siblings = DB::table('employees')->where('hierarchy_level', '=', $employee->hierarchy_level)->get()->pluck('id');
//                }
//            }
//
//            $siblings = $siblings->reject(function ($value, $key)use($employee){
//                return $value === $employee->id;
//            });
//
//            $subordinatesIds = $employee->children()->get()->pluck('id');
//
//            foreach ($subordinatesIds as $subordinatesId) {
//
//                $subordinate = Employee::find($subordinatesId);
//                $subordinate->parent_id = $siblings->random();
//
//                $subordinate->save();
//
//            }
//        }

        $employee->delete();


//        $ids = collect($ids);
//
//        $idsToRemove = collect([]);
//
//        $idsToRemove = $idsToRemove->merge($ids)->unique();
//
//        while($ids->isNotEmpty()){
//
//            $ids = DB::table('employees')->whereIn('parent_id', $ids->toArray())->get()->pluck('id');
//
//            $idsToRemove = $idsToRemove->merge($ids)->unique();
//
//        }
//
//        DB::table('employees')->whereIn('parent_id', $idsToRemove->toArray())->delete();
//
//        DB::table('employees')->where('email', '=', $request->email)->delete();

        return response ("Удаление произведено успешно!", 200);

    }

    /**
     * Displays a form for creating new employee
     * Sends information about all employees that can be chiefs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function createForm()
    {
        $hierarchyLevels = Employee::select('hierarchy_level')->distinct()->get();

        $chiefsPerLevel = [1 => [['id' => 0, 'name' => 'Нет начальника']]];

        $i = 2;

        for ($j = 0; $j < $hierarchyLevels->count(); $j++){

            $hierarchyLevel = $hierarchyLevels[$j]->hierarchy_level;

            $temp = Employee::where('hierarchy_level', '=', $hierarchyLevel)->get()->map(function($item) {
                return ['id' => $item->id, 'name' => $item->name];
            });

            $chiefsPerLevel[$i] = $temp;  $i++;

        }

//        $chiefsPerLevel = json_encode($chiefsPerLevel);

        JavaScript::put(["chiefsPerLevel" => $chiefsPerLevel]);

        return view('create');
    }

    /**
     * Save new employee
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function createNewEmployee (Request $request)
    {

        $this->validate($request, [
            'avatar' => 'mimes:jpg,jpeg,png,bmp,svg,gif|max:3072',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:employees',
            'password' => 'required|string|min:6|',
            'position'     => 'required|string',
            'date_of_employment' => 'required|date',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
            'hierarchy_level' => 'required|numeric'

        ]);

        if ($request->avatar) {

//            $path = Storage::putFile('public/users-avatars', $request->file('avatar'));

                $request->file('avatar')->store('public/users-avatars');
            $path = $request->file('avatar')->hashName();

        }
        else {
            $path = null;
        }

        $employee = new Employee;

        $employee->avatar = $path;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->position = $request->position;
        $employee->date_of_employment = $request->date_of_employment;
        $employee->salary = $request->salary;
        $employee->parent_id = $request->parent_id;
        $employee->hierarchy_level = $request->hierarchy_level;
        $employee->password = bcrypt($request->password);

        $employee->save();

        if($request->ajax()){
            return response($employee->id, 201);
        }

        return redirect('/employee/' . $employee->id .'/edit');
    }

    public function dragDrop (Request $request)
    {

//        dd($request->all());
        $oldParentId = $request->oldParentId;
        $newParentId = $request->newParentId;
        $id = $request->id;

        $employee = Employee::find($id);

//        dd($employee);

        $employee->parent_id = $newParentId;

//        $employee->save();

        if ($newParentId == 0){
            $employee->hierarchy_level = 1;
        }
        else{
            $newHierarchyLevel = Employee::find($newParentId)->hierarchy_level;

//            $parentLevel = $employee->parent()->get()[0]->hierarchy_level;

            $employee->hierarchy_level = $newHierarchyLevel - 1;
        }

        $this->distributeSubordinates($employee);

        $employee->save();

        return response('Drag and drop successfull', 201);
    }

    public function fetchMassload (Request $request)
    {

//        return [
//            "2" => [
//            ["id"=>"75","text"=>"Some child of Node 1","children"=>false],
//        ],
//    ];


//        return [8,54,191,2,75,155,28,96,153,20,73,18,53,42,70,25,77,86,45,61,5,91,43,90,24,6,59,32,60,94,37,68,14,72,7,98,47,46,41,135,40];

//        dd($request->all()['ids']);


//        return [
//            ['id' => 2,
//                    'parent' => 0,
//                    'name' => 'Аксёнова Жанна Борисовна',
//                    'position' => 'Арт-директор',
//                    'date_of_employment' => '11.11.1995',
//                    'salary' => '119333',
//                    'text' => null,
//                    'childrenNumber' => 1,
//                    'hierarchyLevel' => 1,
//                    'icon' => NULL,
//                    'state' => [
//                        'opened' => false,
//                        'disabled' => false,
//                        'selected' => false,
//                    ],
//                    'li_attr' => [],
//                    'a_attr' => [],
//                    'children' => true
//                    ],
//                    [
//                    'id' => 75,
//                    'parent' => 2,
//                    'name' => 'Симонов Владислав Львович',
//                    'position' => 'Зубной техник',
//                    'date_of_employment' => '18.07.1986',
//                    'salary' => '63987',
//                    'text' => null,
//                    'childrenNumber' => 4,
//                    'hierarchyLevel' => 2,
//                    'icon' => NULL,
//                    'state' => [
//                        'opened' => false,
//                        'disabled' => false,
//                        'selected' => false,
//                    ],
//                    'li_attr' => [],
//                    'a_attr' => [],
//                    'children' => true
//                    ],
//                    [
//                        'id' => 121,
//                        'parent' => 75,
//                        'name' => 'Константин Максимович Данилов',
//                        'position' => 'Администратор',
//                        'date_of_employment' => '04.09.1989',
//                        'salary' => '54503',
//                        'text' => null,
//                        'childrenNumber' => 0,
//                        'hierarchyLevel' => 3,
//                        'icon' => NULL,
//                        'state' => [
//                            'opened' => false,
//                            'disabled' => false,
//                            'selected' => false,
//                        ],
//                        'li_attr' => [],
//                        'a_attr' => [],
//                        'children' => false
//                    ]

//            ];



        $ids = explode(',', $request->all()['ids']);

        $result = collect([]);

        foreach ($ids as $id)
        {
            $children = Employee::find($id)->children()->get();

            $collection = $children->map(function ($item, $key) use($id){
                return
                    [
                    'id' => $item->id,
                    'parent' => $item->parent_id,
                    'name' => $item->name,
                    'position' => $item->position,
                    'date_of_employment' => $item->date_of_employment,
                    'salary' => $item->salary,
                    'text' => null,
                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
                    'hierarchyLevel' => $item-> hierarchy_level,
                    'icon' => ($item->avatar !== NULL) ? './storage/users-avatars/' . $item->avatar : 'glyphicon glyphicon-user',
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

            $result->put($id, $collection);
        }
//dd($result->toArray());
//        return [['id'=>'1', 'text'=>'NOde1', 'children' =>  ['id'=>'12', 'text'=>'NOde12']], ['id'=>'2', 'text'=>'NOde2', 'children' =>  ['id'=>'22', 'text'=>'NOde22']]];

        return response (json_encode($result->toArray()), 200);








//        $collection = Employee::whereIn('id', $ids)->get();
//
//        $employees = $collection->map(function ($item, $key) {
//            return ['id' => $item->id,
//                    'parent' => $item->parent_id,
//                    'name' => $item->name,
//                    'position' => $item->position,
//                    'date_of_employment' => $item->date_of_employment,
//                    'salary' => $item->salary,
//                    'text' => null,
//                    'childrenNumber' => $childrenNumber = Employee::find($item->id)->children()->count(),
//                    'hierarchyLevel' => $item-> hierarchy_level,
//                    'icon' => ($item->avatar !== NULL) ? './storage/users-avatars/' . $item->avatar : 'glyphicon glyphicon-user',
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

    protected function distributeSubordinates(Employee $employee)
    {
        $subordinatesIds = $employee->children()->get()->pluck('id');

        if ($subordinatesIds->count() > 0 ) {

            if ($employee->parent_id === 0){
                $siblings = DB::table('employees')->where('hierarchy_level', '=', $employee->hierarchy_level)->get()->pluck('id');
            }
            else{
                $parent = Employee::find($employee->parent_id);

                $siblings = $parent->children()->get()->pluck('id');

                if ($siblings->count() <=1 ){
                    $siblings = DB::table('employees')->where('hierarchy_level', '=', $employee->hierarchy_level)->get()->pluck('id');
                }
            }

            $siblings = $siblings->reject(function ($value, $key)use($employee){
                return $value === $employee->id;
            });

            $subordinatesIds = $employee->children()->get()->pluck('id');

            foreach ($subordinatesIds as $subordinatesId) {

                $subordinate = Employee::find($subordinatesId);
                $subordinate->parent_id = $siblings->random();

                $subordinate->save();

            }
        }
    }

}
