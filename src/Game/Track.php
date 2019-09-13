<?php

namespace App\Game;

use App\BaseObject;
use App\DB;
use App\Traits\IdAttribute;
use App\Traits\NameAttribute;
use App\Traits\SlugAttribute;
use App\Type\Time;

/**
 * Class Track
 * @package App\Game
 */
class Track extends BaseObject
{
    use IdAttribute, SlugAttribute, NameAttribute;

    protected static $table = 'tracks';

    protected $is_glitched = false;

    protected $tropy_time;
    protected $oxide_time;
    protected $master_time;
    protected $master_time_url;
    protected $wr_time;
    protected $wr_lap_time;
    protected $wr_time_character_id;
    protected $wr_lap_time_character_id;
    protected $wr_time_url;
    protected $wr_lap_time_url;

    protected $category_id;

    /**
     * @return bool
     */
    public function isGlitched(): bool
    {
        return $this->is_glitched;
    }

    /**
     * @param bool $is_glitched
     * @return Track
     */
    public function setIsGlitched(bool $is_glitched): self
    {
        $this->is_glitched = $is_glitched;

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getTropyTime(): ?Time
    {
        return ($this->tropy_time) ? Time::build($this->tropy_time) : null;
    }

    /**
     * @param $tropy_time
     * @return Track
     */
    public function setTropyTime($tropy_time): self
    {
        $this->tropy_time = $this->convertForTimeField($tropy_time);

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getOxideTime(): ?Time
    {
        return ($this->oxide_time) ? Time::build($this->oxide_time) : null;
    }

    /**
     * @param $oxide_time
     * @return Track
     */
    public function setOxideTime($oxide_time): self
    {
        $this->oxide_time = $this->convertForTimeField($oxide_time);

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getMasterTime(): ?Time
    {
        return ($this->master_time) ? Time::build($this->master_time) : null;
    }

    /**
     * @param $master_time
     * @return Track
     */
    public function setMasterTime($master_time): self
    {
        $this->master_time = $this->convertForTimeField($master_time);

        return $this;
    }

    /**
     * @return Time
     */
    public function getWrTime(): ?Time
    {
        return ($this->wr_time) ? Time::build($this->wr_time) : null;
    }

    /**
     * @param $wr_time
     * @return Track
     */
    public function setWrTime($wr_time): self
    {
        $this->wr_time = $this->convertForTimeField($wr_time);

        return $this;
    }

    /**
     * @return Time
     */
    public function getWrLapTime(): ?Time
    {
        return ($this->wr_lap_time) ? Time::build($this->wr_lap_time) : null;
    }

    /**
     * @param $wr_lap_time
     * @return Track
     */
    public function setWrLapTime($wr_lap_time): self
    {
        $this->wr_lap_time = $this->convertForTimeField($wr_lap_time);

        return $this;
    }

    /**
     * @return string
     */
    public function getMasterTimeUrl(): ?string
    {
        return $this->master_time_url;
    }

    /**
     * @param string $master_time_url
     * @return Track
     */
    public function setMasterTimeUrl(?string $master_time_url = null): self
    {
        $this->master_time_url = $master_time_url;

        return $this;
    }

    /**
     * @return string
     */
    public function getWrTimeUrl(): ?string
    {
        return $this->wr_time_url;
    }

    /**
     * @param string $wr_time_url
     * @return Track
     */
    public function setWrTimeUrl(?string $wr_time_url = null): self
    {
        $this->wr_time_url = $wr_time_url;

        return $this;
    }

    /**
     * @return string
     */
    public function getWrLapTimeUrl(): ?string
    {
        return $this->wr_lap_time_url;
    }

    /**
     * @param string $wr_lap_time_url
     * @return Track
     */
    public function setWrLapTimeUrl(?string $wr_lap_time_url = null): self
    {
        $this->wr_lap_time_url = $wr_lap_time_url;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWrTimeCharacterId(): ?int
    {
        return $this->wr_time_character_id;
    }

    /**
     * @param int|null $wr_time_character_id
     * @return Track
     */
    public function setWrTimeCharacterId(?int $wr_time_character_id = null): self
    {
        $this->wr_time_character_id = $wr_time_character_id;

        return $this;
    }

    /**
     * @return Character|null
     */
    public function getWrTimeCharacter(): ?Character
    {
        return Character::find($this->getWrTimeCharacterId());
    }

    /**
     * @return int|null
     */
    public function getWrLapTimeCharacterId(): ?int
    {
        return $this->wr_lap_time_character_id;
    }

    /**
     * @param int|null $wr_lap_time_character_id
     * @return Track
     */
    public function setWrLapTimeCharacterId(?int $wr_lap_time_character_id = null): self
    {
        $this->wr_lap_time_character_id = $wr_lap_time_character_id;

        return $this;
    }

    /**
     * @return Character|null
     */
    public function getWrLapTimeCharacter(): ?Character
    {
        return Character::find($this->getWrLapTimeCharacterId());
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     * @return Track
     */
    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return Category::find($this->getCategoryId());
    }

    /**
     * @return Track
     */
    public static function getTrackOfTheDay(): Track
    {
        $daily_seed = strtotime(date('Y-m-d')) / 100;
        $tracks = Track::get();

        return $tracks[$daily_seed % sizeof($tracks)];
    }

    /**
     * @param int $category_id
     * @param array $data
     * @return Track
     */
    public static function buildForCategory(int $category_id, array $data = []): Track
    {
        $data['category_id'] = $category_id;

        return static::build($data);
    }

    /**
     * @return TrackData|null
     */
    public function getData(): ?TrackData
    {
        $query = "
            SELECT
                *
            FROM
                track_data
            WHERE
                track_id = :track_id
        ";

        $data = DB::execute($query, ['track_id' => $this->getId()]);

        return ($data) ? TrackData::build($data[0]) : null;
    }

    /**
     * @param null $time
     * @return Time|string|int|null
     */
    protected function convertForTimeField($time = null): ?int
    {
        if (is_string($time)) {
            $time = Time::buildFromMSC($time);
        }

        if (is_a($time, Time::class)) {
            $time = $time->getTime();
        }

        return $time;
    }
}