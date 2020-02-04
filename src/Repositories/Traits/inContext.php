<?php 
namespace Mcpuishor\Prestashop\Repositories\Traits;

use Mcpuishor\Prestashop\Shop\Shop,
	Mcpuishor\Prestashop\Lang\Lang;

trait inContext {
	protected $shop;
	protected $lang;

	public function inShop(Shop $shop)
	{
		$this->shop = $shop;
		return $this;
	}

	public function inLang(Lang $lang)
	{
		$this->lang = $lang;
		return $this;
	}

	public function setContext(Shop $shop, Lang $lang)
	{
		return $this->inShop($shop)->inLang($lang);
	}

	public function getShop()
	{
		return $this->shop;
	}

	public function getLang()
	{
		return $this->lang;
	}
}