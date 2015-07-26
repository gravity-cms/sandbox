<?php


namespace Gravity\CmsBundle\Search\Adaptor;

use Doctrine\ORM\EntityManager;
use Gravity\CmsBundle\Field\FieldManager;
use Gravity\CmsBundle\Search\SearchAdaptorInterface;

/**
 * Class SqlSearchAdaptor
 *
 * @package Gravity\CmsBundle\Search\Adaptor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SqlSearchAdaptor implements SearchAdaptorInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * SqlSearchAdaptor constructor.
     *
     * @param EntityManager $entityManager
     * @param FieldManager  $fieldManager
     */
    public function __construct(EntityManager $entityManager, FieldManager $fieldManager)
    {
        $this->entityManager = $entityManager;
        $this->fieldManager  = $fieldManager;
    }

    /**
     * {@inheritdoc}
     */
    public function search($entityClass, array $conditionGroups, $resultSize = null, $pageSize = null)
    {
        $queryBuilder = $this->entityManager->getRepository($entityClass)->createQueryBuilder('t');

        $metadata = $this->entityManager->getClassMetadata($entityClass);

        $tableIndex = 0;
        $parameters = [];
        foreach ($conditionGroups as $conditions) {

            $condition  = $queryBuilder->expr()->orX();
            foreach($conditions as $field => $term) {
                if ($metadata->hasField($field)) {
                    $mapping = $metadata->getFieldMapping($field);
                    if ($mapping !== 'array') {
                        $param = $field . '__value';
                        $condition->add(
                            't.' . $field . ' LIKE :' . $param
                        );
                        $parameters[$param] = '%' . $term . '%';
                    }
                } else {
                    if ($metadata->hasAssociation($field)) {
                        $association = $metadata->getAssociationMapping($field);
                        $param       = $field . '__value';
                        $table       = 't' . $tableIndex;
                        ++$tableIndex;
                        $queryBuilder->join('t.' . $field, $table);
                        $condition->add(
                            $table . '.id IN (:' . $param . ')'
                        );
                        $parameters[$param] = $term;
                    }
                }
            }

            $queryBuilder->andWhere($condition);
        }


        $queryBuilder->setParameters($parameters);

        $query = $queryBuilder->getQuery()->setMaxResults($resultSize)->setFirstResult($pageSize * $resultSize);

        return $query->getResult();
    }
}
