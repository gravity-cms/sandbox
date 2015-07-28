<?php

namespace Gravity\CmsBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Gravity\CmsBundle\Form\DataTransformer\HiddenEntityIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class HiddenEntityIdType
 *
 * @package Gravity\CmsBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class HiddenEntityIdType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(
                [
                    'class',
                ]
            )
            ->setDefaults(
                [
                    'em' => $this->entityManager,
                ]
            )
            ->setAllowedTypes(
                [
                    'em' => 'Doctrine\Common\Persistence\ObjectManager',
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // this assumes that the entity manager was passed in as an option
        $entityManager = $options['em'];
        $dataClass     = $options['class'];
        $transformer   = new HiddenEntityIdTransformer($entityManager, $dataClass);

        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['entity'] = $form->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hidden_entity';
    }

}
