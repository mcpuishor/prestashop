<?php 
namespace Mcpuishor\Prestashop\Repositories;
use Illuminate\Support\Facades\DB;
use Mcpuishor\Prestashop\Repositories\Interfaces\CombinationRepositoryInterface;
use Mcpuishor\Prestashop\Stock\Stock;

use Mcpuishor\Prestashop\Repositories\Traits\InContext,
	Mcpuishor\Prestashop\Product\ProductAttribute,
	Mcpuishor\Prestashop\Attribute\Attribute;

class CombinationRepository implements CombinationRepositoryInterface
{
	use InContext;

	private function getContext() 
	{
		return ProductAttribute::inShop($this->shop->id_shop);
	}

	public function findByReference($reference)
	{
		return $this->getContext()
				->havingReference($reference)
				->first();
	}

	public function findById($id)
	{
		return $this->getContext()
				->where("id_product", $id)
				->first();
	}

	public function all()
	{
		return $this->getContext()->all();
	}

	public function getFullProduct($id)
	{
		return $this->getContext()
				->where("id_product", $id)
				->with( "stocks", "images")
				->first();
	}

	public function getFullProductByReference($reference)
	{
		$shop = $this->shop->id_shop;
		return $this->getContext()
				->havingReference($reference)
				->with( "images", "stocks", "product")
				->with(["stocks" => function($query) use ($shop) {
					return $query->where("id_shop", $shop);
				}])
				->get();
	}
}