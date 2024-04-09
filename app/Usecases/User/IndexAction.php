<?php

namespace App\Usecases\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

final class IndexAction
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * ユーザー一覧を取得
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        // ログイン中のアカウントIDを取得
        $account_id = (int) auth()->id();

        // ユーザー一覧を取得
        $users = $this->user->getUsers($account_id);

        return response()->json($users);
    }
}
