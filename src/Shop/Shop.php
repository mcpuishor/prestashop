<?php
namespace Mcpuishor\Prestashop\Shop;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Product\Product;

class Shop extends Model {
	protected $table = "shop";
	protected $primaryKey = "id_shop";
	
	protected $guarded = [
		"id_shop", "id_shop_group", "id_category", "theme_name", "active", "name"
	];

	private $shop_pivotKeys = ["id_category_default","id_tax_rules_group","on_sale","online_only","ecotax",
						  "minimal_quantity","price","wholesale_price","unity","unit_price_ratio","additional_shipping_cost",
						  "customizable","uploadable_files","text_fields","active","redirect_type","id_type_redirected",
						  "available_for_order","available_date","show_condition","condition","show_price","indexed","visibility",
						  "cache_default_attribute","advanced_stock_management","date_add","date_upd","pack_stock_type"
					];


	public function url()
	{
		return $this->hasOne(Url::class, $this->primaryKey);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, "ps_product_shop", $this->primaryKey, "id_product")
				->as("details")
					->withPivot($this->shop_pivotKeys);
	}

}
