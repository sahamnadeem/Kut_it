<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\BookingLocation;
use App\Http\Requests\Api\SearchBarberRequest;
use App\Order;
use App\Service;
use App\Setting;
use App\User;
use App\UserLocation;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

    public function getlist(Request $request){
        $booking = Booking::where('booking_status_id',2)->where('user_id',auth()->user()->id)->first();
        if ($booking){
            $user['booking_id'] = $booking->id;
            $user = User::select('id','name','email','picture','phone_no')->with('location:id,user_id,lat,lng')->whereId($booking->barber_id)->first();
            $user['barber_rating']=4.5;
            return $user;
        }else{
            $barber = DB::table('requests')->where('user_id','=',auth()->id())->get();
            if ($barber->count()<1){
                // Collecting barber Using Location
                $barber = User::whereHas('location',function($re) use ($request){
                    $re->where('lat','>',($request->location['lat'] - (15*0.014)))
                        ->where('lat','<',($request->location['lat'] + (15*0.014)))
                        ->where('lng','>',($request->location['lng'] - (15*0.014)))
                        ->where('lng','<',($request->location['lng'] + (15*0.014)));
                })->whereHas('services', function ($q) use ($request) {
                    $q->whereIn('service_id', $request->services)
                        ->groupBy('user_id')
                        ->havingRaw('COUNT(DISTINCT service_id) = '.count($request->services));
                })->where('is_working',1)
                    ->where('barber_verified_at','!=',null)
                    ->where('status_id',1)
                    ->with(['location','request','services'])
                    ->get();
                auth()->user()->request_barber()->sync($barber);
                $barber = DB::table('requests')->where('user_id','=',auth()->id())->get();
                // dd($barber);
                if ($barber->count()>0){
                    auth()->user()->update(['requests'=> $barber->count()]);
                    $ans =  $this->request_barber($barber,$request);
                    if ($ans){
                        return \response()->json(['message'=>'please wait'], 200);
                    }else{
                        auth()->user()->update(['count' => 0,'requests'=>0]);
                        return \response()->json(['error'=>'No Barber Found'], 404);
                    }
                }else{
                    auth()->user()->update(['count' => 0,'requests'=>0]);
                    return \response()->json(['error'=>'No Barber Found'], 404);
                }

            }else{
                if ($barber->count()>0){
                    $ans = $this->request_barber($barber, $request);
                    if ($ans){
                        return \response()->json(['message'=>'please wait'], 200);
                    }else{
                        auth()->user()->update(['count' => 0,'requests'=>0]);
                        return \response()->json(['error'=>'No Barber Found'], 404);
                    }
                }else{
                    auth()->user()->update(['count' => 0,'requests'=>0]);
                    return \response()->json(['error'=>'No Barber Found'], 404);
                }
            }
        }
    }

    public function request_barber($barber, $services){
        $user = User::whereId($barber[0]->barber_id)->first();
        // dd((auth()->user()->count < auth()->user()->requests),auth()->user()->count == auth()->user()->requests && auth()->user()->count>0 && auth()->user()->requests>0);
        if ((auth()->user()->count <= auth()->user()->requests) && auth()->user()->requests>0) {
            if ($barber[0]->response_type === null){
                // dd('null be hy');
                // dd($user->last_action >= date('Y-m-d H:i:s', strtotime('-5 minutes')));
                if ($user->last_action >= date('Y-m-d H:i:s', strtotime('-5 minutes'))){
                    // dd('active be hy');
                    DB::table('requests')->where('id', '=', $barber[0]->id)->update(['response_type' => 'pending']);
                    foreach ($services->services as $serv){
                        DB::table('request_services')->insert(['request_id'=>$barber[0]->id,'service_id'=>$serv,'discount'=>0]);
                    }
                    DB::table('request_location')->insert(['request_id'=>$barber[0]->id,'lat'=>$services->location['lat'],'lng'=>$services->location['lng']]);
                    $barber = User::whereId($barber[0]->barber_id)->first();
                    $barber->update(['is_working'=>0]);
                    auth()->user()->update(['count' => auth()->user()->count+1]);
                    return true;
                }else{
                    $user->update(['is_working'=>1]);
                    DB::table('requests')->where('id','=',$barber[0]->id)->delete();
                    DB::table('request_services')->where('request_id','=',$barber[0]->id)->delete();
                    DB::table('request_location')->where('request_id','=',$barber[0]->id)->delete();
                    if(DB::table('requests')->where('user_id','=',$barber[0]->user_id)->get()->count()>0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                return true;
            }
        }else{
            auth()->user()->update(['count' => 0,'requests'=>0]);
            $user->update(['is_working'=>1]);
            DB::table('requests')->where('id','=',$barber[0]->id)->delete();
            DB::table('request_services')->where('request_id','=',$barber[0]->id)->delete();
            DB::table('request_location')->where('request_id','=',$barber[0]->id)->delete();
            return false;
        }
    }

    public function myrequest(){
        if (auth()->user()->is_barber==true){
            $booking = Booking::where('barber_id',auth()->id())->where('booking_status_id',2)->orwhere('booking_status_id',4)->orwhere('booking_status_id',5)->with('user:id,name,phone_no')->first();
            $request = DB::table('requests')->where('barber_id','=',auth()->id())->where('response_type','=','pending')->get();
            if ($booking && $booking->count()>0){
                $booking = $booking->load('location');
                $booking = $booking->load('details');
                return $booking;
            }elseif ($request && $request->count()>0){
                $customer = User::whereId($request[0]->user_id)->first();
                $request[0]->user_name = $customer->name;
                return $request;
            }else{
                return \response()->json(['message'=>'looking for requests'],200);
            }
        }else{
            $booking = Booking::where('user_id',auth()->id())->where('booking_status_id',2)->orwhere('booking_status_id',4)->orwhere('booking_status_id',5)->with('barber:id,name,phone_no')->first();
            $request = DB::table('requests')->where('user_id','=',auth()->id())->where('response_type','=','pending')->get();
            if ($booking && $booking->count()>0){
                $booking = $booking->load('location');
                $booking['barber_rating'] = 4.5;
                return $booking;
            }elseif ($request && $request->count()>0){
                return $request;
            }else{
                return \response()->json(['message'=>'looking for requests'],200);
            }
        }
    }

    public function accept($id){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        auth()->user()->update(['']);
        $l = DB::table('requests')->where('id','=',$id)->where('response_type','=','pending')->get();
        $m = DB::table('request_services')->where('request_id','=',$id)->get();
        $n = DB::table('request_location')->where('request_id','=',$id)->get();
        $ser = 0;
        if ($l->count()>0){
            $loc = UserLocation::where('user_id',$l[0]->barber_id)->first();
            foreach ($m as $service){
                $ser = $ser+Service::whereId($service->service_id)->first()->price;
            }
            $booking  = new Booking;
            $code = $booking->create([
                'uid'=>substr(str_shuffle($permitted_chars), 0, 8),
                'user_id'=>$l[0]->user_id,
                'barber_id'=>$l[0]->barber_id,
                'user_location'=>$loc->id,
                'total'=>$ser,
                'booking_status_id'=>2,
                'paid'=>0,
                'balance'=>0
            ]);
            foreach ($m as $service){
                $code->details()->attach($service->service_id);
            }
            $log = new BookingLocation;
            $code->location()->create([
                'lat'=>$n[0]->lat,
                'lng'=>$n[0]->lng,
            ]);
            $code = $code->load('location');
            $code = $code->load('details');
            DB::table('requests')->where('id','=',$id)->where('response_type','=','pending')->delete();
            DB::table('request_services')->where('request_id','=',$id)->delete();
            DB::table('request_location')->where('request_id','=',$id)->delete();
            auth()->user()->update(['is_working'=>0]);
            $cust = User::whereId($l[0]->user_id)->first();
            $cust->update(['count'=>0, 'requests'=>0]);
            return \response()->json($code,200);
        }else{
            return \response()->json(['error'=>'No booking to accept'],200);
        }
    }

    public function reject($id){
        //delete request
//        $request = DB::table('requests')->where('id','=',$request->id)->where('response_type','=','pending')->get();
        $r = DB::table('requests')->where('id','=',$id)->where('barber_id','=',auth()->id())->where('response_type','=','pending')->get();
        if ($r->count()>0){
            DB::table('requests')->where('id','=',$id)->where('response_type','=','pending')->delete();
            DB::table('request_services')->where('request_id','=',$id)->delete();
            DB::table('request_location')->where('request_id','=',$id)->delete();
            $user = User::whereId(auth()->id())->first();
            $user->update(['is_working'=>1]);
            return \response()->json(['message'=>'canceled successfully'],200);
        }else{
            return \response()->json(['error'=>'No booking to cancel'],200);
        }
    }

    public function update_state(Request $request){
        $commission = Setting::where('key','commission')->first();
        $booking  = Booking::whereId($request->booking_id)->first();
        $booking->update(['booking_status_id'=>$request->status_id,'cut'=>$commission]);
        if ($request->status_id === 1){
            auth()->user()->update(['is_working'=>1]);
            $wallet = ($booking->total-(($commission->value/100)*$booking->total));
            auth()->user()->deposit($wallet);
        }
        if ($request->status_id === 3){
            auth()->user()->update(['is_working'=>1]);
            $booking->update(['canceled_by'=>auth()->user()->id]);
        }
        return \response()->json(['messages'=>'status updated successfully'], 200);
    }
}
