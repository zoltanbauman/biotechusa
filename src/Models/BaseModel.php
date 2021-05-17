<?php
namespace Biotech\Models;

use DateTime;

class BaseModel
{
    protected $id;
    protected static $date;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BaseModel
     */
    public function setId(int $id): BaseModel
    {
        $this->id = $id;
        return $this;
    }

    public function getDate(?string $time = null): DateTime
    {
        return static::$date ?: new DateTime($time);
    }

    public static function setDate(string $time)
    {
        static::$date = new DateTime($time);
    }
}