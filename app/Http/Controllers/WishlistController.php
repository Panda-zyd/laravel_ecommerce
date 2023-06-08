<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function getAllWishList(Request $request){
         $data = Wishlist::with('product.images')->where('user_id',$request->user()->id)->get();
         return response()->json(['wishlists'=>$data]);
    }

    public function toogle(Request $request){
        $wishlist = Wishlist::where('product_id',$request->id)->first();
        if($wishlist){
            $wishlist->delete();
        }
        else{
            Wishlist::create(['product_id'=>$request->id,'user_id'=>$request->user()->id]);
        }
        return response()->json(['status'=>'wishlist toogled']);
    }
}
