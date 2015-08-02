<?php


namespace Gravity\CmsBundle\Field\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Entity\Node;
use Gravity\CmsBundle\Field\FieldManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class AbstractFieldableAdmin
 *
 * @package Gravity\CmsBundle\Field\Admin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AbstractFieldableAdmin extends Admin
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @return FieldManager
     */
    public function getFieldManager()
    {
        return $this->fieldManager;
    }

    /**
     * @param FieldManager $fieldManager
     */
    public function setFieldManager($fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', ['class' => 'col-md-9'])->end()
            ->with('Publishing', ['class' => 'col-md-3'])->end()
            ->with('Routing', ['class' => 'col-md-3'])->end();

        $fieldMappings = $this->fieldManager->getEntityFieldMapping($this->getClass());

        $formMapper->with('Content');
        foreach ($fieldMappings as $field => $settings) {
            $fieldDefinition       = $this->fieldManager->getFieldDefinition($settings['type']);
            $fieldWidgetDefinition = $this->fieldManager->getFieldWidgetDefinition($settings['widget']['type']);

            $constraints = $fieldDefinition->getConstraints($field, $settings['options']);

            // TODO: deprecate dynamic
            if ($settings['dynamic']) {
                $fieldWidgetDefinition->configureForm(
                    $formMapper,
                    $fieldDefinition,
                    $field,
                    $settings['options'],
                    $settings['widget']['type'],
                    $settings['widget']['options']
                );

                $formMapper->getFormBuilder()->addEventListener(
                    FormEvents::POST_SET_DATA,
                    function (FormEvent $formEvent) use ($fieldDefinition, $field, $settings) {
                        $data = $formEvent->getData();

                        if ($data instanceof Node) {
                            $value = $data->{"get{$field}"}();
                            if (!$value || !count($value) && $settings['options']['limit'] == 1) {
                                $fieldClass = $fieldDefinition->getEntityClass();
                                if($fieldClass) {
                                    $data->{"set{$field}"}(new $fieldClass());
                                }
                            }
                        }
                    }
                );
            } else {
                $fieldWidgetDefinition->configureForm(
                    $formMapper,
                    $fieldDefinition,
                    $field,
                    $settings['options'],
                    $settings['widget']['type'],
                    $settings['widget']['options']
                );

                /** @var ClassMetadata $metadata */
                $metadata = $this->validator->getMetadataFactory()->getMetadataFor($this->getClass());

                foreach ($constraints as $constraintField => $constraint) {
                    $metadata->addPropertyConstraints($constraintField, $constraint);
                }
            }
        }
        $formMapper->end();

        $formMapper->end();
    }
}
