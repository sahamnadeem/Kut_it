<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BarberController extends Controller
{
    public function services(ServiceRequest $request){
        if (auth()->user()->barber_verified_at != null){
            foreach ($request->barber_services as $service) {
                Service::create($service);
            }
            auth()->user()->services()->syncWithoutDetaching($request->services);
            return Response(['message'=>'Requested to add services, Please Wait!!'], 200);
        }else{
            return Response(['message'=>'Requested can not be forwarded!'], 501);
        }
    }

    public function request(Request $request){
        $request->validate([
           'address' => 'required',
           'ss_number' => 'required',
        ]);
        $user = User::whereId(auth()->user()->id)->first();
        if(!$user->is_barber){
            $user->update([
                'is_barber'=>true
            ]);
        }
        return Response(['message'=>'Barber requested successfully'],200);
    }
    
    public function allservices(){
        $services = Service::paginate(10);
        return response()->json($services);
    }
    public function myservices(){
        $services = User::where('is_barber',true)->where('barber_verified_at','!=',null)->whereId(auth()->user()->id)->first();
        return $services->services()->get();
    }
}
