<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles','status','permissions'])->withTrashed()->where('barber_verified_at','!=','null')->get();
        if (request()->ajax()){
            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('roles', function(User $user) {
                    $rolesarr = null;
                    foreach ($user->roles as $role){
                        $rolesarr = $rolesarr.'<span class="badge badge-primary margbg">'.ucfirst($role->name).'</span>';
                    }
                    return $rolesarr;
                })
                ->editColumn('status', function(User $user) {
                    $classname = 'dark';
                    if($user->status->title == 'Not Set'){
                        return '<span class="badge badge-'.$classname.'">'.$user->status->title.'</span>';
                    }else{
                        return '<span class="badge badge-'.$user->status->classname.'">'.$user->status->title.'</span>';
                    }
                })
                ->editColumn('is_barber', function(User $user) {
                    return '<span class="badge badge-primary margbg">Barber</span>';
                })
                ->editColumn('actions', function(User $barber) {
                    return view('actions.actions_barber', compact('barber'))->render();
                })
                ->rawColumns(['status', 'actions','roles','is_barber'])
                ->toJson();
        }

        //rander view
        return view('barber.index');
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
    public function destroy(User $barber)
    {
        if (request()->ajax()){
            $barber->status_id = 3;
            $barber->update();
        }
    }
    public function restore($id){
        if (request()->ajax()) {
            $barber = User::whereId($id)->first();
            $barber->status_id = 1;
            $barber->update();
        }
    }
}
