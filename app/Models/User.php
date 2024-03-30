<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        'is_unsubscribed', // 退会フラグ
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_unsubscribed' => 'boolean',
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

    /**
     * 会員一覧を取得
     * 退会済みのユーザーは除外
     *
     * @return array<int, array<string, mixed>>
     */
    public function getUsers(int $accountId): array
    {
        // ログイン中のアカウントに紐づく、かつ退会済みでないユーザー一覧を取得
        $users = User::where('account_id', $accountId)
            ->where('is_unsubscribed', false)
            ->get();

        // アバター画像のURLを設定
        $users->each(function ($user) {
            if ($user->avatar_image) {
                $user->avatar_image = Storage::disk('s3')->url($user->avatar_image);
            }
        });

        return $users->map(function ($user) {
            return $user->toArray();
        })->all();
    }

    /**
     * 退会フラグを立てる
     *
     * @throws \Exception
     */
    public function unsubscribe(int $userId): void
    {
        // ログイン中のアカウントIDを取得
        $account_id = auth()->id();

        // ユーザーを特定
        $user = User::find($userId);

        // ユーザーが存在しない場合は処理を中断
        if (! $user) {
            Log::error('存在しないユーザーに退会処理が実行されました');
            throw new Exception('Error Processing Request', 1);
        }

        // ログイン中のアカウントIDとユーザーのアカウントIDが一致しない場合は処理を中断
        if ($account_id !== $user->account_id) {
            Log::error('他のアカウントのユーザーに退会処理が実行されました');
            throw new Exception('Error Processing Request', 1);
        }

        // 退会フラグを立てる
        $user->is_unsubscribed = true;
        $result = $user->save();
        if (! $result) {
            throw new \Exception('Failed to save user.');
        }
        $user->refresh(); // データベースから再取得
        Log::info('退会処理が完了しました。user: '.json_encode($user->toArray()));
    }
}
