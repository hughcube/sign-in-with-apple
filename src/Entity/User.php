<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 18:44
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
}
