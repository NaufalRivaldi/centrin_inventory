<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Device;
use App\Models\DeviceDivision;
use App\Models\Division;
use App\Models\ComputerDevice;

use Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Device';
        $data['divisions'] = Division::all();
        
        return view('pages.inventory.device.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add new Device';
        $data['device'] = (object)[
            'id' => '',
            'device_name' => '',
            'device_status' => 1,
            'device_type' => '',
            'device_brand' => '',
            'device_ipaddress' => '',
            'device_description' => '',
            'device_inventorynumber' => '',
            'device_invoiceno' => '',
            'device_scannedinvoice' => '',
            'updated_by' => '',
            'device_divisions' => (object)[
                'division_id' => ''
            ]
        ];
        $data['divisions'] = Division::all();

        return view('pages.inventory.device.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ====================================
        // Upload file
        // ====================================
        $file_name = null;
        if(!empty($request->file('device_scannedinvoice'))){
            $file = $request->file('device_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($file_name, 1, $file);
        }

        // ====================================
        // Add data to database
        // ====================================
        Device::create([
            'device_name' => $request->device_name,
            'device_status' => $request->device_status,
            'device_type' => $request->device_type,
            'device_brand' => $request->device_brand,
            'device_ipaddress' => $request->device_ipaddress,
            'device_description' => $request->device_description,
            'device_inventorynumber' => $request->device_inventorynumber,
            'device_invoiceno' => $request->device_invoiceno,
            'device_scannedinvoice' => $file_name,
            'updated_by' => Auth::user()->name,
        ]);
        
        $device = Device::orderBy('id', 'desc')->first();
        DeviceDivision::create([
            'device_id' => $device->id,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('inventory.device.index')->with('success', 'Save data successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $device = Device::find($id);

        return response()->json($device);
    }

    public function showModal($id){
        $computer_devices = ComputerDevice::with(['computer'])->where('device_id', $id)->get();
            
        return datatables()->of($computer_devices)
                            ->addIndexColumn()
                            ->make(true);
    }

    public function ajax(Request $request){
        switch ($request->param) {
            case 'datatable':
                if($request->filter_site == null){
                    $devices = Device::with(['device_divisions.division'])->get();
                }else{
                    if($request->filter_site == ''){
                        $devices = Device::with(['device_divisions.division'])->get();
                    }else{
                        $filter_site = $request->filter_site;
                        $devices = Device::with(['device_divisions.division'])->whereHas('device_divisions', function($query)use($filter_site){
                            $query->where('division_id', $filter_site);
                        });
                    }
                }
                
                return datatables()->of($devices)
                                    ->addColumn('device_status', function($data){
                                        return status($data->device_status);
                                    })
                                    ->addColumn('computer_count', function($data){
                                        return $data->computer_devices->count().' Computer';
                                    })
                                    ->addColumn('device_invoiceno', function($data){
                                        $text = $data->device_invoiceno;
    
                                        if($data->device_scannedinvoice != null){
                                            $text = $text.'<a href="'.asset('upload/inventory/device/'. $data->device_scannedinvoice).'" class="btn btn-success btn-sm">Show</a>';
                                        }
    
                                        return $text;
                                    })
                                    ->addColumn('action', function($data){
                                        $button = '
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-info device-detail" data-toggle="modal" data-target="#modalDetail" data-id="'.$data->id.'">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a href="'.route('inventory.device.edit', $data->id) .'" class="btn btn-success">
                                                <i class="fas fa-cog"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger device-delete" data-id="'.$data->id .'">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        ';
    
                                        return $button;
                                    })
                                    ->rawColumns(['device_status', 'computer_count', 'device_invoiceno', 'action'])
                                    ->addIndexColumn()
                                    ->make(true);
                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Data Device';
        $data['device'] = Device::find($id);
        $data['divisions'] = Division::all();

        return view('pages.inventory.device.form', $data);
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
        // ====================================
        // Upload file and delete file older
        // ====================================
        $file_name = null;
        if(!empty($request->file('device_scannedinvoice'))){
            $file = $request->file('device_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($request->device_scannedinvoice_old, 2);
            $this->manageImage($file_name, 1, $file);
        }else{
            $file_name = $request->device_scannedinvoice_old;
        }

        // ====================================
        // Update data on database
        // ====================================
        $data = Device::find($id);
        $data->device_name = $request->device_name;
        $data->device_status = $request->device_status;
        $data->device_type = $request->device_type;
        $data->device_brand = $request->device_brand;
        $data->device_ipaddress = $request->device_ipaddress;
        $data->device_description = $request->device_description;
        $data->device_inventorynumber = $request->device_inventorynumber;
        $data->device_invoiceno = $request->device_invoiceno;
        $data->device_scannedinvoice = $file_name;
        $data->updated_by = Auth::user()->name;
        $data->save();
        
        $device_division = DeviceDivision::find($data->device_divisions->id);
        $device_division->division_id = $request->division_id;
        $device_division->save();

        return redirect()->route('inventory.device.index')->with('success', 'Update data successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Device::find($id);
        $this->manageImage($data->device_scannedinvoice, 2);

        $data->delete();
    }

    /**
     * Remove the image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $data = Device::find($id);
        $this->manageImage($data->device_scannedinvoice, 2);
        $data->device_scannedinvoice = null;
        $data->save();
    }

    // ============================================
    // Manage Image scanned invoice
    // ============================================
    private function manageImage($file_name, $type, $file = null){
        $path = 'upload/inventory/device/';

        switch ($type) {
            case '1':
                $file->move($path, $file_name);
                break;

            case '2':
                if(file_exists(public_path().'/'.$path.$file_name) && $file_name != null){
                    unlink($path.'/'.$file_name);
                }
                break;
            
            default:
                # code...
                break;
        }
    }
}
