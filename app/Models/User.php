<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'address',
        'phone',
        'age',
        'avatar_image',
        'image2',
        'image3',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Accountモデルとのリレーションを定義
     * 多対1の関係
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Account, \App\Models\User>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
