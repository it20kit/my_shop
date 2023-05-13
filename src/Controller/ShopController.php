<?php

namespace App\Controller;

use App\Service\ProductService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop')]
class ShopController extends AbstractController
{
    public function __construct(private ProductService $productService)
    {
        $this->productService  = $productService;
    }

    #[Route('/menu_product', name: 'app_menu_product')]
    public function getMenuProduct(): Response
    {
        return $this->render('shop/menu_product.html.twig');
    }

    #[Route('/list_snacks', name: 'app_list_snacks')]
    public function getListSnacks(Request $request, PaginatorInterface $paginator): Response
    {
        $products = $paginator->paginate(
            $this->productService->getAllListSnack(),
            $request->query->getInt('page', 1), 3
        );
        return $this->render('shop/index.html.twig', [
            'products'=> $products
        ]);
    }

    #[Route('/list_drinks', name: 'app_list_drinks')]
    public function getListDrinks(Request $request, PaginatorInterface $paginator): Response
    {
        $products = $paginator->paginate(
            $this->productService->getAllListDrink(),
            $request->query->getInt('page', 1), 3
        );
        return $this->render('shop/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/list_soup', name: 'app_list_soup')]
    public function getListsSoups(Request $request, PaginatorInterface $paginator): Response
    {
        $products = $paginator->paginate(
            $this->productService->getAllListSoup(),
            $request->query->getInt('page', 1), 3
        );
        return $this->render('shop/index.html.twig', [
            'products' => $products
        ]);
    }
}
