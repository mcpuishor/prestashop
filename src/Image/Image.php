<?php 
namespace Mcpuishor\Prestashop\Image;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Image\ImageShop;
use Mcpuishor\Prestashop\Product\Product;


class Image extends Model {
	protected $table = "ps_image";
	protected $primaryKey = "id_image";
	public $timestamps = false;

	// protected $with = ["lang", "shop"];

	public function product()
	{
		return $this->belongsTo(Product::class, $this->primaryKey);
	}

	public function lang()
	{
		return $this->belongsToMany(Lang::class, "ps_image_lang", $this->primaryKey, "id_lang")
				->as("details")
				->withPivot($this->lang_pivotKeys);
	}


	public function shop()
	{
		return $this
			->belongsToMany(Shop::class, "ps_image_shop", $this->primaryKey, "id_shop")
			->as("details")
			->withPivot($this->shop_pivotKeys);
	}

}