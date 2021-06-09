<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $itemsPerPage = $request->input('items',5);
        $filterValue = $request->input('filterValue');

        $users = User::query();
        if(!Auth::user()->flag_admin){
            $users->where('id', '=', Auth::user()->id);
            $users = $users->paginate($itemsPerPage);
        }else{
            $users->Where('name', 'like', '%'.$filterValue.'%');
            $users = $users->orWhere('phone_number', 'like', '%'.$filterValue.'%');
            $users = $users->orWhere('email', 'like', '%'.$filterValue.'%');
            $users = ($sort && $direction ) ? $users->orderBy($sort, $direction) : $users;
            $users = $users->paginate($itemsPerPage);
        }
        return view('home', [ 'users' => $users, 'items' => $itemsPerPage, 'filterValue' => $filterValue ]);
    }
}
