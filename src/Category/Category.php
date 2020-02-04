<?php 
namespace Mcpuishor\Prestashop\Category;
use Mcpuishor\Prestashop\Abstracts\Model;

use Mcpuishor\Prestashop\Category\Lang;
use Mcpuishor\Prestashop\Product\Product;

class Category extends Model {
	protected $table = "ps_category";
	protected $primaryKey = "id_category";
	public $timestamps = true;

	protected $with = ["lang"];

	public function lang()
	{
		return $this->hasOne(Lang::class, $this->primaryKey);
	}

	public function products()
	{
		return $this->hasMany(Product::class, "ps_category_product", $this->primaryKey, "id_product");
	}

}