<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 17:51
 */

namespace HughCube\SignInWithApple;


class Client
{
    protected $teamId;

    protected $clientId;

    protected $keyId;

    protected $privateKeyFile;

    protected $privateKey;

    /**
     * @return mixed
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param mixed $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getKeyId()
    {
        return $this->keyId;
    }

    /**
     * @param mixed $keyId
     */
    public function setKeyId($keyId)
    {
        $this->keyId = $keyId;
    }

    /**
     * @return mixed
     */
    public function getPrivateKeyFile()
    {
        return $this->privateKeyFile;
    }

    /**
     * @param mixed $privateKeyFile
     */
    public function setPrivateKeyFile($privateKeyFile)
    {
        $this->privateKeyFile = $privateKeyFile;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param mixed $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param integer $exp
     * @param null|integer $time
     * @retrun string
     */
    public function getClientSecret($exp)
    {
        return $this->createClientSecret($exp);
    }

    /**
     * @param integer $exp
     * @param null|integer $time
     * @retrun string
     */
    protected function createClientSecret($exp)
    {
        $token = (new JWT($this, $exp))->toString();

        return strval($token);
    }
}
