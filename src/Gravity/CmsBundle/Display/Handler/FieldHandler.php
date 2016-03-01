<?php

namespace Gravity\CmsBundle\Display\Handler;

use Gravity\CmsBundle\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FieldHandler
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FieldHandler implements DisplayHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'field';
    }

    /**
     * @inheritDoc
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setDefaults(
            [
                'fields'       => [],
            ]
        )
            ->setAllowedTypes('fields', 'array');
    }

    /**
     * @inheritDoc
     */
    public function supportsRequest(Request $request)
    {
        return $request->attributes->get('_format') === 'html';
    }

    /**
     * @inheritDoc
     */
    public function getTemplate()
    {
        return 'GravityCmsBundle:Node:view.html.twig';
    }

    /**
     * @inheritDoc
     */
    public function getTemplateOptions(Node $node, array $options = [])
    {
        return [
            'node'             => $node,
            'display_mappings' => $options['fields'],
        ];
    }
}
