<?php

namespace App\Service;

use App\Entity\Basket;
use App\Entity\Product;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class BasketService implements BasketServiceInterface
{
    public function getProductsUser(Basket $basket): PersistentCollection
    {
        return $basket->getProducts();
    }


    public function getBasketUser(UserInterface $user): Basket
    {
        return $user->getBasket();
    }

    public function deleteProductUser($basket, $product): void
    {
        $basket->removeProduct($product);
    }

    public function addProductUser(Basket $basket, Product $product): void
    {
        $basket->addProduct($product);
    }
}