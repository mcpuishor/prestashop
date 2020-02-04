<?php 
namespace Mcpuishor\Prestashop\Services\Product;

use Illuminate\Support\Carbon;
use Mcpuishor\Prestashop\Product\Lang;
use Mcpuishor\Prestashop\Product\Product;
use Mcpuishor\Prestashop\Product\Shop;
use Mcpuishor\Prestashop\Repositories\Interfaces\ProductRepositoryInterface;

class create {
	private $productRepository;
	private $product;

	public function __construct(ProductRepositoryInterface $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function execute($data)
	{
		if ($this->create($data["reference"])) {
            $this->attachToShop();
            $this->addLang($data["name"]);
        }
        return $this->productRepository->getFullProductByReference($data["reference"]);
	}

	private function create($reference)
	{

		$this->product = Product::updateOrCreate([
			"reference" => $reference,
		],[
			"available_date" => Carbon::now(),
		]);
		return $this->product;
	}

	private function attachToShop()
	{
		if (!$this->product) {
			throw \Exception("No product to attach to this shop");
		}
		return  Shop::updateOrCreate([
			"id_shop" => $this->productRepository->getShop()->id_shop,
			"id_product" => $this->product->id_product,
		], [
			"available_date" => Carbon::now(),
			"id_category_default" => $this->productRepository->getShop()->id_category
		]);
	}
	
	private function addLang($name) 
	{	
		if (!$this->product) {
			throw \Exception("No product to attach this language to.");
		}
		 return Lang::updateOrCreate(
		 	[
				"id_product" => $this->product->id_product,
				"id_shop" => $this->productRepository->getShop()->id_shop,
				"id_lang" => $this->productRepository->getLang()->id_lang,
			],
			[
				"name" =>$name,
			]);
	}

}