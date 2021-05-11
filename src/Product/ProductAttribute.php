<?php 
namespace Mcpuishor\Prestashop\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Mcpuishor\Prestashop\Abstracts\Model;

use Mcpuishor\Prestashop\Attribute\Attribute,
	Mcpuishor\Prestashop\Shop\Shop,
	Mcpuishor\Prestashop\Product\Product,
	Mcpuishor\Prestashop\Image\Image,
	Mcpuishor\Prestashop\Stock\Stock;

class ProductAttribute extends Pivot {

	protected $table = "product_attribute";
	protected $primaryKey = "id_product_attribute";
	public $incrementing = true;
	public $timestamps = false;

	 protected $with=['product.shop',"attribute", "stocks", "images"];
	// 
	
	public function product()
	{
		return $this->belongsTo(Product::class, "id_product");
	}	

	public function attribute()
	{
		return $this->belongsToMany(Attribute::class, "ps_product_attribute_combination", $this->primaryKey, "id_attribute")
				->as("details");
	}

	public function images()
	{
		return $this->belongsToMany(Image::class, "ps_product_attribute_image", $this->primaryKey, "id_image");
	}

	public function shop()
	{
		return $this->belongsToMany(Shop::class, "ps_product_attribute_shop", $this->primaryKey, "id_shop");
	}

	public function stocks()
	{
		return $this->hasMany(Stock::class, $this->primaryKey);
	}

	/*
		Local scopes for querying the model
	 */
	
	public function scopeHavingReference($query, $reference)
	{
		return $query->where("reference", $reference);
	}

	public function scopeInShop($query, $shopId)
	{
		return $query->whereHas("shop", 
						function($query) use ($shopId){
							$query->where("ps_shop.id_shop", $shopId);
						});
	}


	/*
		Handler to delete associated models when deleting a product 
	 */

	public static function boot() {
		parent::boot();

		static::deleting(function($productattribute){
			$productattribute->attribute()->delete();
			$productattribute->images()->delete();
			$productattribute->stocks()->delete();
		});
	}

}