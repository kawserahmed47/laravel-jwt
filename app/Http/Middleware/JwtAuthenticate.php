<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth; //use this library

class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $message = "token_expired";
        
            return redirect()->route('invalidToken', $message);
            // return response()->json(['token_expired'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
            $message = "token_invalid";
        
            return redirect()->route('invalidToken', $message);
            // return response()->json(['token_invalid'], 500);
    
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    
            $message = "token_absent";
            return redirect()->route('invalidToken', $message);
            // return response()->json(['token_absent' => $e->getMessage()], 500);
    
        }
    }
}
