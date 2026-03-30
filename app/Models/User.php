<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UUID;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, UUID, SoftDeletes;

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
    public function headOfFamily()
    {
        return $this->hasOne(HeadOfFamily::class);
    }
           public function familyMember()
    {
        return $this->hasMany(FamilyMember::class);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('name','like', '%'. $search. '%')
        ->orWhere('email','like','%'. $search . '%');
    }
    public function developmentApplicants()
    {
    return $this->hasMany(DevelopmentApplicant::class);
    }


}
