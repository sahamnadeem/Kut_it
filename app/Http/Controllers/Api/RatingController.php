<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Rating;
use App\Review;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function barberRating(){
        $rating = User::with(['barber_reviews'=>function($q){
            $q->limit(5);
        }])->whereId(auth()->user()->id)->first();
        if ($rating->barber_reviews != null){
            $rating['total'] = $rating->barber_rating()->avg('rating');
            $rating['ratings_count'] = $rating->barber_rating()->count('rating');
            $rating['reviews_count'] = $rating->barber_reviews()->count('review');
            return Response($rating,200);
        }else{
            return Response(['message'=>'You have no ratings yet!!'],404);
        }
    }
    public function clientrating(Request $request){
        $rating  = new Rating;
        $rev = new Review;
        $rating = $rating->create([
            'rating'=>$request->rating,
            'booking_id'=>$request->booking_id,
            'user_id'=>auth()->user()->id,
            'edited'=> 0
        ]);
        $rev->create([
            'rating_id'=>$rating->id,
            'booking_id'=>$request->booking_id,
            'review'=>$request->review,
            'user_id'=>auth()->user()->id,
            'edited'=>0
        ]);
        return response()->json(['message'=>'Rating & Review add successfully']);
    }
}
