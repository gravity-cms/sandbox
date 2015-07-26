<?php


namespace Gravity\CmsBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\CmsBundle\Search\Handler\HandlerInterface;
use Gravity\TagBundle\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;

class AutoCompleteTransformer implements DataTransformerInterface
{
    /**
     * Auto complete Handler
     *
     * @var HandlerInterface
     */
    private $handler;

    /**
     * Allow new data objects
     *
     * @var bool
     */
    protected $allowNew;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var int
     */
    protected $limit;

    /**
     * @param HandlerInterface $handler
     * @param array            $options
     * @param boolean          $allowNew
     * @param int              $limit
     */
    public function __construct(HandlerInterface $handler, array $options, $allowNew, $limit)
    {
        $this->handler  = $handler;
        $this->allowNew = $allowNew;
        $this->options  = $options;
        $this->limit    = $limit;
    }

    /**
     * Transforms the Document's value to a value for the form field
     */
    public function transform($tags)
    {
        if($this->limit == 1){
            return (string) $tags;
        } else {
            /** @var Tag[] $tags */
            if (!$tags) {
                $tags = []; // default value
            }

            $tagNames = [];
            foreach ($tags as $tag) {
                $tagNames[$tag->getId()] = (string) $tag;
            }

            return json_encode($tagNames);
        }
    }

    /**
     * Transforms the value the users has typed to a value that suits the field in the Document
     */
    public function reverseTransform($tags)
    {
        $tagEntities = new ArrayCollection();

        if (!$tags) {
            return $tagEntities;
        }

        $parsedTags = array_filter(array_map('trim', explode(',', $tags)));

        $objects     = $this->handler->getObjects($parsedTags, $this->options);
        $objectCount = count($objects);

        if ($this->limit == 1) {
            if ($objectCount) {
                return reset($objects);
            } else {
                return null;
            }
        } else {
            $fieldObjects = [];
            for ($i = 0; $i < $objectCount ; ++$i){
                $fieldObjects[] = $objects[$i];
            }

            return $fieldObjects;
        }
    }
}
