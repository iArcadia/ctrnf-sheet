<?php

namespace App\Traits;

use App\DB;

trait SlugAttribute
{
    protected $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return SlugAttribute
     */
    public function setSlug(string $slug): self
    {
        $this->slug = string_to_slug($slug);

        return $this;
    }

    /**
     * @param string $slug
     * @return SlugAttribute|null
     */
    public static function findBySlug(string $slug): ?self
    {
        $table = static::$table;

        $data = DB::execute("
            SELECT
                *
            FROM
                $table
            WHERE
                slug = :slug
        ", [':slug' => $slug]);

        return ($data) ? new static($data[0]) : null;
    }
}