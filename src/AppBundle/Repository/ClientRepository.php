<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;

/**
 * Client entity repository.
 */
class ClientRepository extends EntityRepository
{
    /**
     * Builds query to retrieve all clients.
     *
     * @param integer $limit
     * @return Query
     */
    public function getAllQuery($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('Client');
        $queryBuilder->orderBy('Client.name', 'ASC');

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves all clients.
     *
     * @param integer $limit
     * @return Client[]
     */
    public function getAll($limit = null)
    {
        $query = $this->getAllQuery($limit);

        return $query->getResult();
    }

    /**
     * Builds query used to retrieve client by id.
     *
     * @param integer $id
     * @return Query
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->createQueryBuilder('Client');
        $queryBuilder->andWhere('Client.id = :id')->setParameter('id', $id);
        $queryBuilder->setMaxResults(1);
        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves client by id.
     *
     * @param integer $id
     * @throws NonUniqueResultException
     * @return Client|null
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
