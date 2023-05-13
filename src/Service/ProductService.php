<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\Query;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function saveProductInDataBases(Product $product): void
    {
        $this->productRepository->save($product);
    }

    public function deleteProduct(Product $product): void
    {
        $this->productRepository->remove($product);
    }

    public function getProductByName(string $name): Product|null
    {
        return $this->productRepository->getProductByName($name);
    }

    public function getAllListProduct(): array
    {
        return $this->productRepository->getAllListProduct();
    }

    public function getProductById(int $id): Product|null
    {
        return $this->productRepository->getProductById($id);
    }

    public function updateProduct(): void
    {
        $this->productRepository->updateProduct();
    }

    public function getAllListDrink(): Query
    {
        return $this->productRepository->getAllListDrink();
    }

    public function getAllListSoup(): Query
    {
        return $this->productRepository->getAllListSoup();
    }

    public function getAllListSnack(): Query
    {
        return  $this->productRepository->getAllListSnack();
    }

    public function isThereProductInStock(int $id): bool
    {
        if ($this->productRepository->getQuantityOfProduct($id) > 0) {
            return true;
        }
        return false;
    }

    public function reduceQuantityOfGoodsByOne(int $id): void
    {
        $product = $this->productRepository->getProductById($id);
        $quantity = $product->getQuantity();
        $quantity--;
        $product->setQuantity($quantity);
        $this->updateProduct();
    }
}