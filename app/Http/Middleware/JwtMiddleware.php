<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {


            //Check for bearer token-access token
            $token = $request->bearerToken();
            //If jwt token
            if (!$token) {
                $token = Cookie::get('jwt_token');
            }

            $user = JWTAuth::setToken($token)->authenticate();
            Auth::setUser($user);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Token is expired
            $refreshToken = $request->cookie('refresh_token');
            // Access Token
            $refreshToken = $request->cookie('refresh_token');
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();
            Cookie::queue('jwt_token', $token, Null, '/');
        } catch (Exception $e) {
            // Handle token errors (e.g., expired, invalid, etc.)
            return redirect('/login')->with('error', 'Unauthorized or invalid token.');
        }

        return $next($request);
    }
}
