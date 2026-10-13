<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',          // नया मोबाइल नंबर कॉलम चालू किया
        'role',           // नया रोल कॉलम (farmer, student, citizen) चालू किया
        'location',       // नया लोकेशन कॉलम चालू किया
        'profile_image',  // नया प्रोफाइल इमेज कॉलम चालू किया
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // यहाँ से 'password' => 'hashed' को हटा दिया है ताकि कंट्रोलर का Bcrypt (Hash::make) सीधे काम करे
    ];

    /**
     * लारावेल को बताने के लिए कि लॉगिन ईमेल से नहीं, बल्कि मोबाइल नंबर से होगा
     */
    public function username()
    {
        return 'phone';
    }
}