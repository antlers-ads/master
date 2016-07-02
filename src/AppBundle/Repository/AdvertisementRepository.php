<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Advertisement;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;

/**
 * Advertisement entity repository.
 */
class AdvertisementRepository extends EntityRepository
{
    /**
     * Builds query to retrieve all advertisements.
     *
     * @param integer $limit
     * @return Query
     */
    public function getAllQuery($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('Advertisement');
        $queryBuilder->orderBy('Advertisement.id', 'DESC');

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves all advertisements.
     *
     * @param integer $limit
     * @return Advertisement[]
     */
    public function getAll($limit = null)
    {
        $query = $this->getAllQuery($limit);

        return $query->getResult();
    }

    /**
     * Builds query used to retrieve advertisement by id.
     *
     * @param integer $id
     * @return Query
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->createQueryBuilder('Advertisement');
        $queryBuilder->andWhere('Advertisement.id = :id')->setParameter('id', $id);
        $queryBuilder->setMaxResults(1);
        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves advertisement by id.
     *
     * @param integer $id
     * @throws NonUniqueResultException
     * @return Advertisement|null
     */
    public function getById($id)
    {
        $query = $this->getByIdQuery($id);
        try {
            return $query->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
