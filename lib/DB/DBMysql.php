<?php

namespace DB;

use Application\Model\Contact;
use Application\Model\User;

class DBMysql
{
    static private $instance = null;

    public function connect()
    {
        try {
            self::$instance = new \PDO('mysql:host=' . HOST . ';dbname=' . BASE . '', '' . USER . '', '' . PASS . '');
        } catch (PDOException $e) {
            die("erreur de connexion");
        }
        return self::$instance;
    }

    public function disconnect()
    {

    }

    public function insert($data)
    {
        $sql = "INSERT INTO {{ TABLE }} ({{ FIELDS }}) VALUES ({{ VALUES }})";

        $table = $data->getTableName();
        foreach (get_class_methods($data) as $method) {
            if (substr($method, 0, 12) == 'getTableName')
                continue;
            if (substr($method, 0, 19) == 'getParamettersnames')
                continue;
            if (substr($method, 0, 3) != 'get')
                continue;
            if (is_null($data->{$method}()))
                continue;
            $field = self::getFieldNameFromMethod($method);
            $fields[] = $field;
            $values[] = "'" . $data->{$method}() . "'";
        }

        $fields_string = implode(',', $fields);
        $values_string = implode(',', $values);
        $sql = str_replace(
            array('{{ TABLE }}', '{{ FIELDS }}', '{{ VALUES }}'), compact('table', 'fields_string', 'values_string'), $sql
        );
        $cn = $this->connect();
        return $cn->exec($sql);
    }

    public function update($data)
    {
        $sql = "update {{ TABLE }} SET {{ FIELDS_VALUES }} WHERE id={{ ID }}";
        $table = $data->getTableName();

        foreach (get_class_methods($data) as $method) {
            if (substr($method, 0, 3) != 'get')
                continue;
            if (is_null($data->{$method}()))
                continue;
            $field = self::getFieldNameFromMethod($method);
            $fields_values[] = $field . "='" . $data->{$method}() . "'";
        }
        $fields_values_string = implode(', ', $fields_values);
        $id = $data->getId();
        $sql = str_replace(
            array('{{ TABLE }}', '{{ FIELDS_VALUES }}', '{{ ID }}'), compact('table', 'fields_values_string', 'id'), $sql
        );
        $cn = $this->connect();
        return $cn->exec($sql);
    }

    public function save($data)
    {
        $id = $data->getId();
        if (!empty($id))
            return self::update($data);
        else
            return self::insert($data);
        return -1;

    }

    public function fetchAll($data)
    {
        $sql = "SELECT * FROM {{ TABLE }}";
        $table = $data->getTableName();
        $sql = str_replace('{{ TABLE }}', $table, $sql);
        $cn = $this->connect();
        $items = array();
        foreach ($cn->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $current_class = get_class($data);
            $object = new $current_class;
            foreach ($item as $field => $value) {
                $method = self::getMethodFromFieldName($field);
                $object->{$method}($value);
            }
            $items[] = $object;
        }
        return $items;
    }

    public function findById(&$data)
    {
        self::findBy($data, array('id' => $data->getId()));
    }

    public function findBy(&$data, $criteria)
    {
        $sql = "SELECT * FROM {{ TABLE }} {{ WHERE }}";
        $table = $data->getTableName();
        $where = [];
        $or = [];

        foreach ($criteria as $field => $value){
            if(is_array($value) && $field == 'OR'){
                foreach($value as $field2 => $value2){
                    $or[] = $field2 . '="' . $value2 . '"';
                }

            }else{
                $where[] = $field . '="' . $value . '"';
            }
        }
        $where = implode(' AND ', $where);
        $or = implode(' AND ', $or);

        if (!empty($where)){
            $where = 'WHERE '.$where;
        }
        if (!empty($or)){
            $where .= ' OR  '.$or;
        }

        $sql = str_replace(array('{{ TABLE }}', '{{ WHERE }}'), array($table, $where), $sql);
        $cn = $this->connect();
        $items = array();
        $class = get_class($data);

        foreach ($cn->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $data_ = new $class;
            foreach ($item as $field => $value) {
                $method = self::getMethodFromFieldName($field);
                $data_->{$method}($value);
            }
            $items[] = $data_;
        }
        return $items;
    }

    public function delete($data)
    {
        $sql = "DELETE FROM {{ TABLE }} WHERE id={{ ID }}";

        if (!is_numeric($data->getId())) {
            throw new \RuntimeException('ID must be a number');
        }

        $table = $data->getTableName();
        $id = $data->getId();

        $sql = str_replace(array('{{ TABLE }}', '{{ ID }}'), array($table, $id), $sql);
        $cn = $this->connect();
        return $cn->exec($sql);
    }

    static function getFieldNameFromMethod($field) {
        return lcfirst(substr($field, 3, strlen($field)));
    }
    static function getMethodFromFieldName($field, $type = 'set') {
        return $type . ucfirst($field);
    }

    public function findContactsBy($contact,$user, $criteria)
    {
        $sql = "SELECT c.*, u.id as idUser, u.username FROM {{ TABLE }} as c LEFT JOIN user u on c.contact = u.id {{ WHERE }} group by c.contact ";
        $table = $contact->getTableName();
        $where = [];

        foreach ($criteria as $field => $value)
            $where[] = $field . '="' . $value . '"';
        $where = implode('AND', $where);

        if (!empty($where)){
            $where = 'WHERE '.$where;
        }
        $sql = str_replace(array('{{ TABLE }}', '{{ WHERE }}'), array($table, $where), $sql);

        $cn = $this->connect();
        $items = array();

        foreach ($cn->query($sql)->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            /** @var User $user_ */
            $user_= clone $user;
            $user_->setId($item['idUser']);
            $user_->setUsername($item['username']);

            /** @var Contact $contact */
            $contact_ = clone $contact;
            $contact_->setId($item['id']);
            $contact_->setUser($item['user']);
            $contact_->setContactUser($user_);


            $items[] = $contact_;
        }
        return $items;
    }
}
