<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Models\User;
use App\Usecases\User\IndexAction;
use App\Usecases\User\StoreAction;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private User $user;

    private IndexAction $indexAction;

    private StoreAction $storeAction;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->indexAction = new IndexAction();
        $this->storeAction = new StoreAction();
    }

    /**
     * ユーザー一覧を取得
     */
    public function index(): JsonResponse
    {
        // indexActionを呼び出し
        return ($this->indexAction)();
    }

    /**
     * ユーザーを登録
     */
    public function store(UserPostRequest $request): JsonResponse
    {
        // バリデーション済みデータの取得
        $user = $request->validated();

        // storeActionを呼び出し
        return ($this->storeAction)($user);
    }

    /**
     * ユーザーを退会
     */
    public function unsubscribe(int $userId): JsonResponse
    {
        // unsubscribeメソッドを呼び出し
        $this->user->unsubscribe($userId);

        // ステータスコード200でレスポンスを返却
        return response()->json([], 200);
    }
}
