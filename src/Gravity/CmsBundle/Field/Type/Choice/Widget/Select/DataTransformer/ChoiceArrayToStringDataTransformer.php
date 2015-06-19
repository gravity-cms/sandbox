<?php


namespace Gravity\CmsBundle\Field\Type\Choice\Widget\Select\DataTransformer;

use Gravity\CoreBundle\Entity\FieldChoice;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class ChoiceArrayToStringDataTransformer
 *
 * @package Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ChoiceArrayToStringDataTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a string.
     * POSSIBLE LOSS OF DATA
     *
     * @param array $value
     *
     * @return array|string
     */
    public function transform($value)
    {
        if (count($value)) {
            return $value[0];
        } else {
            return null;
        }
    }

    /**
     * Transforms a string to an array.
     *
     * @param array $value
     *
     * @return array
     */
    public function reverseTransform($value)
    {
        if (!is_array($value) && $value !== null) {
            $value = [$value];
        }

        return $value;
    }
}
