<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function index(Request $request){

        $data=$request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name_guest' => 'required',
            'from_email' => 'required|email',
            'message' => 'required',
            'object_email' => 'required'
        ]);
         $newlead = new Lead();

         $newlead->fill($data);
         $newlead->save();
        
        return response()->json([
            'success' => true
        ]);
    }
}
