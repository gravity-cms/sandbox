<?php


namespace Gravity\CmsBundle\Display\Twig;

use Gravity\CmsBundle\Display\DisplayManager;
use Gravity\CmsBundle\Entity\FieldableEntity;
use Gravity\CmsBundle\Field\FieldManager;

/**
 * Class DisplayExtension
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class DisplayExtension extends \Twig_Extension
{
    /**
     * @var DisplayManager
     */
    protected $displayManager;

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * FieldExtension constructor.
     *
     * @param DisplayManager $displayManager
     * @param FieldManager   $fieldManager
     */
    public function __construct(DisplayManager $displayManager, FieldManager $fieldManager)
    {
        $this->displayManager = $displayManager;
        $this->fieldManager   = $fieldManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_cms_display';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'render_field_display', [$this, 'renderFieldDisplay'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @param FieldableEntity   $entity
     * @param string            $field
     *
     * @return string
     * @internal param \Twig_Environment $environment
     */
    public function renderFieldDisplay(\Twig_Environment $environment, FieldableEntity $entity, $field)
    {
        $class          = get_class($entity);
        $displayMapping = $this->displayManager->getNodeConfig($class);
        $fieldSettings  = $this->fieldManager->getEntityFieldMapping($class);

        $html = '';

        if ($displayMapping['options']['fields'][$field]) {
            $displayFieldSettings = $displayMapping['options']['fields'][$field] + [
                    'type'         => null,
                    'label'        => true,
                    'label_inline' => false,
                    'options'      => [],
                ];
            $display              = $this->displayManager->getDisplayDefinition($displayFieldSettings['type']);
            $fieldEntity          = call_user_func([$entity, 'get' . $field]);
            $fieldDisplayOptions  = $displayFieldSettings['options'] ?: [];

            $templateOptions = [
                'entity'         => $fieldEntity,
                'field_settings' => $fieldSettings,
                'field_name'     => $field,
                'label'          => is_string(
                    $displayFieldSettings['label']
                ) ?: ($displayFieldSettings['label'] ? $field : false),
                'label_inline'   => $displayFieldSettings['label_inline'],
            ];

            if ($fieldSettings[$field]['options']['limit'] > 1) {
                $subHtml = '';

                $subTemplateOptions          = $templateOptions;
                $subTemplateOptions['label'] = false;
                foreach ($fieldEntity as $fieldEntityItem) {
                    $subHtml .= $environment->render(
                        $display->getTemplate(),
                        $subTemplateOptions +
                        $display->getTemplateOptions($fieldEntityItem, $fieldDisplayOptions)
                    );
                }

                $templateOptions['rows'] = $subHtml;
                $html                    = $environment->render(
                    $display->getListTemplate(),
                    $templateOptions +
                    $display->getListTemplateOptions($fieldEntity, $fieldDisplayOptions)
                );
            } else {
                $html = $environment->render(
                    $display->getTemplate(),
                    $templateOptions + $display->getTemplateOptions($fieldEntity, $fieldDisplayOptions)
                );
            }
        }

        return $html;
    }
}
