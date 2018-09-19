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
        $firstEmployee = ['text' => Employee::first()->name,
                                  'tags' => Employee::first()->children()->count()];


//        JavaScript::put([
//            'foo' => 'bar'
//        ]);

        return view('welcome', compact('firstEmployee'));
//        return view('welcome', ['firstEmployee' => $firstEmployee]);
    }
}
