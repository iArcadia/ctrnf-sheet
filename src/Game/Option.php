<?php

namespace App\Game;

use App\BaseObject;
use App\DB;
use App\Traits\IdAttribute;
use App\Traits\SlugAttribute;

/**
 * Class Option
 * @package App\Game
 */
class Option extends BaseObject
{
    use IdAttribute, SlugAttribute;

    protected static $table = 'options';

    protected $value;

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return Option
     */
    public function setValue(?string $value = null): self
    {
        $this->value = $value;

        return $this;
    }
}