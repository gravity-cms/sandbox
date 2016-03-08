<?php


namespace Gravity\MenuBundle\Controller\Api;

use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Gravity\MenuBundle\Entity\Repository\MenuItemRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class MenuController
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class MenuController extends Controller implements ClassResourceInterface
{
    public function cgetAction(Request $request)
    {
        $adminCode = $request->get('_sonata_admin');

        if (!$adminCode) {
            throw new \RuntimeException(
                sprintf(
                    'There is no `_sonata_admin` defined for the controller `%s` and the current route `%s`',
                    get_class($this),
                    $request->get('_route')
                )
            );
        }

        $admin = $this->get('sonata.admin.pool')->getAdminByAdminCode($adminCode);

        if (false === $admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        /** @var MenuItemRepository $menuRepository */
        $menuRepository = $this->get('doctrine.orm.entity_manager')->getRepository('GravityMenuBundle:MenuItem');

        $menus = $menuRepository->findBy(
            [
                'parent' => null,
            ],
            null,
            20,
            0
        );
        $view  = new View($menus);
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        $context->setGroups(['gravity_api_read']);
        $view->setSerializationContext($context);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
