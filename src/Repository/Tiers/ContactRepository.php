<?php

namespace App\Repository\Tiers;

use App\Entity\Tiers\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * Retourne tous les contacts d'un client
     * @return Contact[] Returns an array of Contact objects
     */
    public function searchByClient($id_cweb_client)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->join('c.client', 'client');
        $qb->andWhere('client.id_cweb = :id_cweb_client');
        $qb->setParameter('id_cweb_client', $id_cweb_client);

        return $qb->getQuery()->getResult();
    }
}
