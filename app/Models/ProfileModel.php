<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileModel extends Model
{
    use HasFactory;

    protected $table = 'm_profile';
    protected $primaryKey = 'profile_id';
    protected $fillable = ['user_id', 'profile_email', 'profile_telepon', 'profile_alamat', 'profile_foto_url'];

    public function user(): HasOne{
        return $this->hasOne(UserModel :: class, 'user_id', 'user_id');
    }
}
