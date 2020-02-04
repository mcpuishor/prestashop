<?php 
namespace Mcpuishor\Prestashop\Attribute;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\AttributeGroup\AttributeGroup;
use Mcpuishor\Prestashop\Lang\Lang;

class Attribute extends Model {
	protected $table = "ps_attribute";
	protected $primaryKey = "id_attribute";
	public $timestamps = false;

	protected $with = ["lang", "group"];

	private $lang_pivotKeys = [
		"name"
	];

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

}