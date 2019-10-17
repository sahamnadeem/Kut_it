<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Status;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status_lists = Status::all();
        $permissions = Permission::with('status')->withTrashed()->get();
        if (request()->ajax()){
            return DataTables::of($permissions)
                ->addIndexColumn()
                ->editColumn('created_at', function(Permission $perm) {
                    return date('m/d/y - H:i A',intval(strtotime($perm->created_at)));
                })
                ->editColumn('status', function(Permission $perm) {
                    $classname = 'dark';
                    if($perm->status->title == 'Not Set'){
                        return '<span class="badge badge-'.$classname.'">'.$perm->status->title.'</span>';
                    }else{
                        return '<span class="badge badge-'.$perm->status->classname.'">'.$perm->status->title.'</span>';
                    }
                })
                ->editColumn('actions', function(Permission $perm) {
                    return view('actions.actions_permission', compact('perm'))->render();
                })
                ->rawColumns(['status', 'actions'])
                ->toJson();
        }
        return view('permissions.index', compact('permissions','status_lists'));
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
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $permission = Permission::whereId($id)->first();
                if ($permission->delete()) {
                    return response()->json(['success' => true, 'message' => 'Permission deleted successfully!']);
                }
            }
        }
    }

    public function restore($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $permission = Permission::onlyTrashed()->whereId($id)->first();
                if ($permission->restore()) {
                    return response()->json(['success' => true, 'message' => 'Permission restored successfully!']);
                }
            }
        }
    }

    public function deletePermanently(Request $request, $id)
    {
        $permission = Permission::onlyTrashed()->whereId($id)->first();
        if (request()->ajax()) {
            if ($permission->forceDelete()) {
                return response()->json(['success' => true, 'message' => 'Permission deleted permanently successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}
