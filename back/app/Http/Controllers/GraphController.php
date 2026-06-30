<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use App\Traits\Graph;


class GraphController extends Controller
{
   use Graph;

   public function makegraph(Request $request){
      //create {merge} nodes from id  and attributes  unique

      
      $users = User::where('id', '<' ,35 )->get(); //temporary



     foreach($users as $user ){
         $this->AddPerson($user->id,$user->name,$user->points);
     }
     
      //create {merge} rels considering on left and right ids user by user
      foreach($users as $user ){
         if($user->right_user_id !== null && User::where('id',$user->right_user_id )->exists() )
            $this->addRel($user->id,$user->right_user_id,'RIGHT_CHILD');
         if($user->left_user_id !== null && User::where('id',$user->left_user_id )->exists() )
            $this->addRel($user->id,$user->left_user_id,'LEFT_CHILD');
      }
      

   }

   public function make_pass(Request $request){
      return Hash::make($request->pass);
   }
   public function add(Request $request ){
     return $this->AddPerson( $request->id,  $request->name );
   }
   public function addWP(Request $request ){
         $this->AddPersonWithRef( $request->id,  $request->name,3 , $request->parent_id);
   }


   public  function getWeight1r(Request $request)
   {
      $this->getWeightInLevelRight( $request->id  , $request->level);
   }
   public  function getWeight1l(Request $request)
   {
      $this->getWeightInLevelLeft( $request->id  , $request->level);
   }
   public  function getWeight2r(Request $request)
   {
      $this->getWeightTotalRight( $request->id);
   }
   public  function getWeight2l(Request $request)
   {
      $this->getWeightTotalLeft( $request->id);
   }



}
