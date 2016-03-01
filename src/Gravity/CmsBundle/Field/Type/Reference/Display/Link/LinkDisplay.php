<?php


namespace Gravity\CmsBundle\Field\Type\Reference\Display\Link;

use Gravity\CmsBundle\Display\Type\AbstractDisplayDefinition;
use Gravity\CmsBundle\Entity\FieldableEntity;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Gravity\CmsBundle\Field\Type\Reference\ReferenceField;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Router;

/**
 * Class LinkDisplay
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class LinkDisplay extends AbstractDisplayDefinition
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Router $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'reference.link';
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'Render a link to the referenced entity';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        return 'GravityCmsBundle:Field/Reference:link.html.twig';
    }

    /**
     * @param FieldableEntity|Node $entity
     * @param array                $options
     *
     * @return array
     */
    public function getTemplateOptions($entity, array $options)
    {
        if (!$entity) {
            return [];
        }
        $route = $entity->getRoute();
        $url   = $this->router->generate($route->getName(), []);

        return [
            'url'     => $url,
            'text'    => $entity->getTitle(), // TODO: make this configurable
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
        return $field instanceof ReferenceField;
    }

}
