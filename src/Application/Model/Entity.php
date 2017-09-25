<?php
namespace Application\Model;

class Entity
{
    protected $tableName = '';

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        if ($this->tableName) {
            return $this->tableName;
        }

        $fullName = explode('\\', get_class($this));
        return strtolower(array_pop($fullName));
    }

    public function getParamettersnames()
    {
        return get_object_vars($this);
    }
}
