<?php

namespace App\Type;

/**
 * Class Time
 * @package App\Type
 */
class Time
{
    const MSC_PATTERN = '/(?:(\d?\d):)?([0-5]?\d)\.(\d{2})/';

    protected $time = null;

    /**
     * Time constructor.
     * @param int|null $time
     */
    public function __construct(?int $time = 0)
    {
        $this->setTime($time);
    }

    /**
     * @return int|null
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @param int|null $time
     * @return Time
     */
    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return int
     */
    public function getMilliseconds(): int
    {
        return $this->getTime() % 1000;
    }

    /**
     * @param int $ms
     * @return Time
     */
    public function addMilliseconds(int $ms): self
    {
        return $this->setTime($this->getTime() + $ms);
    }

    /**
     * @return int
     */
    public function getCentiseconds(): int
    {
        return floor($this->getTime() / 10 % 100);
    }

    /**
     * @param int $c
     * @return Time
     */
    public function addCentiseconds(int $c): self
    {
        return $this->setTime($this->getTime() + ($c * 10));
    }

    /**
     * @return int
     */
    public function getDeciseconds(): int
    {
        return floor($this->getTime() / 100 % 10);
    }

    /**
     * @param int $d
     * @return Time
     */
    public function addDeciseconds(int $d): self
    {
        return $this->setTime($this->getTime() + ($d * 100));
    }

    /**
     * @return int
     */
    public function getSeconds(): int
    {
        return floor($this->getTime() / 1000 % 60);
    }

    /**
     * @param int $s
     * @return Time
     */
    public function addSeconds(int $s): self
    {
        return $this->setTime($this->getTime() + ($s * 1000));
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return floor($this->getTime() / 60000 % 60);
    }

    /**
     * @param int $m
     * @return Time
     */
    public function addMinutes(int $m): self
    {
        return $this->setTime($this->getTime() + ($m * 60000));
    }

    /**
     * @return string
     */
    public function formatMSC(): string
    {
        $m = $this->getMinutes();
        $s = str_pad($this->getSeconds(), 2, '0', STR_PAD_LEFT);
        $c = str_pad($this->getCentiseconds(), 2, '0', STR_PAD_LEFT);

        return ($m > 0) ? $m . ':' . $s . '.' . $c : $s . '.' . $c;
    }

    /**
     * @param Time $b
     * @return Time
     */
    public function getDiff(Time $b): Time
    {
        return Time::getDiffBetween($this, $b);
    }

    /**
     * @param Time $a
     * @param Time $b
     * @return Time
     */
    public static function getDiffBetween(Time $a, Time $b): Time
    {
        $greater = ($a->getTime() > $b->getTime()) ? $a : $b;
        $lower = ($greater->getTime() === $a->getTime()) ? $b : $a;

        return Time::build($greater->getTime() - $lower->getTime());
    }

    /**
     * @param int|null $time
     * @return Time
     */
    public static function build(?int $time = 0): Time
    {
        return new self($time);
    }

    /**
     * @param string $msc
     * @return Time
     */
    public static function buildFromMSC(string $msc): Time
    {
        $time = self::build();

        if (preg_match(self::MSC_PATTERN, $msc, $matches)) {
            $m = (int)$matches[1] ?? 0;
            $s = (int)$matches[2];
            $c = (int)$matches[3];

            $time->addCentiseconds($c);
            $time->addSeconds($s);
            $time->addMinutes($m);
        }

        return $time;
    }
}