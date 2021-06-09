<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use Auth;

class AuditController extends Controller
{
    /**
     * Show audit view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $itemsPerPage = $request->input('items',5);
        $filterValue = $request->input('filterValue');

        $audits = Audit::query();
        if(!Auth::user()->flag_admin){
            $audits->where('user_id', '=', Auth::user()->id);
            $audits = $audits->paginate($itemsPerPage);
        }else{
            $audits->Where('old_values', 'like', '%'.$filterValue.'%');
            $audits = $audits->orWhere('new_values', 'like', '%'.$filterValue.'%');
            $audits = ($sort && $direction ) ? $audits->orderBy($sort, $direction) : $audits;
            $audits = $audits->paginate($itemsPerPage);
        }

        return view('audit', [ 'audits' => $audits, 'items' => $itemsPerPage, 'filterValue' => $filterValue ]);
    }

}
