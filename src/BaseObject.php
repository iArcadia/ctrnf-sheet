<?php

namespace App;

/**
 * Class BaseObject
 * @package App
 */
class BaseObject
{
    /**
     * BaseObject constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->__fill($data);
    }

    /**
     * @param array $data
     * @return BaseObject
     */
    public function __fill(array $data = []): self
    {
        foreach ($data as $key => $value) {
            if (is_property_complete($this, $key)) {
                $setter = get_setter($this, $key);

                if (preg_match('/^\d+$/', $value)) {
                    $value = (int)$value;
                }

                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * @param array $data
     * @return BaseObject
     */
    public static function build(array $data = [])
    {
        return new static($data);
    }
}