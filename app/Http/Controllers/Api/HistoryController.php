<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;

class HistoryController extends Controller
{
    public function barberHistory(){
        if (auth()->user()->barber_verified_at != null){
            $history = Booking::with('details')->where('barber_id',auth()->user()->id)->orderBy('created_at')->paginate(10);
            return Response($history, 200);
        }else{
            return Response(['message'=>'You are not barber!'], 200);
        }
    }
    public function clientHistory(){
        $history = Booking::with('details')->where('user_id',auth()->user()->id)->orderBy('created_at')->paginate(10);
        return Response($history, 200);
    }
}
