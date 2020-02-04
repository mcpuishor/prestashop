<?php 
namespace Mcpuishor\Prestashop\Image;
use Mcpuishor\Prestashop\Abstracts\Model;


class Image extends Model {
	protected $table = "ps_image";
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

}