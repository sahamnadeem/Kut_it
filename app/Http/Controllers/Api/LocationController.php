<?php

namespace App\Http\Controllers\Api;

use App\UserLocation;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index(Request $request){
        if ($location = UserLocation::where('user_id',auth()->user()->id)->first()){
            $location->update([
                'lat'=>$request->lat,
                'lng'=>$request->lng,
                'user_id'=>auth()->user()->id
            ]);
        }else{
            $location = new UserLocation;
            $location->create([
                'lat'=>$request->lat,
                'lng'=>$request->lng,
                'user_id'=>auth()->user()->id
            ]);
        }
        auth()->user()->update(['last_action'=>now()]);
        return Response(['status'=>'Location Updated Successfully'], 200);
    }
}
