<?php


namespace Gravity\CmsBundle\Field\Type\Number;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Class NumberField
 *
 * @package Gravity\CmsBundle\Field\Type\Number
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NumberField implements FieldDefinitionInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'number';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Number';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A numerical field';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CmsBundle\Entity\FieldNumber';
    }


    /**
     * @param OptionsResolver $optionsResolver
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'accuracy' => 1,
                'min'      => null,
                'max'      => null,
                'step'     => null,
            ]
        );
    }

    /**
     * Configure the ORM field mapping
     *
     * @param EntityManager $entityManager
     * @param ClassMetadata $metadata
     * @param string        $name
     * @param array         $options
     *
     * @return mixed
     */
    public function configureField(EntityManager $entityManager, ClassMetadata $metadata, $name, array $options = [])
    {
        $metadata->mapField(
            [
                'fieldName' => $name,
                'type'      => 'integer',
            ]
        );
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getConstraints($field, array $options)
    {
        $constraints = [];
        if ($options['min'] !== null && $options['max'] !== null) {
            $constraints[] = new Range(
                [
                    'min' => $options['min'],
                    'max' => $options['max']
                ]
            );
        } else {
            if ($options['min'] !== null) {
                $constraints[] = new GreaterThanOrEqual($options['min']);
            }
            if ($options['max'] !== null) {
                $constraints[] = new LessThanOrEqual($options['max']);
            }
        }

        return [
            'number' => $constraints
        ];
    }
}
