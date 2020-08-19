<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 18:44.
 */

namespace HughCube\SignInWithApple\Entity;

class User
{
    public $iss;

    public $aud;

    public $exp;

    public $iat;

    public $sub;

    public $at_hash;

    public $email;

    public $email_verified;

    public $auth_time;

    public $nonce_supported;

    /**
     * User constructor.
     *
     * @param array $claims
     */
    public function __construct(array $claims)
    {
        $this->fillProperties($claims);
    }

    /**
     * @param array $claims
     */
    protected function fillProperties(array $claims)
    {
        foreach ($claims as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getOpenid()
    {
        return $this->sub;
    }
}
