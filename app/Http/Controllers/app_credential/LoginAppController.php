<?php

namespace App\Http\Controllers\app_credential;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
class LoginAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function LoginAppController(Request $request)
    {   try{
            $user = User::where('email', $request->email)->first();
            if(!empty($user)){
                if(Hash::check($request->password, $user->password)){
               
                    return response()->json(['status' =>  'S', 'username' =>  $user->email,'nama_user' => $user->name ,'hak_akses' => $user->login_as ,'keterangan' => '']);     
                }
                else{
                    return response()->json(['status' => 'E', 'username' =>$request->email,'hak_akses' => 'null', 'keterangan' => 'username tidak terdaftar']);  
                }
            }else{
                return response()->json(['status' => 'E', 'username' =>$request->email,'hak_akses' => 'null', 'keterangan' => 'username tidak terdaftar']);  
            }
        
        }catch(Exception $e){
            return response()->json(['status' => 'E', 'username' =>'null','hak_akses' => 'null' ,'keterangan' => $e->getMessage()]);  
        }

       
    }

    //
}
