<?php

namespace App\Traits;

/**
 * Trait NameAttribute
 * @package App\Traits
 */
trait NameAttribute
{
    protected $en_name;
    protected $fr_name;

    /**
     * @return string
     */
    public function getEnName(): string
    {
        return $this->en_name;
    }

    /**
     * @param string $en_name
     * @return NameAttribute
     */
    public function setEnName(string $en_name): self
    {
        $this->en_name = $en_name;

        if (is_property_complete($this, 'slug')) {
            $this->setSlug($en_name);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFrName(): string
    {
        return $this->fr_name;
    }

    /**
     * @param string $fr_name
     * @return NameAttribute
     */
    public function setFrName(string $fr_name): self
    {
        $this->fr_name = $fr_name;

        return $this;
    }

    /**
     * @param string $lang
     * @return string
     */
    public function getName(string $lang = 'en'): string
    {
        $property = $lang . '_name';
        $getter = 'get' . ucfirst($lang) . 'Name';

        if (property_exists($this, $property)
            && method_exists($this, $getter)) {
            return $this->$getter();
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $lang
     * @return NameAttribute
     */
    public function setName(string $name, string $lang = 'en'): self
    {
        $property = $lang . '_name';
        $setter = 'set' . ucfirst($lang) . 'Name';

        if (property_exists($this, $property)
            && method_exists($this, $setter)) {
            $this->$setter($name);
        }

        return $this;
    }
}