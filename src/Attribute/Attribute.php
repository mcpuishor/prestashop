<?php 
namespace Mcpuishor\Prestashop\Attribute;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\AttributeGroup\AttributeGroup;
use Mcpuishor\Prestashop\Lang\Lang;
use Mcpuishor\Prestashop\Shop\Shop;

class Attribute extends Model {
	protected $table = "ps_attribute";
	protected $primaryKey = "id_attribute";
	public $incrementing = true;
	public $timestamps = false;

	protected $with = ["lang", "group", "shop"];

	private $lang_pivotKeys = [
		"name"
	];

	protected $guarded = ["id_attribute"];

	public function lang()
	{
		return $this->belongsToMany(Lang::class, "ps_attribute_lang", $this->primaryKey, "id_lang")
				->as("details")
				->withPivot($this->lang_pivotKeys);
	}

	public function group()
	{
		return $this->belongsTo(AttributeGroup::class, $this->primaryKey);
	}

	public function shop()
	{
		return $this->belongsToMany(Shop::class, "ps_attribute_shop", $this->primaryKey, "id_shop");
	}

}