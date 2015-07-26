<?php

namespace Gravity\CmsBundle\Controller\Api;

use Gravity\CmsBundle\Search\Handler\HandlerInterface;
use Gravity\CmsBundle\Search\Handler\HandlerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AutoCompleteController
 *
 * @package Gravity\Component\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteController extends Controller
{
    public function autoCompleteAction(Request $request, $type)
    {
        /** @var HandlerManager $handlerManager */
        $handlerManager = $this->get('gravity_cms.search.handler_manager');

        $terms      = $request->query->get('q', null);
        $urlOptions = $request->query->get('options', array());

        $handler = $handlerManager->getHandler($type);

        if (!$handler instanceof HandlerInterface) {
            throw $this->createNotFoundException('Auto Complete Handler Not Found');
        }
        $options = $handler->getOptions($terms, $urlOptions);

        $response = new JsonResponse(array(
            'items' => $options,
            'page'  => 1
        ));

        return $response;
    }
}
