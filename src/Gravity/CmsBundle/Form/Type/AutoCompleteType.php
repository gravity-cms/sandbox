<?php


namespace Gravity\CmsBundle\Form\Type;

use Gravity\CmsBundle\Form\DataTransformer\AutoCompleteTransformer;
use Gravity\CmsBundle\Search\Handler\HandlerManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutoCompleteType extends AbstractType
{

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * @param HandlerManager $handlerManager
     * @param Router         $router
     */
    function __construct(HandlerManager $handlerManager, Router $router)
    {
        $this->router         = $router;
        $this->handlerManager = $handlerManager;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'limit'              => null,
                    'name'               => null,
                    'allow_new'          => false,
                    'handler_options'    => [],
                    'multiple'           => true,
                    'autocomplete_route' => 'gravity_cms_autocomplete',
                ]
            )
            ->setRequired(
                [
                    'handler',
                ]
            )
            ->setAllowedTypes(
                [
                    'handler'         => 'string',
                    'limit'           => ['integer', 'null'],
                    'allow_new'       => 'bool',
                    'handler_options' => 'array',
                    'multiple'        => 'bool',
                ]
            );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $handler = $this->handlerManager->getHandler($options['handler']);

        $transformer = new AutoCompleteTransformer(
            $handler, $options['handler_options'], $options['allow_new'], $options['limit']
        );

        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $handler = $this->handlerManager->getHandler($options['handler']);

        if(!isset($view->vars['attr']['class'])){
            $view->vars['attr']['class'] = '';
        }

        $view->vars['attr']['class'] .= ' auto-complete-widget';
        $view->vars['attr']['data-multiple']  = $options['multiple'] ? 1 : 0;
        $view->vars['attr']['data-allow-new'] = $options['allow_new'] ? 1 : 0;
        $view->vars['attr']['data-url']       = $this->router->generate(
            $options['autocomplete_route'],
            [
                'type'    => $handler->getName(),
                'options' => $options['handler_options'],
            ]
        );

        if ($options['limit'] !== null || $options['limit'] > 0) {
            $view->vars['attr']['data-limit'] = $options['limit'];
        }
    }


    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'auto_complete';
    }
}
