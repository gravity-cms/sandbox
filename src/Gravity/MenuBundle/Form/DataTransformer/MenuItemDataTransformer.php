<?php


namespace Gravity\MenuBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class MenuItemDataTransformer
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuItemDataTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        return $value;
    }

}
