<?php 
namespace Mcpuishor\Prestashop\Abstracts;

use Illuminate\Database\Eloquent\Model as LaravelModel;

class Model extends LaravelModel {
	public $incrementing = false;
	public $timestamps = false;
	const CREATED_AT = "date_add"; 
	const UPDATED_AT = "date_upd";

	protected $shop;
	protected $lang;

}