<?php 
namespace Mcpuishor\Prestashop\Category;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Category\Category;
use Mcpuishor\Prestashop\Lang\Lang;
use Mcpuishor\Prestashop\Product\Product;
use Mcpuishor\Prestashop\Shop\Shop;

class Category extends Model {
	protected $table = "category";
	protected $primaryKey = "id_category";
	public $timestamps = true;

	private $shop_pivotKeys = ['position'];
	private $lang_pivotKeys = ['id_shop','name', 'description', 'link_rewrite', 'meta_title', 'meta_keywords', 'meta_description'];

	public function shop()
	{
		return $this
			->belongsToMany(Shop::class, "category_shop", $this->primaryKey, "id_shop")
			->as("details")
			->withPivot($this->shop_pivotKeys);
	}

	public function lang()
	{
		return $this
			->belongsToMany(Lang::class, "category_lang", $this->primaryKey, "id_lang")
			->as("details")
			->withPivot($this->lang_pivotKeys);
	}

	public function parent()
	{
		return $this->belongsTo(Category::class, "id_parent", $this->primaryKey);
	}

	public function products()
	{
		return $this->hasMany(Product::class, "category_product", $this->primaryKey, "id_product");
	}

	public function scopeChildren($query, $nleft, $nright)
	{
		return $query->where("nleft", ">", $nleft)
					 ->where("nright", "<", $nright)
					 ->orderBy("nleft");
	}

	public function scopeActive($query)
	{
		return $query->where("active", 1);
	}
}