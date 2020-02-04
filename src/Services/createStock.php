<?php 
namespace Mcpuishor\Prestashop\Services;

use Mcpuishor\Prestashop\Repositories\Interfaces\CombinationRepositoryInterface;
use Mcpuishor\Prestashop\Stock\Stock;

class createStock {
	private $combinationRepository;
	private $combination;

	public function __construct(CombinationRepositoryInterface $combination)
	{
		$this->combinationRepository = $combination;
	}

	public function byReference($reference, $stock)
	{
		$this->combination = $this->combinationRepository->findByReference($reference);
		if ($this->combination) {
			return $this->create($stock);
		}
		return false;
	}

	private function create($stock)
	{
		return Stock::create([
			"id_product" => $this->combination->product->id_product,
			"id_product_attribute" => $this->combination->id_product_attribute,
			"id_shop" => $this->combinationRepository->getShop()->id_shop,
			"id_shop_group" =>0,
			"quantity" => $stock,
		]);

	}

}