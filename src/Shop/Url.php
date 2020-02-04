<?php
namespace Mcpuishor\Prestashop\Shop;
use Mcpuishor\Prestashop\Abstracts\Model;


class Url extends Model {
	protected $table = "ps_shop_url";
	protected $primaryKey = "id_shop_url";

	public function shop()
	{
		return $this->belongsTo(Shop::class);
	}

}