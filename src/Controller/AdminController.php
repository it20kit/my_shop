<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductType;
use App\Form\DeleteProductByIdType;
use App\Form\DeleteProductByNameType;
use App\Form\UpdateProductType;
use App\Service\FileService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    public function __construct(private FileService $fileService, private ProductService $productService)
    {
    }

    #[Route('/menu', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/add_product', name: 'app_add_product')]
    public function addProduct(Request $request): Response
    {
        $heading = 'Добавление товара в магазин';
        $product = new Product();
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('add_product')['image'];
            $name = $this->fileService->getUpdateNameFile($file);
            $this->fileService->saveFile($file, $name);;
            $product->setImage($name);
            $this->productService->saveProductInDataBases($product);
            $this->addFlash('notice','Товар успешно добавлен');
        }
        return $this->render('admin/add_product_form.html.twig',[
            'form' => $form->createView(),
            'heading' => $heading
        ]);
    }

    #[Route('/delete_menu', name: 'app_delete_menu')]
    public function deleteMenu(): Response
    {
        return $this->render('admin/delete_menu.html.twig');
    }

    #[Route('/delete_product_by_name', name: 'app_delete_product_by_name')]
    public function deleteProductByName(Request $request): Response
    {
        $heading = 'Удаление товара';
        $form = $this->createForm(DeleteProductByNameType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $title = $form->getData()->getTitle();
           $product = $this->productService->getProductByName($title);
           if ($product !== null) {
               $this->productService->deleteProduct($product);
               $this->addFlash('notice','Продукт успешно удален!!!');
           } else {
               $this->addFlash('notice','Такого продукта нет!!!');
           }
        }

        return $this->render('admin/delete_product_form_by_name.html.twig', [
            'form' => $form->createView(),
            'heading' => $heading
        ]);
    }

    #[Route('/all_list_product', name: 'app_all_list_product')]
    public function getAllListProduct(): Response
    {
        $list = $this->productService->getAllListProduct();
        return $this->render('admin/all_list_product.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/delete_by_id', name: 'app_delete_by_id')]
    public function deleteProductById(Request $request): Response
    {
        $heading = 'Удаление товара по id';
        $form = $this->createForm(DeleteProductByIdType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form->getData()->getPrice();
            $product = $this->productService->getProductById($id);
            if ($product !== null) {
                $this->productService->deleteProduct($product);
                $this->addFlash('notice','Продукт удален!!!');
            } else {
                $this->addFlash('notice','Продукта с таким id нету!!!');
            }
        }

        return $this->render('admin/delete_product_by_id.html.twig', [
            'form' => $form,
            'heading' => $heading
        ]);
    }

    #[Route('/find_product_by_id', name: 'app_find_product_by_id')]
    public function findProductById(Request $request): Response
    {
        $heading = 'Найти товар по id';
        $form = $this->createForm(DeleteProductByIdType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form->getData()->getPrice();
            $product = $this->productService->getProductById($id);
            if ($product !== null) {
                return $this->redirectToRoute('app_update_product', ['id' => $id]);
            } else {
                $this->addFlash('notice','Такого товара нету!!!');
            }
        }
        return $this->render('admin/find_product_by_id.html.twig', [
            'form' => $form,
            'heading' => $heading
        ]);
    }

    #[Route('/update_product', name: 'app_update_product')]
    public function updateProduct(Request $request): Response
    {
        $id = $request->get('id');
        $product = $this->productService->getProductById($id);

        $heading = 'Изменить продукт';
        $form = $this->createForm(UpdateProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->productService->updateProduct();
            return $this->redirectToRoute('app_all_list_product');
        }

        return $this->render('admin/update_product.html.twig', [
            'form' => $form,
            'heading' => $heading,
            'product' => $product
        ]);
    }
}
