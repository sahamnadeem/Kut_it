<?php

namespace App\Http\Controllers;

use App\Booking;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with('user','barber','location','details','status','canceled_by_user')->get();
        if (request()->ajax()){
            return DataTables::of($bookings)
                ->addIndexColumn()
                ->editColumn('user', function(Booking $booking) {
                    return ucfirst($booking->user->name);
                })
                ->editColumn('barber', function(Booking $booking) {
                    return ucfirst($booking->barber->name);
                })
                ->editColumn('status', function(Booking $booking) {
                    $classname = 'dark';
                    if($booking->status->title == 'Not Set'){
                        return '<span class="badge badge-'.$classname.'">'.$booking->status->title.'</span>';
                    }else{
                        return '<span class="badge badge-'.$booking->status->color.'">'.$booking->status->title.'</span>';
                    }
                })
                ->editColumn('canceled_by', function(Booking $booking) {
                    if (trim($booking->status->title) == 'Canceled'){
                        return ucfirst($booking->canceled_by_user->name);
                    }else{
                        return '<span class="badge badge-'.$booking->status->color.'">'.$booking->status->title.'</span>';
                    }
                })
                ->rawColumns(['status', 'actions','canceled_by'])
                ->toJson();
        }

        //rander view
        return view(' bookings.index');
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
