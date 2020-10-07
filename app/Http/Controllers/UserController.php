<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\User;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'User';

        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add new user';
        $data['user'] = (object)[
            'id' => '',
            'name' => '',
            'email' => '',
            'password' => ''
        ];

        return view('pages.user.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'Save data successfully');
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

    public function ajax(Request $request){
        switch ($request->param) {
            case 'datatable':
                $user = User::all();
            
                return datatables()->of($user)
                                    ->addColumn('action', function($data){
                                        $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                                        $button .= '
                                            <a href="'.route('user.edit', $data->id) .'" class="btn btn-success">
                                                <i class="fas fa-cog"></i>
                                            </a>';

                                        if(Auth::user()->id != $data->id){
                                            $button .='
                                                <button type="button" class="btn btn-danger user-delete" data-id="'.$data->id .'">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            ';
                                        }

                                        return $button;
                                    })
                                    ->rawColumns(['action'])
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
        $data['page_title'] = 'Edit user';
        $data['user'] = User::find($id);

        return view('pages.user.form', $data);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        
        $user->save();

        return redirect()->route('user.index')->with('success', 'Update data successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
