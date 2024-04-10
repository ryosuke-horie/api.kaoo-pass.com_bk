<?php

namespace App\Usecases\Stripe;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class CreateProductAction
{
    private StripeClient $stripe;

    public function __construct()
    {
        // Stripeクライアントの初期化
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
    }

    public function __invoke(Request $request): JsonResponse
    {
        // 商品情報
        $productData = [
            // 顧客に表示される商品名
            'name' => $request->name,
            // 顧客に表示される商品説明。
            'description' => $request->description,
        ];

        // 商品を作成
        $createResult = $this->stripe->products->create($productData);

        // stripe_product_idを取得
        $stripeProductId = $createResult->id;

        // DBに商品情報を保存
        $product = new Product();
        $product->createProduct($request, (string) auth()->id(), $stripeProductId);

        // 商品情報を返す
        return response()->json(['product' => $product], 200);
    }
}
