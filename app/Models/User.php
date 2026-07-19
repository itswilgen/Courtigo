<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'student_id',
        'password',
        'role',
        'phone',
        'status',
        'is_banned',
    ];

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
            'is_banned' => 'boolean',
        ];
    }

    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class, 'owner_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function followedCourts()
    {
        return $this->belongsToMany(Court::class, 'follows', 'user_id', 'court_id')->withTimestamps();
    }

    public function isFollowing(Court $court): bool
    {
        return $this->followedCourts()->where('court_id', $court->id)->exists();
    }

    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }
}
