<?php


namespace Gravity\CmsBundle\Field\Type\Text;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gravity\CmsBundle\Field\FieldDefinitionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class TextField
 *
 * @package Gravity\CmsBundle\Field\Type\Text
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextField implements FieldDefinitionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Gravity\CmsBundle\Entity\FieldText';
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'char_min' => null,
                'char_max' => null,
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
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function configureField(EntityManager $entityManager, ClassMetadata $metadata, $name, array $options = [])
    {
        throw new \Exception("deprecated call");
    }



    /**
     * {@inheritdoc}
     */
    public function getConstraints($field, array $options)
    {
        $constraints = [];
        if ($options['char_min'] !== null || $options['char_max'] !== null) {
            $constraints[] = new Length(
                [
                    'max' => $options['char_max'],
                    'min' => $options['char_min']
                ]
            );
        }

        return [
            'text' => $constraints
        ];
    }
}
