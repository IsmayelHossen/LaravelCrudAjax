<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AjaxController extends Controller
{
    public function getIndex(){
        return view('Ajaxcrud');
    }
    public function getData(){
       $data=DB::table('contacts')->get();
        return response()->json($data,200); 
    }

    public function postStore(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:11|max:11|unique:contacts',
            'email'=>'required'
        ]);
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $storeresult=DB::table('contacts')->insert($data);
      //  return response()->back()->with('save','save data');
      return ['success'=>true,'message'=>'Inserted Successfully'];

    }
    public function postUpdate(Request $request){
        $id=$request->id;
        $data=array();
        $data['name']=$request->name;
        $data['phone']=$request->phone;
        $data['email']=$request->email;
        $update=DB::table('contacts')->where('id',$id)->update($data);
        return ['success'=>true,'message'=>'Inserted Successfully'];

    }
    public function postDelete(Request $request){
        $id=$request->id;
        $delete=DB::table('contacts')->where('id',$id)->delete();
        return ['success'=>true]; 
    }
}
