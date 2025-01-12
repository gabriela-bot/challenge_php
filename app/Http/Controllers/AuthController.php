<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(AuthRequest $request)
    {
        try {

            $credentials = $request->only(['email', 'password']);

            if(Auth::attempt($credentials)){
                return response()->json([
                    'token'=>$request->user()->createToken('prex')->accessToken
                ],200);
            } else {
                throw new AuthenticationException('login_failed');
            }
        } catch (Exception $exception){
            return  response()->json(
                [
                    'message' => $exception->getMessage()
                ],
                404
            );
        }
    }
}
