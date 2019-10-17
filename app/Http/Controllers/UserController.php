<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Permission;
use App\Role;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use function foo\func;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //gather data
        $roles = Role::pluck('display_name', 'id')->toArray();
        $permissions = Permission::pluck('display_name', 'id')->toArray();
        $status_lists = Status::pluck('title', 'id')->toArray();
        $users = User::latest()->with(['roles','status','permissions'])->withTrashed()->get();

        //ajax call from data table
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
                    $tags = '<span class="badge badge-primary">Customer</span>';
                    if ($user->barber_verified_at){
                        $tags = $tags.'<span class="badge badge-primary margbg">Barber</span>';
                    }
                    return $tags;
                })
                ->editColumn('actions', function(User $user) {
                    return view('actions.actions_user', compact('user'))->render();
                })
                ->rawColumns(['status', 'actions','roles','is_barber'])
                ->toJson();
        }

        //rander view
        return view('user.index', compact('users','roles','status_lists','permissions'));
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
    public function store(CreateUserRequest $request)
    {
            $user = new User;
            $user->email = $request->email;
            $user->password = '';
            $user->name = $request->name;
            $user->status_id = $request->status_id;
            $user->save();
            $user->attachRoles($request->roles);
            if($request->permissions){$user->attachPermissions($request->permissions);}
            return redirect('/users');
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
        $roles = Role::pluck('display_name', 'id')->toArray();
        $permissions = Permission::pluck('display_name', 'id')->toArray();
        $status_lists = Status::pluck('title', 'id')->toArray();
        $users = User::with('roles')->get();
        $user = User::with('roles','permissions','status')->where('id',$id)->first();
        return view('user.index', compact('user','roles', 'users','status_lists','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = Validator::make($request->all(),[
            'name'=>'min:3',
            'email'=>'email',
        ]);
        if($data->fails()) {
            return Redirect::back()->withErrors($data);
        }else {
            $user->update($request->all());
            $user->syncRoles($request->roles);
            if (!$request->permissions) {
                $user->detachPermissions();
            } else {
                $user->syncPermissions($request->permissions);
            }
            return redirect('/users');
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
                $user = User::whereId($id)->first();
                if ($user->delete()) {
                    return response()->json(['success' => true, 'message' => 'user deleted successfully!']);
                }
            }
        }
    }

    public function restore($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $user = User::onlyTrashed()->whereId($id)->first();
                if ($user->restore()) {
                    return response()->json(['success' => true, 'message' => 'user restored successfully!']);
                }
            }
        }
    }

    public function deletePermanently(Request $request, $id)
    {
        $user = User::onlyTrashed()->whereId($id)->first();
        if (request()->ajax()) {
            if ($user->forceDelete()) {
                return response()->json(['success' => true, 'message' => 'User deleted permanently successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}
