<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{


    /**
     * SHOW USER LOGIN FORM
     * 
     * 
     */
    public function login(Request $request)
    {
        return view('page_layout/login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $current_user = User::find($user->id);
            ##################################
            $c =  $current_user->generateCookies();
            ##################################
            $role = $user->role == 1 ? 'admin' : 'customer';
            // Redirect to the dashboard
            return redirect('/dashboard')->with('success', ucwords($role) . ' login successful!');
        } else {
            return back()->with('error', "Authentication failed");
        }
    }

    /**
     * SHOW USER REGISTRATION FORM
     * 
     * 
     */
    public function registerForm(Request $request)
    {
        return view('page_layout/register');
    }
    /**
     * STORE USER REGISTRATION DETAILS
     * 
     * 
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_role' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->user_role,
            ]);
            ##################################
            $c = $user->generateCookies();
            ##################################
            Log::info(" Account created successfully for {$request->email}");
            $role = $user->role == 1 ? 'admin' : 'customer';
            // Redirect to the dashboard
            return redirect('/dashboard')->with('success', ucwords($role) . ' registration successful!');
        } catch (Exception $e) {
            Log::error(" Account creation failed for {$request->email}");
            return back()->with('error', "Unable to register");
        }
    }
    /**
     * Refresh token
     */
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');

        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token not found'], 401);
        }

        try {
            // Refresh the token
            $newToken = JWTAuth::refresh($refreshToken);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }

        // Set new access token as cookie
        $accessCookie = cookie('access_token', $newToken, 60, '/', null, true, true, false, 'Strict');

        return response()->json(['message' => 'Token refreshed successfully'])
            ->withCookie($accessCookie);
    }

    public function logout()
    {
        Auth::logout();
        //Forget cookies
        Cookie::queue(Cookie::forget('jwt_token'));
        Cookie::queue(Cookie::forget('user_details'));
        Cookie::queue(Cookie::forget('refresh_token'));


        return redirect('/login');
    }
}
