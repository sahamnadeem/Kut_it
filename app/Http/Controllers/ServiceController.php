<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::withTrashed()->where('created_by',auth()->user()->id)->get();
        if (request()->ajax()){
            return DataTables::of($services)
                ->addIndexColumn()
                ->editColumn('actions', function(Service $service) {
                    return view('actions.actions_service', compact('service'))->render();
                })
                ->editColumn('created_at', function(Service $service) {
                    return date('m/d/y - H:i A',intval(strtotime($service->created_at)));
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('services.index',compact('services'));
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
    public function store(CreateServiceRequest $request)
    {
            $service =  new Service;
            $service->title = $request->title;
            $service->price = $request->price;
            $service->save();
            return redirect('/services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.index', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, Service $service)
    {
        $data = $request->only('title','price');
        $service->update($data);
        return redirect('/services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $service = Service::whereId($id)->first();
                if ($service->delete()) {
                    return response()->json(['success' => true, 'message' => 'Link deleted successfully!']);
                }
            }
        }
    }

    public function restore($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $service = Service::onlyTrashed()->whereId($id)->first();
                if ($service->restore()) {
                    return response()->json(['success' => true, 'message' => 'Link restored successfully!']);
                }
            }
        }
    }

    public function deletePermanently(Request $request, $id)
    {
        $service = Service::onlyTrashed()->whereId($id)->first();
        if (request()->ajax()) {
            if ($service->forceDelete()) {
                return response()->json(['success' => true, 'message' => 'Link deleted permanently successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}
