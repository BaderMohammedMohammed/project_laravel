<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json(['msg'=>'عذرا هذا الايميل غير صحيح'], 401);
        }

        if(Hash::check($request->password , $user->password )){
            $token = $user->createToken("token")->accessToken;
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }else{
            $response=['msg'=>'عذرا كلمة المرور خطأ'];
            return response($response,422);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,
            [
                'name' => 'required|max:10',
                'email' => 'required|unique:users',
                'password' => 'required',
                'conf_password'=>'required|same:password',
            ],
            [],
            [
                'name' => 'الاسم',
                'email'=> 'البريد الالكتروني',
                'password'=> 'كلمة المرور' ,
                'conf_password'=>'تاكيد كلمة المرور'
            ],
        );

        if ($validator->fails()){
            $msg = "تاكد من البيانات المدخلة";
            $data=$validator->errors();
            return response()->json(compact('msg' , 'data') , 422);

            // 422 validation error
        }
//        dd($request->all());
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        // Hash تشفير كلمة المرور
        $user->save();
        return response()->json(['msg'=>'تمت العملية بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
