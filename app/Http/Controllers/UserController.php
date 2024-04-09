<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Models\User;
use App\Usecases\User\IndexAction;
use App\Usecases\User\StoreAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        // ログイン中のアカウントIDを取得
        $account_id = (int) auth()->id();

        // ファイル名の生成：ファイル名_uuid.拡張子
        $avatarImageName = $user['avatar_image']->getClientOriginalName().uniqid().'.'.$user['avatar_image']->extension();
        $image2Name = $user['image2']->getClientOriginalName().uniqid().'.'.$user['image2']->extension();
        $image3Name = $user['image3']->getClientOriginalName().uniqid().'.'.$user['image3']->extension();

        // ユーザー情報を登録
        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'account_id' => $account_id,
            'address' => $user['address'],
            'phone' => $user['phone'],
            'age' => $user['age'],
            'avatar_image' => $avatarImageName,
            'image2' => $image2Name,
            'image3' => $image3Name,
        ]);

        // S3に画像を保存
        try {
            Storage::disk('s3')->putFileAs('images', $user['avatar_image'], $avatarImageName);
            Storage::disk('s3')->putFileAs('images', $user['image2'], $image2Name);
            Storage::disk('s3')->putFileAs('images', $user['image3'], $image3Name);
            Log::info('Images uploaded successfully');
        } catch (\League\Flysystem\UnableToWriteFile $exception) {
            Log::error('S3 upload error: '.$exception->getMessage());

            return response()->json(['error' => 'File upload failed'], 500);
        }

        // ステータスコード200でレスポンスを返却
        return response()->json([], 200);
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
