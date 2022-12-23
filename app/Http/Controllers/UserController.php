<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use File;
class UserController extends Controller
{
    public function index(){
        $records = User::all();
        return view('welcome',compact('records'));
    }

    public function upload_image(Request $request){
        $validator = Validator::make($request->all(), [

            'name' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status'=> 400,
                    'errors' => $validator->messages(),
                ]);
                // return redirect()->back()->withErrors($validator)->withInput();
            }

            $obj = new User();
            $obj->name = $request->name;

            if($request->hasFile('image')){
                $extension 	=	 $request->file('image')->getClientOriginalExtension();
                $fileName	=	time().'-user.'.$extension;

                $folderName     	= 	strtoupper(date('M'). date('Y'))."/";
                $destinationPath = 'public/images/';
                $folderPath			=	$destinationPath.$folderName;
                if(!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777,true);
                }
                if($request->file('image')->move($folderPath, $fileName)){
                    $obj->image	=	$folderName.$fileName;
                }
            }
            $obj->save();
            return response()->json([
                'status'=> 200,
                'message' => 'Image uploaded successfully',
            ]);
    }
}
