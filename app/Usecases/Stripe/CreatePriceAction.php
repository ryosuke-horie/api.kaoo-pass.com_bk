<?php

namespace App\Usecases\Stripe;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class CreatePriceAction
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
        $priceData = [
            // 価格を設定する商品ID
            'product' => $request->input('stripe_product_id'),
            // 価格を設定する通貨
            'currency' => 'jpy',
            // 課金方式 サブスクリプション
            'billing_scheme' => 'per_unit',
            // 課金周期
            'recurring' => ['interval' => 'month'],
            // 価格
            'unit_amount' => $request->input('price'),
        ];

        // 商品価格を作成
        $createResult = $this->stripe->prices->create($priceData);
        // stripe_price_idを取得
        $stripePriceId = $createResult->id ?? null;

        if ($stripePriceId === null) {
            return response()->json(['error' => 'Price not created'], 500);
        }
        // DBから商品情報を取得
        $product = Product::where('stripe_product_id', $request->input('stripe_product_id'))->first();

        if ($product) {
            // DBに価格情報を保存
            $product->updatePrice($request, $stripePriceId);
        } else {
            // 商品が見つからない場合の処理
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['success' => 'Price created'], 200);
    }
}
