<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_id',
        'stripe_price_id',
        'stripe_product_id',
        'price',
        'description',
        'is_active',
    ];

    /**
     * Accountモデルとのリレーションを定義
     * 多対1の関係
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Account, \App\Models\Product>
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * 商品を作成
     *
     * @param  Request  $request
     * @param  string  $accountId
     * @param  string  $stripeProductId
     */
    public function createProduct(Request $request, string $accountId, string $stripeProductId): void
    {
        $this->setAttribute('name', $request->name);
        $this->setAttribute('description', $request->description);
        $this->setAttribute('account_id', $accountId);
        $this->setAttribute('stripe_product_id', $stripeProductId);
        $this->save();
    }

    /**
     * 価格を更新
     */
    public function updatePrice(Request $request): void
    {
        // 更新対象を設定
        $this->setAttribute('price', $request->price);
        $this->save();
    }
}
