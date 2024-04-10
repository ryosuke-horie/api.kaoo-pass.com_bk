<?php

namespace App\Http\Controllers;

use App\Usecases\Stripe\CheckoutSessionAction;
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

    private CheckoutSessionAction $checkoutSessionAction;

    public function __construct()
    {
        // Stripeクライアントの初期化
        $this->stripe = new StripeClient(['api_key' => config('stripe.stripe_secret_key')]);
        $this->createAccountAction = new CreateAccountAction();
        $this->createProductAction = new CreateProductAction();
        $this->listProductAction = new ListProductAction();
        $this->createPriceAction = new CreatePriceAction();
        $this->checkoutSessionAction = new CheckoutSessionAction();
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
        return $this->checkoutSessionAction->__invoke($request);
    }
}
