<?php
class TestProduct {
	/**
	 * @var int $code
	 */
	private $code;
	/**
	 * @var string $name
	 */
	private $name;
	/**
	 * @var int $price
	 */
	private $price;
	
	/**
	 * @param int $code
	 * @param string $name
	 * @param int $price
	 */
	public function __construct($code, $name, $price) {
		$this->code = $code;
		$this->name = $name;
		$this->price = $price;
	}
	
	/**
	 * @return int
	 */
	public function getCode() {
		return $this->code;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return int
	 */
	public function getPrice() {
		return $this->price;
	}
}

class TestRegistry {
	private $products;
	
	/**
	 * @param int $code
	 * @param string $name
	 * @param int $price
	 * @return string
	 */
	public function addProduct($code, $name, $price) {
		$newTestProduct = new TestProduct($code, $name, $price);
		$this->products[] = $newTestProduct;
		$strBuffer = "adding a product - code: {$newTestProduct->getCode()}; name: {$newTestProduct->getName()}; price: {$newTestProduct->getPrice()};...<br>";
		$strBuffer .= "just added product: " . var_export($this->products, true) . "...<br>";
		$strBuffer .= "now holds " . $this->countProducts() . " products...<br><br>";
		return $strBuffer;
	}
	
	/**
	 * @param int $code
	 * @return string
	 */
	public function removeProduct($code) {
		foreach($this->products as $key => $product) {
			if($product->getCode() == $code) {
				unset($this->products[$key]);
				return "removing product code: $code;...<br>";
			}
		}
		return "no product found with the given code: $code;...<br>";
	}
	
	/**
	 * @return int
	 */
	public function countProducts() {
		return count($this->products);
	}
	
	/**
	 * @return string
	 */
	public function listProducts() {
		return var_export($this->products, true);
	}
}
?>