<?php 
namespace Mcpuishor\Prestashop\Customer;
use Mcpuishor\Prestashop\Abstracts\Model;
use Mcpuishor\Prestashop\Shop\Shop;
use Mcpuishor\Prestashop\Customer\Order;
use Mcpuishor\Prestashop\Customer\Address;



class Customer extends Model {
	protected $table = "customer";
	protected $primaryKey = "id_customer";
	public $timestamps = true;
	public $incrementing = true;

	protected $attributes = [
		
	];

	public function orders()
	{
		$this->hasMany(Order::class, $this->primaryKey);
	}

	public function addresses()
	{
		$this->hasMany(Address::class, $this->primaryKey);
	}

	public function gender()
	{
		$this->belongsTo(Gender::class);
	}

	public function shop()
	{
		$this->belongsTo(Shop::class, $this->primaryKey);
	}

}