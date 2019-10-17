<?php

namespace App\Http\Controllers;

use App\Notifications\FirebaseNotification;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RequestController extends Controller
{
    public function index(){
        $requests = Service::with('user')->where('status','pending')->where('created_by','!=',auth()->user()->id)->get();
        if (request()->ajax()){
            return DataTables::of($requests)
                ->addIndexColumn()
                ->editColumn('created_by_user', function(Service $service) {
                    return $service->user->name;
                })
                ->editColumn('actions', function(Service $service) {
                    return view('actions.actions_service_requests', compact('service'))->render();
                })
                ->rawColumns(['status', 'actions','roles','is_barber'])
                ->toJson();
        }
    }

    public function barberIndex(){
        $user = User::with('status')->where('status_id',1)->where('is_barber',1)->where('barber_verified_at',null)->get();
        if (request()->ajax()){
            return DataTables::of($user)
                ->addIndexColumn()
                ->editColumn('actions', function(User $user) {
                    return view('actions.actions_service_requests', compact('user'))->render();
                })
                ->editColumn('status', function(User $user) {
                    $classname = 'dark';
                    if($user->status->title == 'Not Set'){
                        return '<span class="badge badge-'.$classname.'">'.$user->status->title.'</span>';
                    }else{
                        return '<span class="badge badge-'.$user->status->classname.'">'.$user->status->title.'</span>';
                    }
                })
                ->rawColumns(['status', 'actions','roles','is_barber'])
                ->toJson();
        }
    }

    public function service($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $service = Service::whereId($id)->first();
                $user = User::whereId($service->created_by)->first();
                if ($service->update(['status'=>'active'])) {
                    $user->services()->attach([$service->id]);
                    return response()->json(['success' => true, 'message' => 'Service created successfully!']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
                }
            }
        }
    }

    public function barber($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $user = User::whereId($id)->first();
                if ($user->update(['barber_verified_at'=>Carbon::now()])) {
                    $user->notify(new FirebaseNotification($user));
                    return response()->json(['success' => true, 'message' => 'Baber created successfully!']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
                }
            }
        }
    }

    public function rejectservice($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $service = Service::whereId($id)->first();
                if ($service->delete()) {
                    return response()->json(['success' => true, 'message' => 'Service request rejected!']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
                }
            }
        }
    }
    public function rejectbarber($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $barber = User::whereId($id)->where('is_barber',1)->where('barber_verified_at',null)->first();
                if ($barber->update(['is_barber'=>0])) {
                    return response()->json(['success' => true, 'message' => 'Barber request rejected!']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
                }
            }
        }
    }
}
