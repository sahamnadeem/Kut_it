<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function balance(){
        $user = User::whereId(auth()->id())->first();
        return response()->json(['balance'=>$user->balance]);
    }

    public function wallet(){
        $data = [];
        $bookings = Booking::where('barber_id',auth()->id())->whereDate('created_at','>=',date('Y-m-d H:i:s', strtotime('-24 hours')))->paginate(10);
        foreach ($bookings as $booking){
            $data[] = array(
                'date'=>$booking->created_at->diffForHumans(),
                'earning'=>($booking->total-(($booking->cut/100)*$booking->total))
            );
        }
        $user = User::whereId(auth()->id())->first();
        return response()->json(['balance'=>$user->balance,'summer'=>$data]);
    }
}
