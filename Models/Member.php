<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'phone',
        'email',
        'address',
        'image1',
        'image2',
        'image3',
        'nickname',
    ];

    /**
     * ユーザーIDに紐づくメンバー情報を全件取得
     *
     * @param  int  $userId  ユーザーID
     * @return Collection<int, Member>
     */
    public function getAllMemberByUserId(int $userId): Collection
    {
        return $this->where('user_id', $userId)->get();
    }

    /**
     *
     */
    public function storeMember(Request $data): Member
    {
        // ログインユーザー(ジム)のIDを取得
        $userId = Auth::id();
        // ログインユーザー(ジム)のIDをメンバー情報に紐づける
        $data['user_id'] = $userId;

        // ファイルがアップロードされているか確認 TODO:Requestクラスに移動
        if (!$data->hasFile('file1') || !$data->hasFile('file2') || !$data->hasFile('file3')) {
            throw new \Exception("必須データがありません", 1);
        }

        // 画像ファイルを取得
        $file1 = $data->file('file1');
        $file2 = $data->file('file2');
        $file3 = $data->file('file3');

        // 型チェック TODO:Requestクラスに移動
        if (
            !$file1 instanceof UploadedFile ||
            !$file2 instanceof UploadedFile ||
            !$file3 instanceof UploadedFile
        ) {
            throw new \Exception("ファイルアップロードに問題があります");
        }

        // ファイル名をハッシュ化
        $file1Name = $file1->hashName();
        $file2Name = $file2->hashName();
        $file3Name = $file3->hashName();

        // 画像ファイルを保存
        Storage::disk('s3')->putFileAs('member', $file1, $file1Name);
        Storage::disk('s3')->putFileAs('member', $file2, $file2Name);
        Storage::disk('s3')->putFileAs('member', $file3, $file3Name);

        // 保存用にArrayに変換
        $data = $data->all();

        // 画像ファイルのパスをデータベースに保存
        $data['file1'] = $file1Name;
        $data['file2'] = $file2Name;
        $data['file3'] = $file3Name;

        // DBにメンバー情報を登録
        return $this->create($data);
    }
}
