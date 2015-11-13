<?php


namespace Gravity\CmsBundle\Controller;

use FOS\RestBundle\View\View;
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

        $view = View::create($node);

        return $this->get('fos_rest.view_handler')->handle($view, $request);
    }
}
