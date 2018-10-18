<?php
/**
 * Created by PhpStorm.
 * User: Johnson
 * Date: 2018-10-16
 * Time: 22:50
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class PassportController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['code'=>true,'msg' => '登录成功','data'=> $success], $this->successStatus);
        }
        else{
            return response()->json(['code'=>false,'msg' => '登录失败,账号或密码错误！'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|unique:users|numeric',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->first('mobile') == 'The mobile has already been taken.'){
                return response()->json(['code'=>false,'msg' => '该手机号已经注册'], 401);
            }else{
                return response()->json(['code'=>false, 'msg'=>$validator->errors()], 401);
            }
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['code'=>true,'msg' => '注册成功','data'=>$success], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {

        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function info()
    {

        return response()->json(['success' => 'dsaf'], $this->successStatus);
    }
}