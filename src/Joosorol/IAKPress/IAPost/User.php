<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;

/**
 * Description of User
 *
 * @author bly
 */
class User {
    private string $username;
    private string $email;
    private bool $isLoggedIn;
    private string $role;

   /**
     * Constructor
     */
    public function __construct(string $username, string $email, bool $isLoggedIn = false, $role = '') {
        $this->username = $username;
        $this->email = $email;
        $this->isLoggedIn = $isLoggedIn;
        $this->role = $role;
    }

    

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of isLoggedIn
     */ 
    public function getIsLoggedIn()
    {
        return $this->isLoggedIn;
    }

    /**
     * Set the value of isLoggedIn
     *
     * @return  self
     */ 
    public function setIsLoggedIn($isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function toArray() : array {
        return [
            Option::USERNAME => $this->username,
            Option::EMAIL => $this->email,
            Option::USER_LOGGED_IN => $this->isLoggedIn,
            Option::USER_ROLE => $this->role
        ];
    }
}