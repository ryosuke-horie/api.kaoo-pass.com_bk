<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * ユーザー一覧を取得
     */
    public function index(): JsonResponse
    {
        // ログイン中のアカウントIDを取得
        $account_id = auth()->id();
        // ログイン中のアカウントに紐づくユーザー一覧を取得
        $users = User::where('account_id', $account_id)->get();

        // アバター画像のURLを設定
        $users->each(function ($user) {
            if ($user->avatar_image) {
                $user->avatar_image = Storage::disk('s3')->url($user->avatar_image);
            }
        });

        return response()->json($users);
    }

    /**
     * ユーザーを登録
     */
    public function store(UserPostRequest $request): JsonResponse
    {
        // ログイン中のアカウントIDを取得
        $account_id = (int) auth()->id();

        // バリデーション済みデータの取得
        $user = $request->validated();

        // ファイルデータの型チェック
        if (
            ! $user['avatar_image'] instanceof UploadedFile ||
            ! $user['image2'] instanceof UploadedFile ||
            ! $user['image3'] instanceof UploadedFile
        ) {
            return response()->json(['error' => 'Invalid file data'], 400);
        }

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
}
