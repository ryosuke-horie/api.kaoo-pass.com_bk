<?php

namespace App\Usecases\Stripe;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListProductAction
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        // account_idを取得
        $accountId = (string) auth()->id();

        // アカウントに設定されているstripe_account_idをもとにStirpeに作成済みの商品を取得
        // DBから取得しないと、他のアカウントの商品情報を取得してしまう可能性がある
        $products = Product::where('account_id', $accountId)->get();

        // 商品情報を返す
        return response()->json(['products' => $products], 200);
    }
}
