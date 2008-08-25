<?php
require_once "testClass.php";

$myRegistry = new TestRegistry();

$myRegistry->addProduct(new TestProduct(1, "first product", 30));
echo "Added 1st product<br>";
$myRegistry->addProduct(new TestProduct(2, "2nd product", 50));
echo "Added 2nd product<br>";
$myRegistry->addProduct(new TestProduct(3, "third product", 100));
echo "Added 3rd product<br>";

echo "Currently there are <b>" . $myRegistry->countProducts() . "</b> products in the registry.<br>";
echo "<pre>" . var_dump($myRegistry) . "</pre>";

$myRegistry->removeProduct(new TestProduct(3, "third product", 100));
echo "Removed 2nd product.<br>";

echo "Currently there are <b>" . $myRegistry->countProducts() . "</b> products in the registry.<br>";
echo "<pre>" . var_dump($myRegistry) . "</pre>";
?>