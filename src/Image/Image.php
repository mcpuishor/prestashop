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
		return $this->hasOne(Lang::class, $this->primaryKey);
	}

	public function shop()
	{
		return $this->hasMany(ImageShop::class, $this->primaryKey);
	}

}