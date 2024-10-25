<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function  CountNbBooks(){
        $query=$this->getEntityManager()
        ->createQuery('SELECT count(nb) from App\Entity\Book nb WHERE nb.Category = :category');
        $query->setParameter('category', 'Mystery');
        return $query->getSingleScalarResult();
    
    }
    public function  FindDate1(){
        $em=$this->getEntityManager()
        ->createQuery('SELECT b from App\Entity\Book b WHERE b.publicationDate between ?1 and ?2');
        $em->setParameters([1=>"2009-01-01",2=>"2222-12-12"]);
        return $em->getResult();
    
    }
    public function  FindDate($min,$max){
        $em=$this->getEntityManager()
        ->createQuery('SELECT b from App\Entity\Book b WHERE b.publicationDate between ?1 and ?2');
        $em->setParameters([1=>$min,2=>$max]);
        return $em->getResult();
    
    }
    public function AuthorByBook($user){

        return $this->createQueryBuilder('b')->join('b.id_Author','a')
        ->addSelect('a')
        ->where('a.username = :user')
        ->setParameter('user',$user)
        ->getQuery()
        ->getResult();
    
    }
}
