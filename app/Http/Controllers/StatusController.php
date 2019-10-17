<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::withTrashed()->get();
        if (request()->ajax()){
            return DataTables::of($status)
                ->addIndexColumn()
                ->editColumn('classname', function(Status $status) {
                    return ucfirst($status->classname);
                })
                ->editColumn('actions', function(Status $status) {
                    return view('actions.actions_status', compact('status'))->render();
                })
                ->editColumn('title', function(Status $status) {
                    return ucfirst($status->title);
                })
                ->editColumn('created_at', function(Status $status) {
                    return date('m/d/y - H:i A',intval(strtotime($status->created_at)));
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('status.index');
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
            'title'=>'required|max:255',
            'classname' => 'required|max:255',
        ]);
        if($data->fails()) {
            return Redirect::back()->withErrors($data);
        }else {
            $status =  new Status;
            $status->title = $request->title;
            $status->classname = $request->classname;
            $status->save();
            return redirect('/status');
        }
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
    public function edit(Status $status)
    {
        return view('status.index', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $data = Validator::make($request->all(),[
            'title'=>'required|max:255',
            'classname' => 'required|max:255',
        ]);
        if($data->fails()) {
            return Redirect::back()->withErrors($data);
        }else {
            $data = $request->only('title','classname');
            $status->update($data);
            return redirect('/status');
        }
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
                $status = Status::whereId($id)->first();
                if ($status->delete()) {
                    return response()->json(['success' => true, 'message' => 'Link deleted successfully!']);
                }
            }
        }
    }

    public function restore($id){
        if (request()->ajax()) {
            if (isset($id) && !empty($id)) {
                $status = Status::onlyTrashed()->whereId($id)->first();
                if ($status->restore()) {
                    return response()->json(['success' => true, 'message' => 'Link restored successfully!']);
                }
            }
        }
    }

    public function deletePermanently(Request $request, $id)
    {
        $status = Status::onlyTrashed()->whereId($id)->first();
        if (request()->ajax()) {
            if ($status->forceDelete()) {
                return response()->json(['success' => true, 'message' => 'Link deleted permanently successfully!']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}
