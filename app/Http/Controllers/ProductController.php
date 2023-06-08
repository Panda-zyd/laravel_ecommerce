<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use App\Models\Spectitem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function __construct(){

    }


    public function AjouterProduit(Request $request){
        $user = $request->user()->id;
        $categorie=Categorie::where('name',$request->categorie)->first('id');
        $spects= explode(',',$request->spects);
        $listSpects=[];
        foreach($spects as $spect){
            $spectItemId=Spectitem::where('value',$spect)->first('id');
            $listSpects[]=$spectItemId->id;
        }
        $product = new Product();
        $product->name=$request->name;
        $product->description=$request->description;
        $product->stock=$request->stock;
        $product->price=$request->price;
        $product->categorie_id = $categorie->id;
        $product->user_id = $user;
        $product->save();
        $product->productspectitems()->attach($listSpects);
        foreach($request->file('images') as $img){
            $file=Str::random(11).'.'.$img->getClientOriginalExtension();
            $img->storeAs('/images',$file,'public');
            $product->images()->create(['url'=>$file]);
         }
         return response()->json(['status'=>'product bien cree']);
    }

    public function EditProduct($id){
        $product=Product::find($id);
        if(request()->filled('name')){
            $product->name=request()->name;
        }

        if(request()->filled('description')){
            $product->description=request()->description;
        }

        if(request()->filled('stock')){
            $product->stock=request()->stock;
        }

        if(request()->has('images')){
            foreach(request()->file('images') as $img){
                $file=Str::random(11).'.'.$img->getClientOriginalExtension();
                $img->storeAs('/images',$file,'public');
                $product->images()->create(['url'=>$file]);
             }
        }
        $product->save();
        return response()->json(['status'=>'Product bien edité']);
    }

    public function DeleteProduct( Product $product){
            $product->delete();
            return response()->json(['status'=>'Product Deleted']);
    }

    public function setMain(Request $request,$id){
        $product = DB::select('select * from mainproducts');
        if($product){
            $product=DB::insert('update mainproducts set product_id=?',[$id]);
        }
        else{
            $product=DB::update('insert into mainproducts(product_id) VALUES(?)',[$id]);
        }
        return response()->json(['status'=>"produit main changed "]);
    }
}
