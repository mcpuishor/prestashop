<?php 
namespace Mcpuishor\Prestashop\Services;

use Mcpuishor\Prestashop\Repositories\Interfaces\CombinationRepositoryInterface;
use Mcpuishor\Prestashop\Stock\Stock;

class updateStock {

	private $combinationRepository;
	private $combination;

	public function __construct(CombinationRepositoryInterface $combination)
	{
		$this->combinationRepository = $combination;
	}

	public function byReference($reference, $newStock)
	{
		$this->combination = $this->combinationRepository->findByReference($reference);
		return $this->update($newStock);
	}

	public function byId($id, $newStock)
	{
		$this->combination = $this->combinationRepository->findById($id);
		$this->update($newStock);
	}

	private function update($newStock)
	{
		return $this->updateCombinationStock($newStock) && 
			   $this->updateStockStock($newStock);
	}

	private function updateCombinationStock($newStock)
	{
		if (!$this->combination) {
			return false;
		}
		$this->combination->quantity = $newStock;
		return $this->combination->save();
	}

	private function updateStockStock($newStock)
	{
		$stocks = $this->combination
					->stocks()->inShop($this->combinationRepository->getShop()->id_shop)
					->first();
		if (!$stocks) {
			return false;
		}
		$stocks->quantity = $newStock;
		return $stocks->save(); 
	}

}