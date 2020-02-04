<?php 
namespace Mcpuishor\Prestashop\Repositories\Interfaces;

use Mcpuishor\Prestashop\Shop\Shop,
	Mcpuishor\Prestashop\Lang\Lang;

interface CombinationRepositoryInterface {
	public function findByReference($reference);
	public function findById($id);
	//public function getProduct($reference);
}