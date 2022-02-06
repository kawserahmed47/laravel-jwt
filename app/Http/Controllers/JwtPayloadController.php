<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class JwtPayloadController extends Controller
{
    public function getJwtPayload(){

        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        $data['user'] = User::find($apy['sub']);

        return view('admin.jwt_payload', $data);
    }
}
