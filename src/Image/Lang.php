<?php 
namespace Mcpuishor\Prestashop\Image;
use Mcpuishor\Prestashop\Abstracts\Model;

class Lang extends Model {
	protected $table = "image_lang";
	protected $primaryKey = "id_image";
	public $timestamps = false;

	protected $fillable = ["id_image", "legend", "id_lang"];
}