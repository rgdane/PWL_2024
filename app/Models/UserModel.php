<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['level_id',  'username', 'nama', 'password','created_at','updated_at','image'];

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis dihash
    
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string{
        return $this->level->level_nama;
    }
    
    public function hasRole($role): bool{
        return $this->level->level_kode == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }

    public function profile()
    {
        return $this->hasOne(ProfileModel::class);
    }

    public function penjualan() : HasMany {
        return $this->hasMany(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/storage/posts/' .$image),
        );
    }
}
