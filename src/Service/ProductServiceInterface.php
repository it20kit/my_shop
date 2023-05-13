<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

interface ProductServiceInterface
{
    public function saveProductInDataBases(Product $product): void;

    public function deleteProduct(Product $product): void;

    public function getProductByName(string $name): Product|null;

    public function getAllListProduct(): array;

    public function getProductById(int $id): Product|null;

    public function updateProduct(): void;

    public function getAllListDrink(): Query;

    public function getAllListSoup(): Query;

    public function getAllListSnack(): Query;

    public function isThereProductInStock(int $id): bool;

    public function reduceQuantityOfGoodsByOne(int $id): void;

}