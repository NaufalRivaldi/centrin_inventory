<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Device;
use App\Models\Division;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Device';
        $data['divisions'] = Division::all();
        
        // datatable ajax
        if($request->ajax()){
            if($request->filter_site == null){
                $devices = Device::all();
            }else{
                if($request->filter_site == ''){
                    $devices = Device::all();
                }else{
                    $filter_site = $request->filter_site;
                    $devices = Device::whereHas('device_divisions', function($query)use($filter_site){
                        $query->where('division_id', $filter_site);
                    });
                }
            }
            
            return datatables()->of($devices)
                                ->addColumn('device_status', function($data){
                                    return status($data);
                                })
                                ->addColumn('computer_count', function($data){
                                    return $data->computer_devices->count().' Computer';
                                })
                                ->addColumn('action', function($data){
                                    $button = '
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-info software-detail" data-toggle="modal" data-target="#modalDetail" data-id="'.$data->id.'">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="'.route('inventory.software.edit', $data->id) .'" class="btn btn-success">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger software-delete" data-id="'.$data->id .'">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    ';

                                    return $button;
                                })
                                ->rawColumns(['computer_count', 'action'])
                                ->addIndexColumn()
                                ->make(true);
        }
        
        return view('pages.inventory.software.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
