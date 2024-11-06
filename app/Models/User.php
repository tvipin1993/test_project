<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /////////////////////////////////////////////
    ///// JWT Authentication         ////////////
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    ##########################################################
    ################# Generate Cookies #######################
    public function generateCookies()
    {
        try {
            $user = $this;

            // Generate a JWT token
            $token = JWTAuth::fromUser($user);

            // Store token and user details in a cookie
            $cookieOptions = [
                'expires' => env('REFRESH_TOKEN_COOKIE_EXPIRY_HOURS') * 60,
                'path' => '/', //entire site
                'domain' => null,
                'secure' => env('COOKIE_SECURE'),
                'httponly' => true,
                'samesite' => 'Strict',
            ];
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role
            ];

            // Set cookies
            // Access Token
            Cookie::queue('jwt_token', $token, Null, '/');
            //Generate refresh token 
            $refreshToken = JWTAuth::claims(['is_refresh_token' => true])->fromUser($user);
            Cookie::queue('refresh_token', $refreshToken, $cookieOptions['expires'], '/');
            // Store user ID or details (if necessary) in a cookie
            Cookie::queue('user_details', json_encode($userData), $cookieOptions['expires'], $cookieOptions['path']);
            Log::info('cookies created for user ' . $this->id);
            return true;
        } catch (Exception $e) {
            Log::info('cookies creation failed ' . $this->id);
            return false;
        }
    }

    ################# Generate Cookies ends #################
    #########################################################
}
