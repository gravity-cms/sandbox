<?php


namespace Gravity\CmsBundle\Routing\Type;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;

/**
 * Class RouteTypeInterface
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
interface RouteTypeInterface
{
    /**
     * Check if the route is supported by this route type
     *
     * @param Route $route
     *
     * @return boolean
     */
    public function supportsRoute(Route $route);

    /**
     * Build the form to create/edit the route
     *
     * @param AdminInterface $admin
     * @param FormMapper     $formMapper
     *
     * @return void
     */
    public function buildForm(AdminInterface $admin, FormMapper $formMapper);
}
