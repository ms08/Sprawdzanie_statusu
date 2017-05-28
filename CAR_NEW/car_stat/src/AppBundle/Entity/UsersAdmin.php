<?php

namespace AppBundle\Entity;

/**
 * UsersAdmin
 */
class UsersAdmin
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return UsersAdmin
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return UsersAdmin
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return UsersAdmin
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public static function isAdminLogged($session, $db){
        $id = $session->get('adminID');
        if(empty($id))
            return false;

        $admin = $db->findOneById($id);

        if(empty($admin))
            return false;

        return true;
    }
    public static function getSaltedPassword($plainPass, $salt){
        return hash('sha256',$plainPass.$salt);
    }
}
