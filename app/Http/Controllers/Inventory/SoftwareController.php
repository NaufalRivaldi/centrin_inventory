<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Inventory\SoftwareRequest;
use Illuminate\Support\Str;

use App\Models\Software;
use App\Models\Division;
use App\Models\SoftwareDivision;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Software';
        $data['divisions'] = Division::all();
        
        // datatable ajax
        if($request->ajax()){
            if($request->filter_site == null){
                $softwares = Software::all();
            }else{
                if($request->filter_site == ''){
                    $softwares = Software::all();
                }else{
                    $filter_site = $request->filter_site;
                    $softwares = Software::whereHas('software_divisions', function($query)use($filter_site){
                        $query->where('division_id', $filter_site);
                    });
                }
            }
            
            return datatables()->of($softwares)
                                ->addColumn('computer_count', function($data){
                                    return $data->computer_softwares->count().' Computer';
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
        $data['page_title'] = 'Add new Software';
        $data['software'] = (object)[
            'id' => '',
            'software_name' => '',
            'software_serial' => '',
            'software_maxdevice' => '',
            'software_invoiceno' => '',
            'software_scannedinvoice' => '',
            'updated_by' => '',
            'software_divisions' => (object)[
                'division_id' => ''
            ]
        ];
        $data['divisions'] = Division::all();

        return view('pages.inventory.software.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SoftwareRequest $request)
    {
        // ====================================
        // Upload file
        // ====================================
        $file_name = null;
        if(!empty($request->file('software_scannedinvoice'))){
            $file = $request->file('software_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($file_name, 1, $file);
        }

        // ====================================
        // Add data to database
        // ====================================
        Software::create([
            'software_name' => $request->software_name,
            'software_serial' => $request->software_serial,
            'software_maxdevice' => $request->software_maxdevice,
            'software_invoiceno' => $request->software_invoiceno,
            'software_scannedinvoice' => $file_name,
            'updated_by' => 'Tester',
        ]);
        
        $software = Software::orderBy('id', 'desc')->first();
        SoftwareDivision::create([
            'software_id' => $software->id,
            'division_id' => $request->site,
        ]);

        return redirect()->route('inventory.software.index')->with('success', 'Save data successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Software::with('software_divisions.division')->where('id', $id)->first();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Data Software';
        $data['software'] = Software::find($id);
        $data['divisions'] = Division::all();

        return view('pages.inventory.software.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SoftwareRequest $request, $id)
    {
        // ====================================
        // Upload file and delete file older
        // ====================================
        $file_name = null;
        if(!empty($request->file('software_scannedinvoice'))){
            $file = $request->file('software_scannedinvoice');
            $file_name = Str::random(10).'-scan-invoice.'.$file->getClientOriginalExtension();
            $this->manageImage($request->software_scannedinvoice_old, 2);
            $this->manageImage($file_name, 1, $file);
        }else{
            $file_name = $request->software_scannedinvoice_old;
        }

        // ====================================
        // Update data on database
        // ====================================
        $data = Software::find($id);
        $data->software_name = $request->software_name;
        $data->software_serial = $request->software_serial;
        $data->software_maxdevice = $request->software_maxdevice;
        $data->software_invoiceno = $request->software_invoiceno;
        $data->software_scannedinvoice = $file_name;
        $data->updated_by = 'Tester';
        $data->save();
        
        $software_division = SoftwareDivision::find($data->software_divisions->id);
        $software_division->division_id = $request->site;
        $software_division->save();

        return redirect()->route('inventory.software.index')->with('success', 'Update data successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Software::find($id);
        $this->manageImage($data->software_scannedinvoice, 2);

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
        $data = Software::find($id);
        $this->manageImage($data->software_scannedinvoice, 2);
        $data->software_scannedinvoice = null;
        $data->save();
    }

    // ============================================
    // Manage Image scanned invoice
    // ============================================
    private function manageImage($file_name, $type, $file = null){
        $path = 'upload/inventory/software/';

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
