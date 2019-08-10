<?php

namespace App\Repository\Tiers;

use App\Entity\Tiers\Client;
use App\Repository\AbstractRepository;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends AbstractRepository
{
    public function searchBySociete($params)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->andWhere('c.societe LIKE :societe');
        $qb->setParameter('societe', '%'.$params['term'].'%');
        $qb->orderBy('c.societe', 'ASC');

        $limit = 20;
        if (isset($params['limit'])) {
            $limit = $params['limit'];
        }

        $offset = 0;
        if (isset($params['offset'])) {
            $offset = $params['offset'];
        }

        return $this->paginate($qb, $limit, $offset);
    }
}
