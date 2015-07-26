<?php


namespace Gravity\CmsBundle\Search\Handler;

use Doctrine\ORM\EntityManager;
use Gravity\CmsBundle\Search\SearchAdaptorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NodeHandler
 *
 * @package Gravity\CmsBundle\Search\Handler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeHandler implements HandlerInterface
{
    /**
     * @var SearchAdaptorInterface
     */
    protected $searchAdaptor;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * EntityHandler constructor.
     *
     * @param SearchAdaptorInterface $searchAdaptor
     * @param EntityManager          $entityManager
     */
    public function __construct(SearchAdaptorInterface $searchAdaptor, EntityManager $entityManager)
    {
        $this->searchAdaptor = $searchAdaptor;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'node';
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions($term, array $options)
    {
        return $this->searchAdaptor->search($options['class'], $term, $options['page_size'], $options['page_offset']);
    }

    /**
     * {@inheritDoc}
     */
    public function getObjects(array $tags, array $options)
    {
        $tagObjects = $this->entityManager->getRepository($options['class'])->findBy(
            [
                'id' => $tags,
            ]
        );

        return $tagObjects;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaults(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setRequired(
            [
                'class'
            ]
        );

        $optionsResolver->setDefaults(
            [
                'page_size'   => null,
                'page_offset' => null,
            ]
        );

        $optionsResolver->setAllowedTypes('class', 'string');
    }
}
