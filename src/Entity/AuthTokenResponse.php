<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 18:45
 */

namespace HughCube\SignInWithApple\Entity;


use InvalidArgumentException;

class AuthTokenResponse
{
    /**
     * @var string
     */
    public $access_token;

    /**
     * @var string
     */
    public $token_type;

    /**
     * @var string
     */
    public $expires_in;

    /**
     * @var string
     */
    public $refresh_token;

    /**
     * @var string
     */
    public $id_token;

    /**
     * AuthTokenResponse constructor.
     * @param $jsonString
     */
    public function __construct($jsonString)
    {
        $this->fillProperties($jsonString);
    }

    /**
     * @param $jsonString
     */
    protected function fillProperties($jsonString)
    {
        $results = json_decode($jsonString, true);
        if (empty($results['access_token'])) {
            throw new InvalidArgumentException();
        }

        foreach ($results as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * @return User
     */
    public function parseUser()
    {
        $claims = explode('.', $this->id_token)[1];
        $claims = json_decode(base64_decode($claims), true);

        return new User($claims);
    }
}
