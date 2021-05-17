<?php
namespace Biotech\Models;

class BaseModel
{
    protected $id;

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
}