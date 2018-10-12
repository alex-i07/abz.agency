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

        $collection = DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')->where('name', 'LIKE', [$str . '%'])
            ->union(DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')->where('position', 'LIKE', [$str . '%']))
            ->union(DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')->where('date_of_employment', 'LIKE', [$str . '%']))
            ->union(DB::table('employees')->select('id', 'parent_id', 'hierarchy_level', 'name', 'position', 'date_of_employment', 'salary')->where('salary', 'LIKE', [$str . '%']))->get();

        if($collection->isEmpty()){
            return response('No records found', 200);
        }

        $allParentIds = collect([]);

        foreach($collection as $value){

            $currentParentId = $value->parent_id;

            while($currentParentId > 0) { //or >=0?/ no, roots already loaded

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
            'date_of_employment'     => 'required|date_format:Y-m-d',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
        ]);

        $employee = Employee::where('email', '=', $request->email);

        $id = $employee->get()[0]->id;

        if ($request->avatar) {

            $path = $employee->get()[0]->avatar;

            //delete previous file if exists

            if(Storage::exists('public/users-avatars/' . $path)){
                Storage::delete('public/users-avatars/' . $path);
            }

            $request->file('avatar')->store('public/users-avatars');

            $path = $request->file('avatar')->hashName();

        }
        else {
            $path = null;
        }

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

        $employee = Employee::where('email', '=', $request->email)->first();

        $this->distributeSubordinates($employee);

        $employee->delete();

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
            'date_of_employment' => 'required|date_format:Y-m-d',
            'salary'     => 'required|numeric',
            'parent_id'     => 'required|numeric',
            'hierarchy_level' => 'required|numeric'

        ]);

        if ($request->avatar) {

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

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function dragDrop (Request $request)
    {

        $oldParentId = $request->oldParentId;
        $newParentId = $request->newParentId;
        $id = $request->id;

        $employee = Employee::find($id);

        $employee->parent_id = $newParentId;

        if ($newParentId == 0){
            $employee->hierarchy_level = 1;
        }
        else{
            $newHierarchyLevel = Employee::find($newParentId)->hierarchy_level;

            $employee->hierarchy_level = $newHierarchyLevel - 1;
        }

        $this->distributeSubordinates($employee);

        $employee->save();

        return response('Drag and drop successfull', 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function fetchMassload (Request $request)
    {

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

        return response (json_encode($result->toArray()), 200);

    }

    /**
     * Distribute subordinates when employee deleted or drag-n-droped
     *
     * @param Employee $employee
     */

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
