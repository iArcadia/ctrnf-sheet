<?php

namespace App\Traits;

use App\DB;

/**
 * Trait IdAttribute
 * @package App\Traits
 */
trait IdAttribute
{
    protected $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return IdAttribute
     */
    public function setId(?int $id = null): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return IdAttribute
     */
    public function save(): self
    {
        $attributes = get_object_vars($this);
        unset($attributes['id']);

        $data = [];

        foreach ($attributes as $property => $value) {
            $data[':' . $property] = $value;
        }

        if ($this->getId()) {
            DB::update(static::$table, $this->getId(), array_keys($attributes), $data);
        } else {
            DB::insert(static::$table, array_keys($attributes), $data);

            $this->setId(DB::getLastInsertedId());
        }

        return $this;
    }

    /**
     * @return array
     */
    public static function get(): array
    {
        $data = DB::select(static::$table);

        $result = [];

        foreach ($data as $item) {
            $result[] = new static($item);
        }

        return $result;
    }

    /**
     * @param int $id
     * @return IdAttribute
     */
    public static function find(int $id): self
    {
        $data = DB::find(static::$table, $id);

        return new static($data);
    }
}