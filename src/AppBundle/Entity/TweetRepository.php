<?php

namespace AppBundle\Entity;

/**
 * TweetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TweetRepository extends \Doctrine\ORM\EntityRepository
{
	public function findLastTweets($border, $order)
	{
	    $qb = $this->createQueryBuilder('a');
	    $qb->where('a.tweeter_id'.$order.':border');

	    $qb->orderBy('a.creation_date', 'DESC');
	    $qb->setMaxResults(10);
	    $qb->setParameter('border', $border);

	    return $qb->getQuery()->getResult();
	}
}
