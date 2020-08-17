<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 17:59
 */

namespace HughCube\SignInWithApple;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;

class JWT
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Token
     */
    protected $token;

    /**
     * JWT constructor.
     * @param $client
     */
    public function __construct($client, $exp = 3600)
    {
        $this->client = $client;
    }

    /**
     * 获取key
     *
     * @return Key
     */
    public function getKey()
    {
        $content = $this->client->getPrivateKey();
        if (empty($content)) {
            $content = sprintf('file://%s', $this->client->getPrivateKeyFile());
        }

        return new Key($content);
    }

    /**
     * @return Signer
     */
    public function getSigner()
    {
        return new Sha256();
    }



    /**
     * @param int $expires
     * @return Token
     */
    public function createToken($exp = 3600)
    {
        $signer = $this->getSigner();
        $time = time();
        $key = $this->getKey();

        return (new Builder())
            ->issuedBy($this->client->getTeamId())
            ->issuedAt($time)
            ->expiresAt($time + $exp)
            ->permittedFor('https://appleid.apple.com')
            ->relatedTo($this->client->getClientId())
            ->withHeader('alg', 'ES256')
            ->withHeader('kid', $this->client->getKeyId())
            ->getToken($signer, $key);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return strval($this);
    }
}
