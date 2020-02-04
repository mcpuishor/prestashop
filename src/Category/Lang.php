<?php 
namespace Mcpuishor\Prestashop\Category;
use Mcpuishor\Prestashop\Abstracts\Model;

class Lang extends Model {
	protected $table = "ps_category_lang";
	protected $primaryKey = "id_category";
	public $timestamps = false;
	
}