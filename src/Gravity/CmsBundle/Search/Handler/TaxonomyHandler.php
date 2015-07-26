<?php


namespace Gravity\CmsBundle\Search\Handler;

use Doctrine\ORM\EntityManager;
use Gravity\CmsBundle\Field\FieldManager;
use Gravity\CmsBundle\Search\SearchAdaptorInterface;
use Gravity\TagBundle\Entity\Tag;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TaxonomyHandler
 *
 * @package Gravity\CmsBundle\Search\Handler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TaxonomyHandler implements HandlerInterface
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
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * EntityHandler constructor.
     *
     * @param SearchAdaptorInterface $searchAdaptor
     * @param FieldManager           $fieldManager
     * @param EntityManager          $entityManager
     */
    public function __construct(
        SearchAdaptorInterface $searchAdaptor,
        FieldManager $fieldManager,
        EntityManager $entityManager
    ) {
        $this->searchAdaptor = $searchAdaptor;
        $this->entityManager = $entityManager;
        $this->fieldManager  = $fieldManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'taxonomy';
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions($term, array $options)
    {
        $fieldSearch = [
            'vocab' => [],
            'terms' => [
                'name' => $term,
            ],
        ];

        $fieldDefinitions = $this->fieldManager->getEntityFieldMapping($options['class']);

        foreach ($fieldDefinitions as $fieldName => $fieldDefinition) {
            if ($fieldDefinition['searchable']) {
                $fieldSearch['terms'][$fieldName] = $term;
            }
        }

        /** @var Tag[] $taxonomies */
        $taxonomies = $this->searchAdaptor->search(
            $options['class'],
            $fieldSearch,
            $options['page_size'],
            $options['page_offset']
        );

        $tagOptions = [];
        foreach ($taxonomies as $taxonomy) {
            $tagOptions[] = [
                'text' => (string)$taxonomy,
                'id'   => $taxonomy->getId(),
            ];
        }

        if($options['allow_new']){
            $tagOptions[] = [
                'text' => $term,
                'id'   => $term,
            ];
        }

        return $tagOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function getObjects(array $tags, array $options)
    {
        $tagIds = [];
        $newTags = [];

        foreach($tags as $tag){
            if(is_numeric($tag)){
                $tagIds[] = $tag;
            } else {
                $newTags[] = (string) $tag;
            }
        }

        $tagObjects = $this->entityManager->getRepository($options['class'])->findBy(
            [
                'id' => $tagIds,
            ]
        );


        if($options['allow_new']){
            $class = $options['class'];
            foreach($newTags as $tagText){
                /** @var $newTag Tag */
                $tagObjects[] = $newTag = new $class();
                $newTag->setName($tagText);
                // TODO: events?
            }
        }

        return $tagObjects;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaults(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setDefaults(
            [
                'class'        => '\Gravity\TagBundle\Entity\Tag',
                'page_size'    => null,
                'page_offset'  => null,
                'allow_new'    => false,
            ]
        );

        $optionsResolver->setAllowedTypes('class', 'string');
        $optionsResolver->setAllowedTypes('allow_new', 'bool');
    }
}
