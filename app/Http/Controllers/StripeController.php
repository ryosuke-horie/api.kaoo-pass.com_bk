<?php

namespace App\Http\Controllers;

use App\Usecases\Stripe\CreateAccountAction;
use App\Usecases\Stripe\CreatePriceAction;
use App\Usecases\Stripe\CreateProductAction;
use App\Usecases\Stripe\ListProductAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private StripeClient $stripe;

    private CreateAccountAction $createAccountAction;

    private CreateProductAction $createProductAction;

    private ListProductAction $listProductAction;

    private CreatePriceAction $createPriceAction;

    public function __construct()
    {
        // Stripeクライアントの初期化
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
        $this->createAccountAction = new CreateAccountAction();
        $this->createProductAction = new CreateProductAction();
        $this->listProductAction = new ListProductAction();
        $this->createPriceAction = new CreatePriceAction();
    }

    /**
     * Stripeアカウントを作成
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return $this->createAccountAction->__invoke($request);
    }

    /**
     * 商品作成
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createProduct(Request $request): JsonResponse
    {
        return $this->createProductAction->__invoke($request);
    }

    /**
     * 商品一覧
     */
    public function listProducts(Request $request): JsonResponse
    {
        return $this->listProductAction->__invoke($request);
    }

    /**
     * 商品価格設定
     */
    public function createPrice(Request $request): JsonResponse
    {
        return $this->createPriceAction->__invoke($request);
    }

    /**
     * 支払いページ作成
     */
    public function createCheckoutSession(Request $request): JsonResponse
    {
        // ユーザーが選択した商品の価格IDを取得
        $priceId = $request->input('stripe_price_id');

        // ユーザーのstripe_account_idを取得
        $stripeAccountId = $request->user()->account->stripe_account_id ?? null;

        // 支払いページ作成オプション
        $options = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => 'https://kaoo-pass.com/success',
            'cancel_url' => 'https://kaoo-pass.com/cancel',
        ];

        // stripe_account_idが存在する場合、オプションに追加
        if ($stripeAccountId !== null) {
            $options['stripe_account'] = $stripeAccountId;
        }

        // 支払いページ作成
        $session = $this->stripe->checkout->sessions->create($options);
        $url = $session->url;

        return response()->json(['url' => $url], 200);
    }
}
