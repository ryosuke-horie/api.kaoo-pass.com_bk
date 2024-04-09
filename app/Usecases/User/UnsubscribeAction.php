<?php

namespace App\Usecases\User;

use App\Models\User;

class UnsubscribeAction
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function __invoke(int $userId)
    {
        // unsubscribeメソッドを呼び出し
        $this->user->unsubscribe($userId);

        // ステータスコード200でレスポンスを返却
        return response()->json([], 200);
    }
}
