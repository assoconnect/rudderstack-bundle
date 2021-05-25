<?php

namespace AssoConnect\RudderstackBundle\Configuration;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Required;

class Page implements AnalyticsInterface
{

    /**
     * @Required
     *
     * @var string
     */
    public $category;

    /**
     * @Required
     *
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $properties = [];


    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return [
            'name' => $this->name,
            'category' => $this->category,
            'properties' => $this->properties,
        ];
    }
}
