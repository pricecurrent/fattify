<?php

namespace App\Models;

use App\Diary\Diary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * Don't protect against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function nutritionDiaryEntries()
    {
        return $this->hasMany(NutritionDiaryEntry::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function openDiaryOnDate(Carbon $date)
    {
        return resolve(Diary::class)->forUser($this)->onDate($date);
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return Storage::disk('avatars')->url($this->avatar);
        }

        return url('apple-icon-180.png');
    }
}
