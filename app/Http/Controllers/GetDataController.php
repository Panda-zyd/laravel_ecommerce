<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDataController extends Controller
{
    public function getCategories(){
        $categories=Categorie::with('spects.spectsItems','products.images')->get();
        return response()->json(['categories'=>$categories]);
    }

    public function getSpects($id){
        $spects=Categorie::where('name',$id)->first();
        $spects=$spects->with('spects.spectsItems')->where('name',$id)->first();
        return response()->json(['spects'=>$spects]);
    }

    public function getAllproducts(){
        $allProducts=Product::with('images')->get();
        return response()->json(['products'=>$allProducts]);
    }

    public function getProduct($id){
        $product=Product::with(['productspectitems','categorie','images'])->where('id',$id)->first();
        return response()->json(['product'=>$product]);
    }

    public function getAdmins(){
        return response()->json(['admins'=>User::where('admin',true)->get()]);
    }

    public function getMain(){
       $id = DB::select('select product_id from mainproducts limit 1');
       if(count($id)>0){
        $id=$id[0]->product_id;
        $Product=Product::with('images')->where('id',$id)->first();
        return response()->json(['main'=>$Product]);
       }
       return response()->json(['main'=>'no main product']);

    }


    public function newArrivals(){
        $products = Product::with('images')->where('created_at', '>=', Carbon::today()->startOfMonth()->subMonth())->get();
        return response()->json(['newArrivals'=>$products]);
    }

    public function productsSpects(Request $request){
            $categories;
            if(count(json_decode($request->array))>0){
                $categories = Product::query()->with(['productspectitems','images'])->where('categorie_id',$request->id)->whereHas('productspectitems',function($query) use ($request) {
                    $query->whereIn('spectitem_id',json_decode($request->array));
                })->get();
            }
            else{
                $categories = Product::query()->with(['productspectitems','images'])->where('categorie_id',$request->id)->get();
            }

            return  response()->json(['products'=>$categories]);
    }


}
