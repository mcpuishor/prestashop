<?php 
namespace Mcpuishor\Prestashop\AttributeGroup;
use Mcpuishor\Prestashop\Abstracts\Model;

class Lang extends Model {
	protected $table = "attribute_group_lang";
	protected $primaryKey = "id_attribute_group";
	public $timestamps = false;
	
}