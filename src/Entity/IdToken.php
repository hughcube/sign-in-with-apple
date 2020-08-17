<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 18:35
 */

namespace HughCube\SignInWithApple\Entity;


class IdToken
{
    /**
     * JWT constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }
}
