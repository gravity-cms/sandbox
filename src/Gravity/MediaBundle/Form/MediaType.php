<?php


namespace Gravity\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MediaType
 *
 * @package Gravity\MediaBundle\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('unlink');
    }

    /**
     * @inheritDoc
     */
    public function getName()    {
        return 'gravity_media_type';
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'sonata_media_type';
    }


}
