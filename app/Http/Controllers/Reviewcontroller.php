<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class Reviewcontroller extends Controller
{
    public function GetAllReviews($id){
        try {
            $reviews = Review::with('user')->where('product_id',$id)->get();
            return response()->json(['reviews'=>$reviews]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>$th->getMessage()]);
        }
    }


    public function addreview(Request $request){
        try {
            $review = new Review();
            $review->rate=$request->rate;
            $review->title=$request->title;
            $review->content=$request->content;
            $review->user_id=$request->user()->id;
            $review->product_id=$request->product;
            $review->save();
            return response()->json(['status'=>"votre review est bien ajouter "]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>$th->getMessage()]);
        }
    }
}
