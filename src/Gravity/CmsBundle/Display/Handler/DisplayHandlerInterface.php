<?php


namespace Gravity\CmsBundle\Display\Handler;

use Gravity\CmsBundle\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface DisplayHandlerInterface
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
interface DisplayHandlerInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param OptionsResolver $optionsResolver
     * @param array           $options
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver, array $options = []);

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supportsRequest(Request $request);

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param Node  $node
     * @param array $options
     *
     * @return array
     */
    public function getTemplateOptions(Node $node, array $options = []);
}
