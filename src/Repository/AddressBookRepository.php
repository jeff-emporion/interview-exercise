<?php

namespace App\Repository;

use App\Entity\AddressBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;

/**
 * @method AddressBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddressBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddressBook[]    findAll()
 * @method AddressBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressBook::class);
    }
    
    
    /**
     * 
     * {@inheritDoc}
     * @see \Doctrine\ORM\EntityRepository::findAll()
     */
    public function findAll()
    {
    	return $this->createQueryBuilder('a')
    	->getQuery()
    	->getArrayResult();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Doctrine\ORM\EntityRepository::find()
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
    	$data = $this->createQueryBuilder('a')->andWhere('a.id=:id')
    	->setParameter('id', $id)
    	->getQuery()
    	->getResult(AbstractQuery::HYDRATE_ARRAY);
    	
    	return empty($data)?[]:reset($data);
    }
}
