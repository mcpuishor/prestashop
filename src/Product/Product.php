<?php 
namespace Mcpuishor\Prestashop\Product;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Attribute\Attribute;
use Mcpuishor\Prestashop\Lang\Lang;

use Mcpuishor\Prestashop\Product\ProductAttribute,
	Mcpuishor\Prestashop\Stock\Stock,
	Mcpuishor\Prestashop\Image\Image,
	Mcpuishor\Prestashop\Category\Category,
	Mcpuishor\Prestashop\Shop\Shop;

class Product extends Model {

	const PRODUCT_VISIBLE_NONE = "none";
	const PRODUCT_VISIBLE_BOTH = "both";
	const PRODUCT_VISIBLE_SEARCH = "search";

	protected $table = "ps_product";
	protected $primaryKey = "id_product";
	public $timestamps = true;
	public $incrementing = true;

	protected $attributes = [
		'id_supplier' => 0,
		'id_manufacturer' => 0,
		'id_tax_rules_group' =>0,
		"on_sale" => 0,
		'online_only' => 0,
		'price' => 0,
		'out_of_stock' => Stock::STOCK_OOS_DEFAULT,
		'active' => 0,
		'redirect_type' => '404',
		'available_for_order' => 0,
		'condition' => 'new',
		'show_price' => 1,
		'indexed' => 1,
		'visibility' => self::PRODUCT_VISIBLE_NONE,
		'cache_default_attribute' => 0,
		'advanced_stock_management' => 0,
		'state' => 1, 
		"ean13" => "",
		"isbn" => "",
		"upc" => "",
		"location" => "",
	];

	private $shop_pivotKeys = ["id_category_default","id_tax_rules_group","on_sale","online_only","ecotax",
						  "minimal_quantity","price","wholesale_price","unity","unit_price_ratio","additional_shipping_cost",
						  "customizable","uploadable_files","text_fields","active","redirect_type","id_type_redirected",
						  "available_for_order","available_date","show_condition","condition","show_price","indexed","visibility",
						  "cache_default_attribute","advanced_stock_management","date_add","date_upd","pack_stock_type"
					];

	private $lang_pivotKeys = [ "id_product", "id_shop", "id_lang", "description", "description_short", "link_rewrite",
								"meta_description", "meta_keywords", "meta_title", "name", "available_now", "available_later"];

	protected $guarded = [];

	public function scopeHavingReference($query, $reference)
	{
		return $query->where("reference", $reference);
	}

	public function scopeInLang($query, $language)
	{
		return $query
			->with("lang")
			->whereHas("lang", function ($lang) use ($language) {
				$lang->where("ps_lang.id_lang", "=", $language);
				// $lang->find($language);
			});
	}

	public function scopePublishedIn($query, $shopId)
	{
		return $query
			->with("shop")
			->whereHas("shop", function($shop) use ($shopId) {
					$shop->where('ps_shop.id_shop', $shopId);
					// $shop->find($shopId);
				});
	}

	public function shop()
	{
		return $this
			->belongsToMany(Shop::class, "ps_product_shop", $this->primaryKey, "id_shop")
			->as("details")
			->withPivot($this->shop_pivotKeys);
	}

	public function lang()
	{
		return $this
			->belongsToMany(Lang::class, "ps_product_lang", $this->primaryKey, "id_lang")
			->as("details")
			->withPivot($this->lang_pivotKeys);
	}

	public function productattributes()
	{
		return $this->hasMany(ProductAttribute::class, $this->primaryKey);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, "ps_category_product", $this->primaryKey, "id_category")
				->withPivot(['position']);
	}

	public function defaultCategory()
	{
		return $this->belongsTo(Category::class,  "id_category_default", "id_category");
	}

	public function defaultShop()
	{
		return $this->belongsTo(Shop::class, "id_shop_default", "id_shop");
	}

	public function images()
	{
		return $this->hasMany(Image::class, $this->primaryKey);
	}

	public function stocks()
	{
		return $this->hasMany(Stock::class, $this->primaryKey);
	}

	/*
	
		Mutators for the attributes

	 */
	
	public function setReferenceAttribute($value)
	{
		$this->attributes["reference"] = strtoupper($value);
	}

	public function getTotalStockAttribute()
	{
		$stocksPerAttribute = $this->productattributes->map(function($item){ return $item->stocks; });
		$stocksPerAttribute = $stocksPerAttribute->merge($this->stocks);
		return $stocksPerAttribute->sum("quantity");
	}

	public function hasStock()
	{
		return $this->totalStock > 0;
	}

	public function variantsWithoutStock()
	{
		return $this->productattributes->filter(function($attribute, $key){
			return $attribute->stock->quantity <= 0;
		});
	}

	/*
		Creating a handle to delete associated models when deleting a product 
	 */

	public static function boot() {
		parent::boot();

		static::deleting(function($product){
			$product->lang()->delete();
			$product->productattributes()->delete();
			$product->images()->delete();
			$product->stocks()->delete();
		});
	}

}