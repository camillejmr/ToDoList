<?php

namespace App\Repository;

use App\Entity\Liste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Liste>
 *
 * @method Liste[]|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liste[]    findAll()
 * @method Liste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liste::class);
    }

    public function add(Liste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Liste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBest()
    {
        //en DQL
//        $entityManager = $this->getEntityManager();
//        $dql = "
//        SELECT l
//        FROM App\Entity\Liste l
//        WHERE l.dateCreation > '2022-06-16 13:29:55'
//        AND l.finished = 0";
//        $query = $entityManager->createQuery($dql);
//        $query->setMaxResults(100);
//        return $query->getResult();

        //Query Builder
        $queryBuilder = $this->createQueryBuilder('l');
        $queryBuilder->andWhere("l.dateCreation >='2022-06-16 13:29:55'");
        $queryBuilder->andWhere("l.finished !=1");
        $queryBuilder->addOrderBy("l.name",'DESC');
        $query=$queryBuilder->getQuery();
        $query->setMaxResults(100);
        return $query->getResult();

    }

}
