<?php

namespace App\Game;

use App\BaseObject;
use App\DB;
use App\Traits\IdAttribute;
use App\Traits\NameAttribute;
use App\Traits\SlugAttribute;

/**
 * Class Category
 * @package App\Game
 */
class Category extends BaseObject
{
    use IdAttribute, SlugAttribute, NameAttribute;

    protected static $table = 'categories';

    /**
     * @return array
     */
    public function getTracks(): array
    {
        $query = "
            SELECT
                *
            FROM
                tracks
            WHERE
                category_id = :category_id
        ";

        $data = [':category_id' => $this->getId()];

        $result = DB::execute($query, $data);

        foreach ($result as &$item) {
            $item = Track::build($item);
        }

        return $result;
    }
}