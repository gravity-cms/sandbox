<?php


namespace Gravity\CmsBundle\Search;

/**
 * Class SearchAdaptorInterface
 *
 * @package Gravity\CmsBundle\Search
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface SearchAdaptorInterface
{
    /**
     * Search for an term in an entity
     *
     * @param string $entityClass
     * @param array  $conditionGroups
     * @param string $resultSize
     * @param string $pageSize
     *
     * @return \object[]
     */
    public function search($entityClass, array $conditionGroups, $resultSize = null, $pageSize = null);
}
