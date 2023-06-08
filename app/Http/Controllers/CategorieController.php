<?php

namespace App\Http\Controllers;

use App\Models\Spect;
use App\Models\Categorie;
use App\Models\Spectitem;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function AjouterCategorieSpect(Request $request){
        $c=Categorie::where('name',$request->categorie)->first();
            $categorie=Categorie::firstOrCreate(['name'=>$request->categorie],['name'=>$request->categorie,'categorie_id'=>$request->parentCategorie]);
            foreach (json_decode($request->spects) as $e){
                $spect=Spect::firstOrCreate(['spect'=>$e->name],['spect'=>$e->name,'categorie_id'=>$categorie->id]);
                $options=explode(',',$e->options);
                foreach($options as $option){
                    $spectItem=Spectitem::firstOrCreate(['value'=>$option],['value'=>$option,'spect_id'=>$spect->id]);
                }
            }
            if($c){
                return response()->json(['status'=>'categorie already exists']);
            }
            return  response()->json(['status'=>"categorie  $categorie->name  bien cree"]);
    }

    public function ModifierCategorie(Request $request){

            $parent=$request->parentCategorie==='null'?null:$request->parentCategorie;
            $categorie = Categorie::find($request->id);
            $categorie->name=$request->categorie;
            $categorie->categorie_id=$parent;
            $spects=explode(',',$request->spects);
            $deleted=explode(',',$request->deleted);
            if($spects[0]!='undefined'){
                foreach($spects as $spect){
                    Spect::create(['spect'=>$spect,'categorie_id'=>$request->id]);
                }
            }
            if($deleted[0]!=''){
                foreach($deleted as $delet){
                $spect =Spect::where('id',$delet)->first();
                 $spect->delete();

            }
            }
            $categorie->save();
            return response()->json(['status'=>"categorie $categorie->name bien modifier"]);
    }

    public function DeleteCategorie($id){
        $categorie=Categorie::find($id);
        $categorie->delete();
        return response()->json(['status'=>"categorie $categorie->name  bien supprimer"]);
    }
}
