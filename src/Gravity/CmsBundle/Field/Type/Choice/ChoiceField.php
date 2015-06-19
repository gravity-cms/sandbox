<?php


namespace Gravity\CmsBundle\Field\Type\Choice;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Class ChoiceField
 *
 * @package Gravity\CmsBundle\Field\Type\Choice
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ChoiceField implements FieldDefinitionInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName()
    {
        return 'choice';
    }

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Choice list';
    }

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription()
    {
        return 'A list of pre-defined choices';
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\CmsBundle\Entity\FieldChoice';
    }

    /**
     * @param OptionsResolver $optionsResolver
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver
            ->setRequired(
                [
                    'choices'
                ]
            )
            ->setAllowedTypes('choices', 'array')
            ->setDefaults(
                [
                    'multiple' => false,
                ]
            );
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return array
     */
    public function getConstraints($name, array $options)
    {
        $constraints = [];

        if (!$options['multiple']) {
            $constraints[] = new Choice(
                [
                    'multiple' => true, // validators are run on normalised data, so set it to multiple
                    'choices'  => array_keys($options['choices']),
                ]
            );

            $constraints[] = new Count(
                [
                    'max' => 1
                ]
            );
        }

        return [
            'choice' => $constraints,
        ];
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
                'type'      => 'json_array',
                'nullable'  => false,
            ]
        );
    }
}
