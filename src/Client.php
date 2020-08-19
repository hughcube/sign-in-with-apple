<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2020/8/17
 * Time: 17:51
 */

namespace HughCube\SignInWithApple;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\RequestOptions as HttpRequestOptions;
use HughCube\SignInWithApple\Entity\AuthTokenResponse;
use HughCube\SignInWithApple\Entity\IdToken;

class Client
{
    protected $teamId;

    protected $clientId;

    protected $keyId;

    protected $privateKeyFile;

    protected $privateKey;

    protected $httpClient;

    /**
     * @var int
     */
    public $httpTimeout = 0;

    /**
     * @var int
     */
    public $httpConnectTimeout = 0;

    /**
     * @var string
     */
    public $httpBaseUrl = 'https://appleid.apple.com';

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
     * @retrun string
     */
    public function getClientSecret()
    {
        return $this->createClientSecret();
    }

    /**
     * @return string
     */
    protected function createClientSecret()
    {
        $token = (new JWT($this))->toString();

        return strval($token);
    }

    public function authCode($code, $redirectUri = null)
    {
        $results = $this->httpRequest(
            'POST',
            '/auth/token',
            [
                'client_id' => $this->clientId,
                'client_secret' => $this->getClientSecret(),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => null
            ]
        );

        return new AuthTokenResponse($results);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $body
     * @param array $options
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function httpRequest($method, $uri, array $body = [], array $options = [])
    {
        $options[HttpRequestOptions::FORM_PARAMS] = $body;

        return $this->getHttpClient()
            ->request($method, $uri, $options)
            ->getBody()
            ->getContents();
    }

    /**
     * @return HttpClientInterface
     */
    protected function getHttpClient()
    {
        if (!$this->httpClient instanceof HttpClientInterface) {
            $this->httpClient = new HttpClient(
                [
                    'base_uri' => $this->httpBaseUrl,
                    HttpRequestOptions::TIMEOUT => $this->httpTimeout,
                    HttpRequestOptions::CONNECT_TIMEOUT => $this->httpConnectTimeout,
                ]
            );
        }

        return $this->httpClient;
    }
}
