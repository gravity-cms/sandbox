<?php


namespace Gravity\CmsBundle\Serializer;

use Gravity\CmsBundle\Field\FieldManager;
use JMS\Serializer\Context;
use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;

/**
 * Class NodeExclusionStrategy
 *
 * @package Gravity\CmsBundle\Serializer
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeExclusionStrategy implements ExclusionStrategyInterface
{
    /**
     * @var FieldManager
     */
    private $fieldManager;

    /**
     * @var ExclusionStrategyInterface
     */
    private $otherStrategy;

    /**
     * NodeExclusionStrategy constructor.
     *
     * @param FieldManager               $fieldManager
     * @param ExclusionStrategyInterface $otherStrategy
     */
    public function __construct(FieldManager $fieldManager, ExclusionStrategyInterface $otherStrategy = null)
    {
        $this->fieldManager = $fieldManager;
        $this->otherStrategy = $otherStrategy;
    }

    /**
     * @inheritDoc
     */
    public function shouldSkipClass(ClassMetadata $metadata, Context $context)
    {
        if($this->fieldManager->hasEntityFieldMapping($metadata->name)){
            return false;
        }
        if($metadata->reflection->isSubclassOf('Gravity\CmsBundle\Entity\Field')){
            return false;
        }
        if($metadata->reflection->isSubclassOf('Gravity\CmsBundle\Entity\FieldableEntity')){
            return false;
        }
        if($metadata->reflection->implementsInterface('Symfony\Component\Security\Core\User\UserInterface')){
            return false;
        }

        return $this->otherStrategy->shouldSkipClass($metadata, $context);
    }

    /**
     * @inheritDoc
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $context)
    {
        if($property->reflection && $property->reflection->getDeclaringClass()->isSubclassOf('Gravity\CmsBundle\Entity\FieldableEntity')){
            return false;
        }

        return $this->otherStrategy->shouldSkipProperty($property, $context);
    }
}
