<?php

namespace App\Game;

use App\BaseObject;
use App\Traits\IdAttribute;
use App\Type\Time;

class TrackData extends BaseObject
{
    use IdAttribute;

    protected static $table = 'track_data';

    protected $console_rank = null;
    protected $best_time = null;
    protected $best_lap_time = null;
    protected $best_first_lap_time = null;
    protected $lap_1_time = null;
    protected $lap_2_time = null;
    protected $lap_3_time = null;

    protected $best_time_character_id = null;
    protected $best_lap_time_character_id = null;
    protected $track_id;

    /**
     * @return int|null
     */
    public function getConsoleRank(): ?int
    {
        return $this->console_rank;
    }

    /**
     * @param int|null $console_rank
     * @return TrackData
     */
    public function setConsoleRank(?int $console_rank = null): self
    {
        $this->console_rank = $console_rank;

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getBestTime(): ?Time
    {
        return ($this->best_time !== null) ? Time::build($this->best_time) : null;
    }

    /**
     * @param Time|int|string|null $best_time
     * @return TrackData
     */
    public function setBestTime($best_time = null): self
    {
        $this->best_time = $this->convertForTimeField($best_time);

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getBestLapTime(): ?Time
    {
        return ($this->best_lap_time !== null) ? Time::build($this->best_lap_time) : null;
    }

    /**
     * @param Time|string|int|null $best_lap_time
     * @return TrackData
     */
    public function setBestLapTime($best_lap_time = null): self
    {
        $this->best_lap_time = $this->convertForTimeField($best_lap_time);

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getBestFirstLapTime(): ?Time
    {
        return ($this->best_first_lap_time !== null) ? Time::build($this->best_first_lap_time) : null;
    }

    /**
     * @param Time|string|int|null $best_first_lap_time
     * @return TrackData
     */
    public function setBestFirstLapTime($best_first_lap_time = null): self
    {
        $this->best_first_lap_time = $this->convertForTimeField($best_first_lap_time);

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getLap1Time(): ?Time
    {
        return ($this->lap_1_time !== null) ? Time::build($this->lap_1_time) : null;
    }

    /**
     * @param Time|string|int|null $lap_1_time
     * @return TrackData
     */
    public function setLap1Time($lap_1_time = null): self
    {
        $this->lap_1_time = $this->convertForTimeField($lap_1_time);

        if (($this->getBestFirstLapTime()
                && $this->lap_1_time
                && $this->lap_1_time < $this->getBestFirstLapTime()->getTime())
            || !$this->getBestFirstLapTime()) {
            $this->setBestFirstLapTime($this->lap_1_time);
        }

        if (($this->getBestLapTime()
                && $this->lap_1_time
                && $this->lap_1_time < $this->getBestLapTime()->getTime())
            || !$this->getBestLapTime()) {
            $this->setBestLapTime($this->lap_1_time);
        }

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getLap2Time(): ?Time
    {
        return ($this->lap_2_time !== null) ? Time::build($this->lap_2_time) : null;
    }

    /**
     * @param Time|string|int|null $lap_2_time
     * @return TrackData
     */
    public function setLap2Time($lap_2_time = null): self
    {
        $this->lap_2_time = $this->convertForTimeField($lap_2_time);

        if (($this->getBestLapTime()
                && $this->lap_2_time
                && $this->lap_2_time < $this->getBestLapTime()->getTime())
            || !$this->getBestLapTime()) {
            $this->setBestLapTime($this->lap_2_time);
        }

        return $this;
    }

    /**
     * @return Time|null
     */
    public function getLap3Time(): ?Time
    {
        return ($this->lap_3_time !== null) ? Time::build($this->lap_3_time) : null;
    }

    /**
     * @param Time|string|int|null $lap_3_time
     * @return TrackData
     */
    public function setLap3Time($lap_3_time = null): self
    {
        $this->lap_3_time = $this->convertForTimeField($lap_3_time);

        if (($this->getBestLapTime()
                && $this->lap_3_time
                && $this->lap_3_time < $this->getBestLapTime()->getTime())
            || !$this->getBestLapTime()) {
            $this->setBestLapTime($this->lap_3_time);
        }

        return $this;
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

    /**
     * @return bool
     */
    public function allTimeFieldsAreCoherents(): bool
    {
        $best_time = $this->getBestTime();
        $best_lap_time = $this->getBestLapTime();
        $best_first_lap_time = $this->getBestFirstLapTime();
        $lap_times = [
            1 => $this->getLap1Time(),
            2 => $this->getLap2Time(),
            3 => $this->getLap3Time()
        ];


        if ($best_time && $lap_times[1] && $lap_times[2] && $lap_times[3]) {
            $total_lap_times = $lap_times[1]->getTime() + $lap_times[2]->getTime() + $lap_times[3]->getTime();

            if (($total_lap_times - 2) >= $best_time->getTime() && $best_time->getTime() <= $total_lap_times) {
                return false;
            }
        }

        if ($best_first_lap_time && $lap_times[1]) {
            if ($lap_times[1]->getTime() < $best_first_lap_time->getTime()) {
                return false;
            }
        }

        foreach ($lap_times as $lap_time) {
            if ($best_lap_time && $lap_time) {
                if ($lap_time->getTime() < $best_lap_time->getTime()) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return int|null
     */
    public function getBestTimeCharacterId(): ?int
    {
        return $this->best_time_character_id;
    }

    /**
     * @param int|null $best_time_character_id
     * @return TrackData
     */
    public function setBestTimeCharacterId(?int $best_time_character_id = null): self
    {
        $this->best_time_character_id = $best_time_character_id;

        return $this;
    }

    /**
     * @return Character|null
     */
    public function getBestTimeCharacter(): ?Character
    {
        return Character::find($this->getBestTimeCharacterId());
    }

    /**
     * @return int|null
     */
    public function getBestLapTimeCharacterId(): ?int
    {
        return $this->best_lap_time_character_id;
    }

    /**
     * @param int|null $best_lap_time_character_id
     * @return TrackData
     */
    public function setBestLapTimeCharacterId(?int $best_lap_time_character_id = null): self
    {
        $this->best_lap_time_character_id = $best_lap_time_character_id;

        return $this;
    }

    /**
     * @return Character|null
     */
    public function getBestLapTimeCharacter(): ?Character
    {
        return Character::find($this->getBestLapTimeCharacterId());
    }

    /**
     * @return int
     */
    public function getTrackId(): int
    {
        return $this->track_id;
    }

    /**
     * @param int $track_id
     * @return TrackData
     */
    public function setTrackId(int $track_id): self
    {
        $this->track_id = $track_id;

        return $this;
    }

    /**
     * @return Track
     */
    public function getTrack(): Track
    {
        return Track::find($this->getTrackId());
    }

    /**
     * @param int $track_id
     * @param array $data
     * @return TrackData
     */
    public static function buildForTrack(int $track_id, array $data = []): TrackData
    {
        $data['track_id'] = $track_id;

        return static::build($data);
    }

    /**
     * @return Time
     */
    public function getTheoricTime(): Time
    {
        $time = Time::build();

        if ($this->getBestFirstLapTime() && $this->getBestLapTime()) {
            $time->addMilliseconds($this->getBestFirstLapTime()->getTime());
            $time->addMilliseconds($this->getBestLapTime()->getTime() * 2);
        }

        return $time;
    }

    /**
     * @return array
     */
    public function getTheoricTimeInterval(): array
    {
        $times = [
            Time::build(),
            Time::build()
        ];

        if ($this->getBestFirstLapTime() && $this->getBestLapTime()) {
            $times[0]->addMilliseconds($this->getBestFirstLapTime()->getTime());
            $times[0]->addMilliseconds($this->getBestLapTime()->getTime() * 2);

            $times[1]->addMilliseconds($this->getBestFirstLapTime()->getTime() + 9);
            $times[1]->addMilliseconds(($this->getBestLapTime()->getTime() + 9) * 2);
        }

        return $times;
    }
}