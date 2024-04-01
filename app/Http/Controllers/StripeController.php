<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private StripeClient $stripe;

    public function __construct()
    {
        // Stripeクライアントの初期化
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
    }

    /**
     * Stripeアカウントを作成
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // 認証中のアカウントを取得
        $account = $request->user();

        // アカウントが存在しない場合はエラーレスポンスを返す
        if (! $account) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (config('stripe.stripe_secret_key') === null) {
            return response()->json(['error' => 'Stripe secret key is not set'], 500);
        }

        // Stripeのアカウント作成
        $stripeAccount = $this->stripe->accounts->create([
            'country' => 'JP',
            'type' => 'express',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            // sports_clubs_fields(スポーツクラブ、運動場)としての利用を想定
            'business_profile' => [
                'mcc' => '7941',
            ],
        ]);

        // StripeのアカウントIDを取得
        $stripeAccountId = $stripeAccount->id ?? null;

        // アカウント情報を更新
        $account->stripe_account_id = $stripeAccountId;
        $account->save();

        // オンボーディングフローのリダイレクトURLを取得
        $onboardingUrl = $this->stripe->accountLinks->create([
            'account' => $stripeAccountId,
            'refresh_url' => 'https://kaoo-pass.com',
            'return_url' => 'https://kaoo-pass.com/dashboard',
            'type' => 'account_onboarding',
        ])->url;

        // オンボーディングフローのリダイレクトURLを返す
        return response()->json(['onboarding_url' => $onboardingUrl], 200);
    }

    /**
     * 商品作成
     */
    public function createProduct(Request $request): JsonResponse
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

        return response()->json(['success' => 'Product created'], 200);
    }

    /**
     * 商品一覧
     */
    public function listProducts(Request $request): JsonResponse
    {
        // account_idを取得
        $accountId = (string) auth()->id();

        // アカウントに設定されているstripe_account_idをもとにStirpeに作成済みの商品を取得
        // DBから取得しないと、他のアカウントの商品情報を取得してしまう可能性がある
        $products = Product::where('account_id', $accountId)->get();

        return response()->json(['products' => $products], 200);
    }

    /**
     * 商品価格設定
     */
    public function createPrice(Request $request): JsonResponse
    {
        // 商品情報
        $priceData = [
            // 価格を設定する商品ID
            'product' => $request->input('stripe_product_id'),
            // 価格を設定する通貨
            'currency' => 'jpy',
            // 価格
            'unit_amount' => $request->input('price'),
        ];

        // 商品価格を作成
        $createResult = $this->stripe->prices->create($priceData);

        return response()->json(['success' => 'Price created'], 200);
    }
}
