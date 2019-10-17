<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SearchBarberRequest;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(SearchBarberRequest $request){
        $barber = User::whereHas('location',function($re) use ($request){
            $re->where('lat','>',($request->location['lat'] - (15*0.014)))
                ->where('lat','<',($request->location['lat'] + (15*0.014)))
                ->where('lng','>',($request->location['lng'] - (15*0.014)))
                ->where('lng','<',($request->location['lng'] + (15*0.014)));
        })->whereHas('services', function ($q) use ($request) {
            $q->where('service_id', $request->services);
        })->where('is_working',1)->with('location')->get();
        return Response($barber,200);
    }
}
