<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 18:45
 */

namespace HughCube\SignInWithApple\Entity;


class AuthTokenResponse
{
    public $access_token;

    public $token_type;

    public $expires_in;

    public $refresh_token;

    public $id_token;
}
