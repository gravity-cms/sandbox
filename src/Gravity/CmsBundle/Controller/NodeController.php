<?php


namespace Gravity\CmsBundle\Controller;

use FOS\RestBundle\View\View;
use Gravity\CmsBundle\Serializer\NodeExclusionStrategy;
use JMS\Serializer\Exclusion\DisjunctExclusionStrategy;
use JMS\Serializer\Exclusion\GroupsExclusionStrategy;
use JMS\Serializer\Exclusion\VersionExclusionStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NodeController
 *
 * @package Gravity\CmsBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeController extends Controller
{
    public function viewAction(Request $request, $type, $nodeId)
    {
        $em   = $this->getDoctrine();
        $node = $em->getRepository($type)->findOneBy(
            [
                'id'        => $nodeId,
                'published' => true,
                'deletedOn' => null
            ]
        );

        if (!$node instanceof $type) {
            throw $this->createNotFoundException("Node '{$nodeId}' not found for type '{$type}'");
        }

        $format = $request->attributes->get('_format', 'html');

        if ($format === 'html') {
            $fieldManager  = $this->get('gravity_cms.field_manager');
            $fieldMappings = $fieldManager->getEntityFieldMapping(get_class($node));

//            foreach ($fieldMappings as $field => $settings) {
//                $fieldDefinition = $fieldManager->getFieldDefinition($settings['type']);
//                if ($settings['display']['type']) {
//                    $fieldDisplayDefinition = $fieldManager->getFieldDisplayDefinition($settings['display']['type']);
//                }
//            }

            return $this->render(
                'GravityCmsBundle:Node:view.html.twig',
                [
                    'node'           => $node,
                    'field_mappings' => $fieldMappings,
                ]
            );
        } else {
            $fieldManager = $this->get('gravity_cms.field_manager');

            $view                   = View::create($node);
            $context                = $view->getSerializationContext();
            $exclusionStrategyChain = new DisjunctExclusionStrategy(
                [
                    new GroupsExclusionStrategy(['gravity_api_read']),
                    new VersionExclusionStrategy('1.0'),
                ]
            );
            $context->addExclusionStrategy(new NodeExclusionStrategy($fieldManager, $exclusionStrategyChain));
            $context->setSerializeNull(true);

            return $this->get('fos_rest.view_handler')->handle($view, $request);
        }
    }

    public function redirectAction(Request $request, $type, $nodeId)
    {
        $em   = $this->getDoctrine();
        $node = $em->getRepository($type)->findOneBy(
            [
                'id'        => $nodeId,
                'published' => true,
                'deletedOn' => null
            ]
        );

        return $this->redirectToRoute(
            $node->getRoute()->getName(),
            [
                '_format' => $request->get('_format')
            ],
            301
        );
    }
}
