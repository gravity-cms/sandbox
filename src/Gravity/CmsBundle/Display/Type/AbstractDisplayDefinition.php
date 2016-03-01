<?php


namespace Gravity\CmsBundle\Display\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractDisplayDefinition
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractDisplayDefinition implements DisplayDefinitionInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAssetLibraries()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'GravityCmsBundle:Field:flat.html.twig';
    }

    /**
     * @inheritDoc
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'value' => $entity,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getListTemplate()
    {
        return 'GravityCmsBundle:Field:list-flat.html.twig';
    }

    /**
     * @inheritDoc
     */
    public function getListTemplateOptions($entities, array $options)
    {
        return [
            'entities' => $entities,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = [])
    {
    }
}
