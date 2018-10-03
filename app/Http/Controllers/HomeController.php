<?php

namespace App\Http\Controllers;

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
            ->orWhereRaw('salary LIKE ?', ['%' . $str . '%'])
            ->get();

        if($collection->isEmpty()){
            return response('No records found', 200);
        }

        $allParentIds = collect([]);

        foreach($collection as $value){

            $currentParentId = $value->parent_id;

            while($currentParentId > 0) {

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

        $ids = DB::table('employees')->where('email', '=', $request->email)->first()->id;

        $ids = collect($ids);

        $idsToRemove = collect([]);

        $idsToRemove = $idsToRemove->merge($ids)->unique();

        while($ids->isNotEmpty()){

            $ids = DB::table('employees')->whereIn('parent_id', $ids->toArray())->get()->pluck('id');

            $idsToRemove = $idsToRemove->merge($ids)->unique();

        }

        DB::table('employees')->whereIn('parent_id', $idsToRemove->toArray())->delete();

        DB::table('employees')->where('email', '=', $request->email)->delete();

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

        $chiefsPerLevel = json_encode($chiefsPerLevel);

        return view('create', compact('chiefsPerLevel'));
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

}
