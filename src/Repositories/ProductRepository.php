<?php 
namespace Mcpuishor\Prestashop\Repositories;
use Mcpuishor\Prestashop\Repositories\Interfaces\ProductRepositoryInterface;

use Mcpuishor\Prestashop\Repositories\Traits\InContext,
	Mcpuishor\Prestashop\Product\Product;

class ProductRepository implements ProductRepositoryInterface
{
	use InContext;

	private function getContext() 
	{
		return Product::publishedIn($this->shop->id_shop)
				->inLang($this->lang->id_lang);
	}

	public function findByReference($reference)
	{
		return Product::havingReference( $this->formatReference($reference) )->first();
	}

	public function findByReferenceInShop($reference)
	{
		return $this->getContext()
				->with("shop")
				->havingReference( $this->formatReference($reference) )->first();
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
				->with("productattributes", "productattributes.stocks", "stocks", "images", "categories")
				->find($id);
	}

	public function getFullProductByReference($reference)
	{
		return $this->getContext()
				->havingReference(
					$this->formatReference($reference)
				)
				->with("shop", "productattributes", "productattributes.stocks", "stocks", "images", "categories")
				->first();
	}

	public function getFullProductById($id)
	{
		return $this->getContext()
				->with("productattributes", "productattributes.stocks", "stocks", "images", "categories")
				->find($id);
	}

	private function formatReference($value)
	{
		return trim(strtoupper($value));
	}


}