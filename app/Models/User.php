<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'google_access_token_expires' => 'datetime'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'refresh_token'
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function token()
    {
        if(now() > $this->google_access_token_expires) {
            $response = Http::post('https://www.googleapis.com/oauth2/v4/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->google_refresh_token,
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET')
            ])->json();

            $this->google_access_token = $response['access_token'];
            $this->google_access_token_expires = now()->addSeconds($response['expires_in'])->subSeconds(10);
            $this->save();
        }

        return $this->google_access_token;
    }
}
