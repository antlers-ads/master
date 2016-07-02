<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Client;
use Doctrine\ORM\EntityRepository;
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
}
