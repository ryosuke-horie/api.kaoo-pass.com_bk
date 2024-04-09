<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Usecases\User\IndexAction;
use App\Usecases\User\StoreAction;
use App\Usecases\User\UnsubscribeAction;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private IndexAction $indexAction;

    private StoreAction $storeAction;

    private UnsubscribeAction $unsubscribeAction;

    public function __construct()
    {
        $this->indexAction = new IndexAction();
        $this->storeAction = new StoreAction();
        $this->unsubscribeAction = new UnsubscribeAction();
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
        // unsubscribeActionを呼び出し
        return ($this->unsubscribeAction)($userId);
    }
}
