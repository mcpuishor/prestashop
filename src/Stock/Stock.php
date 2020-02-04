<?php 
namespace Mcpuishor\Prestashop\Stock;
use Mcpuishor\Prestashop\Abstracts\Model;

use Mcpuishor\Prestashop\Product\Product,
	Mcpuishor\Prestashop\Shop\Shop,
	Mcpuishor\Prestashop\Product\ProductAttribute;

class Stock extends Model {
	const STOCK_OOS_DEFAULT = 2;
	const STOCK_OOS_ALLOWORDERS = 1;
	const STOCK_OOS_DENYORDERS = 0;

	protected $table = "ps_stock_available";
	protected $primaryKey = "id_stock_available";
	public $timestamps = false;

	protected $attributes = [
		"out_of_stock" => self::STOCK_OOS_DEFAULT,
	];

	protected $guarded = [];

	public function productAttribute()
	{
		return $this->belongsTo(ProductAttribute::class, $this->primaryKey);
	}

	public function product()
	{
		return $this->belongsTo(Product::class, $this->primaryKey);
	}

	public function shop()
	{
		return $this->belongsTo(Shop::class, $this->primaryKey);
	}


	public function scopeInShop($query, $shopId)
	{
		return $query->where("id_shop", $shopId);
	}

}