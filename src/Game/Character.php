<?php

namespace App\Game;

use App\BaseObject;
use App\Traits\IdAttribute;
use App\Traits\NameAttribute;
use App\Traits\SlugAttribute;

class Character extends BaseObject
{
    use IdAttribute, SlugAttribute, NameAttribute;

    protected static $table = 'characters';

    const CLASS_BALANCED = 1;
    const CLASS_ACCELERATION = 2;
    const CLASS_TURN = 3;
    const CLASS_SPEED = 4;

    protected $class = self::CLASS_BALANCED;

    /**
     * @return int
     */
    public function getClass(): int
    {
        return $this->class;
    }

    /**
     * @param int $class
     * @return Character
     */
    public function setClass(int $class): self
    {
        $this->class = $class;

        return $this;
    }
}