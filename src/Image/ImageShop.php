<?php 
namespace Mcpuishor\Prestashop\Image;
use Mcpuishor\Prestashop\Abstracts\Model;


class ImageShop extends Model {
	protected $table = "ps_image_shop";
	protected $primaryKey = "id_image";
	public $timestamps = false;

	protected $with = ["lang"];

	public function product()
	{
		return $this->belongsTo(Product::class, $this->primaryKey);
	}

	public function lang()
	{
		return $this->hasOne(Lang::class, $this->primaryKey);
	}

	public function image()
	{
		return $this->belongsTo(Image::class, $this->primary_key);
	}

}