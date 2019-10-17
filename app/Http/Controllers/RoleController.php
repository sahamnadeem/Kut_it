<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('created_by_user:id,name,email','permissions')->withTrashed()->get();
        $permissions = Permission::all();
        if (request()->ajax()){
            return DataTables::of($roles)
                ->addIndexColumn()
                ->editColumn('created_by', function(Role $role) {
                    return ucfirst($role->created_by_user->name);
                })
                ->editColumn('actions', function(Role $role) {
                    return view('actions.actions_role', compact('role'))->render();
                })
                ->editColumn('description', function(Role $role) {
                    return substr($role->description,0,20).'.....';
                })
                ->editColumn('created_at', function(Role $role) {
                    return date('m/d/y - H:i A',intval(strtotime($role->created_at)));
                })
                ->editColumn('display_name', function(Role $role) {
                    return ucfirst($role->display_name);
                })
                ->rawColumns(['link', 'actions'])
                ->toJson();
        }
        return view('roles.show', compact('roles','permissions'));
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
        $data = Validator::make($request->all(),[
            'name'=>'required|max:255|unique:roles',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        if($data->fails()) {
            return Redirect::back()->withErrors($data);
        }else {
            $role = new Role;
            $request->display_name = ucfirst($request->display_name);
            $role->create($request->all());
            $role->attachPermissions($request->permissions);
            return redirect('/roles');
        }
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
        $permissions = Permission::all();
        $role = Role::whereId($id)->first();
        return view('roles.show', compact('role','permissions'));
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
        $data = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        if($data->fails()) {
            return Redirect::back()->withErrors($data);
        }else {
            $role = Role::whereId($id)->first();
            $role->update($request->all());
            $role->detachPermissions();
            if ($request->permissions){
                $role->attachPermissions($request->permissions);
            }
            return redirect('/roles');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $role = Role::whereId($id)->first();
                if ($role->delete()) {
                    return response()->json(['success' => true, 'message' => 'Link deleted successfully!']);
                }
            }
        }
    }

    public function restore($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $role = Role::onlyTrashed()->whereId($id)->first();
                if ($role->restore()) {
                    return response()->json(['success' => true, 'message' => 'Link restored successfully!']);
                }
            }
        }
    }

    public function deletePermanently(Request $request, $id)
    {
        $role = Role::onlyTrashed()->whereId($id)->first();
        if (request()->ajax()) {
            if ($role->forceDelete()) {
                return response()->json(['success' => true, 'message' => 'Link deleted permanently successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}
