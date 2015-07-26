<?php

namespace Gravity\CmsBundle\Search\Handler;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface HandlerInterface
 *
 * @package Gravity\CmsBundle\Search\Handler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface HandlerInterface
{
    /**
     * Get the name of the handler
     *
     * @return string
     */
    public function getName();

    /**
     * @param string $term
     * @param array  $options
     *
     * @return mixed
     */
    public function getOptions($term, array $options);

    /**
     * Parse a list of user-entered tags into a list of Tag objects
     *
     * @param array $tags
     * @param array $options
     *
     * @return array
     */
    public function getObjects(array $tags, array $options);

    /**
     * Set up the default options for the handler
     *
     * @param OptionsResolver $optionsResolver
     * @param array           $options
     *
     * @return mixed
     */
    public function setDefaults(OptionsResolver $optionsResolver, array $options = []);
}
