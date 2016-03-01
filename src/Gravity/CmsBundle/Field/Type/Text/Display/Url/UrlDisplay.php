<?php


namespace Gravity\CmsBundle\Field\Type\Text\Display\Url;

use Gravity\CmsBundle\Display\Type\AbstractDisplayDefinition;
use Gravity\CmsBundle\Entity\Field;
use Gravity\CmsBundle\Entity\FieldText;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Text\TextField;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UrlDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class UrlDisplay extends AbstractDisplayDefinition
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'text.url';
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'Url Link Text';
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return 'Link formatted html';
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        return 'GravityCmsBundle:Field/Text:url.html.twig';
    }

    /**
     * @param Field|FieldText $entity
     * @param array           $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        return [
            'url'     => $entity->getText(),
            'text'    => $entity->getText(), // TODO: make this configurable
            'new_tab' => $options['new_tab'],
            'follow'  => $options['follow'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = [])
    {
        $optionsResolver->setDefaults(
            [
                'new_tab' => true,
                'follow'  => true,
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return $field instanceof TextField;
    }
}
