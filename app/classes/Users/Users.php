<?php


namespace App\Users;


class Users
{
    // params declaration

    private $properties = [
        'username',
        'email',
        'password',
        'timestamp',
    ];
    private $username, $email, $password, $timestamp;

    // construct

    public function __construct(array $data = null)
    {
        if ($data) $this->setData($data);

    }


    //setters


    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }


    // getters


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    // set get multiple data

    /*
     * [
     * 'username' => 'jonas',
     * 'password' => 'asdasdasd',
     * ]
     */

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        foreach ($data as $index => $value) {
            foreach ($this->properties as $property) {
                if ($index === $property) {
                    $this->{'set' . $property}($value);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getData() {
        $ret = [];

        foreach ($this->properties as $property) {
            $ret[$property] = $this->{'get' . $property}();
        }

        return $ret;
    }
}