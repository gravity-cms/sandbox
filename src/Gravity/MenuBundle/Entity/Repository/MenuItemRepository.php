<?php


namespace Gravity\MenuBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class MenuItemRepository
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuItemRepository extends EntityRepository
{
    /**
     * @param int $start
     * @param int $length
     *
     * @return Paginator
     */
    public function findAllWithPagination($start, $length)
    {
        $dql = 'SELECT m FROM '.$this->getEntityName().' m';
        $query = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($start)
            ->setMaxResults($length);

        return new Paginator($query, $fetchJoinCollection = true);
    }
}
