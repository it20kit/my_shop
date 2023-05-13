<?php

namespace App\Controller;

use App\Form\DeleteProductByNameType;
use App\Service\BasketService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/basket')]
#[IsGranted('ROLE_USER')]
class BasketController extends AbstractController
{
    public function __construct(private ProductService $productService, private BasketService $basketService)
    {

    }

    #[Route('/add/{id}', name: 'app_basket')]
    public function addProductInBasket(int $id): Response
    {
        if (!$this->productService->isThereProductInStock($id)) {
            $this->addFlash('notice','Товара нет в наличии');
            return $this->render('shop/product_absent.html.twig');
        }
        $product = $this->productService->getProductById($id);
        $user = $this->getUser();
        $basket = $this->basketService->getBasketUser($user);
        $this->basketService->addProductUser($basket, $product);
        $this->productService->reduceQuantityOfGoodsByOne($id);
        $this->productService->updateProduct();
        return $this->render('basket/index.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product_list', name: 'basket_product_list')]
    public function getProductList(): Response
    {
        $user = $this->getUser();
        $basket = $this->basketService->getBasketUser($user);
        $products = $this->basketService->getProductsUser($basket)->getValues();

        return $this->render('basket/basket.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/menu', name: 'app_basket_menu')]
    public function basketMenu(): Response
    {
        return $this->render('basket/basket_menu.html.twig');
    }

    #[Route('/find_product', name: 'app_find_product_in_basket')]
    public function findProductInBasket(Request $request): Response
    {
        $user = $this->getUser();
        $heading = "Поиск продукта в корзине";
        $form = $this->createForm(DeleteProductByNameType::class);
        $form->handleRequest($request);
        $basket = $this->basketService->getBasketUser($user);
        $list = $this->basketService->getProductsUser($basket)->getValues();

        if ($form->isSubmitted() && $form->isValid()) {
            $dataForForm = $form->getData();
            $title = $dataForForm->getTitle();
            $product = $this->productService->getProductByName($title);

            if ($product !== null) {
                $id = $product->getId();
                return  $this->redirectToRoute('app_delete_product_user', ['id' => $id]);
            } else {
                $this->addFlash('notice','Такого продукта нет в корзине');
            }
        }
        return $this->render('basket/find_product_in_basket.html.twig', [
            'heading' => $heading,
            'form' => $form->createView(),
            'list' => $list,
        ]);
    }

    #[Route('/delete', name: 'app_delete_product_user')]
    public function deleteProductUser(Request $request): Response
    {
        $id = $request->get('id');
        $product = $this->productService->getProductById($id);
        $user = $this->getUser();
        $basket = $this->basketService->getBasketUser($user);
        $this->basketService->deleteProductUser($basket, $product);
        $this->productService->updateProduct();

        return  $this->redirectToRoute('basket_product_list');
    }
}
