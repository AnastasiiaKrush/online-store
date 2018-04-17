<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */

//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findAllStockProducts()
    {
        $qb = $this->createQueryBuilder('p');
        $qb = $qb
            ->select('p.id, p.name, p.description_short, p.price_old, p.price_new, pi.link')
            ->leftJoin('App\Entity\ProductImages', 'pi', "WITH", 'p.id = pi.product')
            ->innerJoin('App\Entity\ProductCategory', 'pc', "WITH", 'p.id = pc.product')
            ->where('pi.is_slider=1')
            ->andWhere('pc.category=5')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults(4);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
