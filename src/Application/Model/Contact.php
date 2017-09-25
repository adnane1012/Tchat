<?php
namespace Application\Model;

class Contact extends Entity
{
    protected $id;
    protected $user;
    protected $contact;
    protected $contactUser;

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contactUser
     */
    public function setContactUser($contactUser)
    {
        $this->contactUser = $contactUser;
    }

    /**
     * @return mixed
     */
    public function getContactUser()
    {
        return $this->contactUser;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}