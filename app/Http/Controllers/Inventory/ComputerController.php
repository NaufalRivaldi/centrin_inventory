<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Computer;
use App\Models\ComputerDivision;
use App\Models\ComputerDevice;
use App\Models\ComputerSoftware;
use App\Models\ComputerComponent;
use App\Models\ComputerHistory;
use App\Models\Division;
use App\Models\Software;
use App\Models\Device;

use Request as newRequest;

use Auth;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Computer';
        $data['divisions'] = Division::all();
        
        return view('pages.inventory.computer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add new Computer';
        $data['computer'] = (object)[
            'id' => '',
            'computer_name' => '',
            'computer_status' => 1,
            'computer_type' => 'Laptop',
            'monitor' => '',
            'monitor_size' => '',
            'manufactur' => '',
            'model' => '',
            'processor' => '',
            'operatingsystem' => '',
            'operatingsystem_serial' => '',
            'inventory_number' => '',
            'department' => '',
            'computer_ipaddress' => '',
            'computer_invoiceno' => '',
            'computer_scannedinvoice' => '',
            'updated_by' => '',
            'computer_divisions' => (object)[
                'division_id' => ''
            ]
        ];
        $data['divisions'] = Division::all();
        $data['softwares'] = Software::select('software_name')->groupBy('software_name')->get();
        $data['devices'] = Device::where('device_status', 1)->get();
        $data['departments'] = [
            'Dummy1',
            'Dummy2',
            'Dummy3',
        ];
        $data['memory_types'] = [
            'DDR1',
            'DDR2',
            'DDR3'
        ];
        $data['memory_unit_sizes'] = [
            'GB',
            'MB',
            'KB'
        ];
        $data['harddrive_unit_sizes'] = [
            'MB',
            'GB',
            'TB'
        ];

        return view('pages.inventory.computer.form', $data);
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
        if(!empty($request->file('computer_scannedinvoice'))){
            $file = $request->file('computer_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($file_name, 1, $file);
        }

        // ====================================
        // Add data to database
        // ====================================
        Computer::create([
            'computer_name' => $request->computer_name,
            'computer_status' => $request->computer_status,
            'computer_type' => $request->computer_type,
            'monitor' => $request->monitor,
            'manufactur' => $request->manufactur,
            'model' => $request->model,
            'processor' => $request->processor,
            'inventory_number' => $request->inventory_number,
            'department' => $request->department,
            'computer_ipaddress' => $request->computer_ipaddress,
            'computer_invoiceno' => $request->computer_invoiceno,
            'computer_scannedinvoice' => $file_name,
            'updated_by' => Auth::user()->name,
        ]);
        
        $computer = Computer::orderBy('id', 'desc')->first();
        ComputerDivision::create([
            'computer_id' => $computer->id,
            'division_id' => $request->division_id,
        ]);

        // ====================================
        // Computer component - memory
        // ====================================
        for($i = 0; $i < count($request->memory_type); $i++){
            $component_size = ($request->memory_size[$i] != null ? $request->memory_size[$i] : '0').' '.$request->memory_unit_size[$i];
            
            ComputerComponent::create([
                'computer_id' => $computer->id,
                'component_name' => $request->memory_type[$i],
                'component_size' => $component_size,
                'component_type' => 'Memory'
            ]);
        }

        // ====================================
        // Computer component - harddrive
        // ====================================
        for($i = 0; $i < count($request->harddrive_brand); $i++){
            $component_size = ($request->harddrive_size[$i] != null ? $request->harddrive_size[$i] : '0').' '.$request->harddrive_unit_size[$i];
            
            ComputerComponent::create([
                'computer_id' => $computer->id,
                'component_name' => $request->harddrive_brand[$i],
                'component_size' => $component_size,
                'component_type' => 'Harddrive'
            ]);
        }

        // ====================================
        // Computer software
        // ====================================
        for($i = 0; $i < count($request->software_serial_number); $i++){
            if($request->software_serial_number[$i] != null){
                $software = Software::find($request->software_serial_number[$i]);

                ComputerSoftware::create([
                    'computer_id' => $computer->id,
                    'software_id' => $request->software_serial_number[$i],
                    'division_id' => $request->division_id,
                    'software_name' => $software->software_name,
                    'software_serial' => $software->software_serial
                ]);
            }
        }

        // ====================================
        // Computer device
        // ====================================
        for($i = 0; $i < count($request->device_id); $i++){
            if($request->device_id[$i] != null){
                ComputerDevice::create([
                    'computer_id' => $computer->id,
                    'device_id' => $request->device_id[$i],
                ]);
            }
        }

        $this->logActivity($computer, 1);

        return redirect()->route('inventory.computer.index')->with('success', 'Save data successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page_title'] = 'Computer Detail';
        $data['computer'] = Computer::find($id);
        return view('pages.inventory.computer.detail', $data);
    }

    public function json($param){
        switch ($param) {
            case 'software':
                $computer = Computer::find($_GET['computer_id']);
                return datatables()->of($computer->computer_softwares)
                                ->addIndexColumn()
                                ->make(true);
                break;

            case 'device':
                $computer = ComputerDevice::with('device')->where('computer_id', $_GET['computer_id'])->get();
                return datatables()->of($computer)
                                ->addIndexColumn()
                                ->make(true);
                break;
            default:
                # code...
                break;
        }
    }

    public function ajax(Request $request){
        switch ($request->param) {
            case 'datatable':
                $computer = Computer::with(['computer_divisions.division'])->where('computer_status', 1)->get();
            
                if($request->filter_site == ''){
                    $computer = Computer::with(['computer_divisions.division'])->where('computer_status', 1)->get();

                    if($request->filter_status != null){
                        $computer = Computer::with(['computer_divisions.division'])->where('computer_status', 'like', '%'.$request->filter_status.'%')->get();
                    }
                }else{
                    $filter_site = $request->filter_site;
                    $computer = Computer::with(['computer_divisions.division'])->whereHas('computer_divisions', function($query)use($filter_site){
                        $query->where('division_id', $filter_site);
                    })->where('computer_status', 1);

                    if($request->filter_status != null){
                        $computer = Computer::with(['computer_divisions.division'])->whereHas('computer_divisions', function($query)use($filter_site){
                            $query->where('division_id', $filter_site);
                        })->where('computer_status', 'like', '%'.$request->filter_status.'%');
                    }
                }
                
                return datatables()->of($computer)
                                    ->addColumn('computer_status', function($data){
                                        return status($data->computer_status);
                                    })
                                    ->addColumn('memory', function($data){
                                        $text = '';
                                        foreach($data->computer_components as $row){
                                            if($row->component_type == 'Memory'){
                                                $text .= $row->component_name.' '.$row->component_size.', ';
                                            }
                                        }

                                        $text = substr($text, 0, -2);

                                        return $text;
                                    })
                                    ->addColumn('harddrive', function($data){
                                        $text = '';
                                        foreach($data->computer_components as $row){
                                            if($row->component_type == 'Harddrive'){
                                                $text .= $row->component_name.' '.$row->component_size.', ';
                                            }
                                        }

                                        $text = substr($text, 0, -2);

                                        return $text;
                                    })
                                    ->addColumn('action', function($data){
                                        $button = '
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="'.route('inventory.computer.show', $data->id).'" class="btn btn-info">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <a href="'.route('inventory.computer.edit', $data->id) .'" class="btn btn-success">
                                                <i class="fas fa-cog"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger computer-delete" data-id="'.$data->id .'">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        ';

                                        return $button;
                                    })
                                    ->rawColumns(['computer_status','memory', 'harddrive', 'action'])
                                    ->addIndexColumn()
                                    ->make(true);
                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Search serial number return data json.
     *
     */
    public function searchSoftware(Request $request)
    {
        $software = Software::where('software_name', $request->software_name)->get();

        return response()->json($software);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit data Computer';
        $data['computer'] = Computer::with(['computer_divisions'])->where('id', $id)->first();
        ;
        $data['divisions'] = Division::all();
        $data['softwares'] = Software::select('software_name')->groupBy('software_name')->get();
        $data['devices'] = Device::where('device_status', 1)->get();
        $data['departments'] = [
            'Dummy1',
            'Dummy2',
            'Dummy3',
        ];
        $data['memory_types'] = [
            'DDR1',
            'DDR2',
            'DDR3',
            'DDR4',
        ];
        $data['memory_unit_sizes'] = [
            'GB',
            'MB',
            'KB'
        ];
        $data['harddrive_unit_sizes'] = [
            'MB',
            'GB',
            'TB'
        ];

        return view('pages.inventory.computer.form', $data);
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
        if(!empty($request->file('computer_scannedinvoice'))){
            $file = $request->file('computer_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($request->computer_scannedinvoice_old, 2);
            $this->manageImage($file_name, 1, $file);
        }else{
            $file_name = $request->computer_scannedinvoice_old;
        }

        // ====================================
        // Update data on database
        // ====================================
        $computer = Computer::find($id);
        $computer->computer_name = $request->computer_name;
        $computer->computer_status = $request->computer_status;
        $computer->computer_type = $request->computer_type;
        $computer->monitor = $request->monitor;
        $computer->manufactur = $request->manufactur;
        $computer->model = $request->model;
        $computer->processor = $request->processor;
        $computer->inventory_number = $request->inventory_number;
        $computer->department = $request->department;
        $computer->computer_ipaddress = $request->computer_ipaddress;
        $computer->computer_scannedinvoice = $file_name;
        $computer->updated_by = Auth::user()->name;
        $computer->save();
        
        $computer_division = ComputerDivision::where('computer_id', $computer->id)->first();
        $computer_division->division_id = $request->division_id;
        $computer_division->save();

        // ====================================
        // Computer component - memory
        // ====================================
        ComputerComponent::where('computer_id', $computer->id)->where('component_type', 'Memory')->delete();
        if(!empty($request->memory_type)){
            for($i = 0; $i < count($request->memory_type); $i++){
                $component_size = ($request->memory_size[$i] != null ? $request->memory_size[$i] : '0').' '.$request->memory_unit_size[$i];
                
                ComputerComponent::create([
                    'computer_id' => $computer->id,
                    'component_name' => $request->memory_type[$i],
                    'component_size' => $component_size,
                    'component_type' => 'Memory'
                ]);
            }
        }

        // ====================================
        // Computer component - harddrive
        // ====================================
        ComputerComponent::where('computer_id', $computer->id)->where('component_type', 'Harddrive')->delete();
        if(!empty($request->harddrive_brand)){
            for($i = 0; $i < count($request->harddrive_brand); $i++){
                $component_size = ($request->harddrive_size[$i] != null ? $request->harddrive_size[$i] : '0').' '.$request->harddrive_unit_size[$i];
                
                ComputerComponent::create([
                    'computer_id' => $computer->id,
                    'component_name' => $request->harddrive_brand[$i],
                    'component_size' => $component_size,
                    'component_type' => 'Harddrive'
                ]);
            }
        }

        // ====================================
        // Computer software
        // ====================================
        ComputerSoftware::where('computer_id', $computer->id)->delete();
        if(!empty($request->software_serial_number)){
            for($i = 0; $i < count($request->software_serial_number); $i++){
                if($request->software_serial_number[$i] != null){
                    $software = Software::find($request->software_serial_number[$i]);
    
                    ComputerSoftware::create([
                        'computer_id' => $computer->id,
                        'software_id' => $request->software_serial_number[$i],
                        'division_id' => $request->division_id,
                        'software_name' => $software->software_name,
                        'software_serial' => $software->software_serial
                    ]);
                }
            }
        }

        // ====================================
        // Computer device
        // ====================================
        ComputerDevice::where('computer_id', $computer->id)->delete();
        if(!empty($request->device_id)){
            for($i = 0; $i < count($request->device_id); $i++){
                if($request->device_id[$i] != null){
                    ComputerDevice::create([
                        'computer_id' => $computer->id,
                        'device_id' => $request->device_id[$i],
                    ]);
                }
            }
        }

        $this->logActivity($computer, 2);

        return redirect()->route('inventory.computer.index')->with('success', 'Update data successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Computer::find($id);
        $this->logActivity($data, 3);
        $this->manageImage($data->computer_scannedinvoice, 2);
        $data->computer_status = 0;
        $data->save();
    }

    /**
     * Remove the image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $data = Computer::find($id);
        $this->manageImage($data->computer_scannedinvoice, 2);
        $data->computer_scannedinvoice = null;
        $data->save();
    }

    // ============================================
    // Manage Image scanned invoice
    // ============================================
    private function manageImage($file_name, $type, $file = null){
        $path = 'upload/inventory/computer/';

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

    // ============================================
    // Manage Log Activity for computer
    // ============================================
    private function logActivity($computer, $type){
        switch ($type) {
            case 1:
                ComputerHistory::create([
                    'computer_id' => $computer->id,
                    'computer_name' => $computer->computer_name,
                    'description' => Auth::user()->name.' creating computer '.$computer->computer_name.'.',
                    'user_id' => Auth::user()->id,
                    'user_ipaddress' => newRequest::ip(),
                ]);
                break;

            case 2:
                ComputerHistory::create([
                    'computer_id' => $computer->id,
                    'computer_name' => $computer->computer_name,
                    'description' => Auth::user()->name.' updating computer '.$computer->computer_name.'.',
                    'user_id' => Auth::user()->id,
                    'user_ipaddress' => newRequest::ip(),
                ]);
                break;

            case 3:
                ComputerHistory::create([
                    'computer_id' => $computer->id,
                    'computer_name' => $computer->computer_name,
                    'description' => Auth::user()->name.' deleteing computer '.$computer->computer_name.'.',
                    'user_id' => Auth::user()->id,
                    'user_ipaddress' => newRequest::ip(),
                ]);
                break;
            
            default:
                # code...
                break;
        }
    }
}
