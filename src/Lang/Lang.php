<?php 
namespace Mcpuishor\Prestashop\Lang;

use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Product\Product;
use Mcpuishor\Prestashop\Shop\Shop;

class Lang extends Model {
	protected $table = "lang";
	protected $primaryKey = "id_lang";

	public function shops()
	{
		return $this->belongsToMany(Shop::class, "ps_lang_shop", $this->primaryKey, "id_shop");
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, "ps_product_lang", $this->primaryKey, "id_product");
	}
}