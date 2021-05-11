<?php 
namespace Mcpuishor\Prestashop\AttributeGroup;
use Mcpuishor\Prestashop\Abstracts\Model;

class AttributeGroup extends Model {
	protected $table = "attribute_group";
	protected $primaryKey = "id_attribute_group";
	public $timestamps = false;

	protected $with = ["lang"];

	public function lang()
	{
		return $this->hasOne(Lang::class, $this->primaryKey);
	}
	
}