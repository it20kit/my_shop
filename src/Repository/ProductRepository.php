<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private const
        DRINK = 1,
        SOUP = 2,
        SNACK = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Product $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function getProductByName(string $name): Product|null
    {
        return $this->findOneBy(['title' => $name]);
    }

    public function getAllListProduct(): array
    {
        return $this->findAll();
    }

    public function getProductById(int $id): Product|null
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function updateProduct(): void
    {
        $this->getEntityManager()->flush();
    }

    public function getAllListDrink(): Query
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.type = 1')
            ->getQuery();
    }

    public function getAllListSoup(): Query
    {
        return  $this->createQueryBuilder('p')
            ->andWhere('p.type = 2')
            ->getQuery();
    }

    public function getAllListSnack(): Query
    {
        return  $this->createQueryBuilder('p')
            ->andWhere('p.type = 3')
            ->getQuery();
    }

    public function getQuantityOfProduct(int $id): int|null
    {
        $product = $this->find($id);
        return $product->getQuantity();
    }
}
