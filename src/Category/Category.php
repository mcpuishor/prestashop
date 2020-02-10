<?php 
namespace Mcpuishor\Prestashop\Category;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Category\Category;
use Mcpuishor\Prestashop\Lang\Lang;
use Mcpuishor\Prestashop\Product\Product;
use Mcpuishor\Prestashop\Shop\Shop;

class Category extends Model {
	protected $table = "ps_category";
	protected $primaryKey = "id_category";
	public $timestamps = true;

	private $shop_pivotKeys = ['position'];
	private $lang_pivotKeys = ['name', 'description', 'link_rewrite', 'meta_title', 'meta_keywords', 'meta_description'];

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
			->belongsToMany(Lang::class, "ps_category_lang", $this->primaryKey, "id_lang")
			->as("details")
			->withPivot($this->lang_pivotKeys);
	}

	public function parent()
	{
		return $this->belongsTo(Category::class, "id_parent", $this->primaryKey);
	}

	public function products()
	{
		return $this->hasMany(Product::class, "ps_category_product", $this->primaryKey, "id_product");
	}
}