<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ComputerHistory;

class LogController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Log Activity';

        // datatable ajax
        if($request->ajax()){
            $log = ComputerHistory::with('user')->orderBy('id', 'desc')->get();
            
            return datatables()->of($log)
                                ->addIndexColumn()
                                ->make(true);
        }

        return view('pages.inventory.log.index', $data);
    }
}
