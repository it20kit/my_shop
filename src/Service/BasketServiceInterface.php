<?php

namespace App\Service;

use App\Entity\Basket;
use App\Entity\Product;
use Symfony\Component\Security\Core\User\UserInterface;

interface BasketServiceInterface
{
    public function getBasketUser(UserInterface $user): Basket;

    public function deleteProductUser($basket, $product): void;

    public function addProductUser(Basket $basket, Product $product): void;
}