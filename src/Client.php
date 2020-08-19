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
     * @param integer $exp
     * @param null|integer $time
     * @retrun string
     */
    public function getClientSecret()
    {
        return $this->createClientSecret();
    }

    /**
     * @param integer $exp
     * @param null|integer $time
     * @retrun string
     */
    protected function createClientSecret()
    {
        $token = (new JWT($this))->toString();

        return strval($token);
    }

    public function authCode($code, $redirectUri = null)
    {
        $results = '{"access_token":"a086a81e598024ae7bee0ae77910173a9.0.mryrr.h76KrqP70K2BBBPFy7EdKw","token_type":"Bearer","expires_in":3600,"refresh_token":"rb5b27a33cd2249adb52933ce86d4f130.0.mryrr.pj1OUq8M5TGxxpzYg8k9Kw","id_token":"eyJraWQiOiI4NkQ4OEtmIiwiYWxnIjoiUlMyNTYifQ.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLnNjeWQuY2FpYmVpVFYiLCJleHAiOjE1OTc4MTk4MjIsImlhdCI6MTU5NzgxOTIyMiwic3ViIjoiMDAxODExLjNlMWRlZjMyNTQ3ZjQ2YmU5N2ZlM2ZjNzJmODViY2ZjLjA3MzkiLCJhdF9oYXNoIjoic2NQM2lJMHJpc0pFLUVTVXlUT0YtQSIsImVtYWlsIjoiOTgyNDQ4OTUwQHFxLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjoidHJ1ZSIsImF1dGhfdGltZSI6MTU5NzgxOTIxMSwibm9uY2Vfc3VwcG9ydGVkIjp0cnVlfQ.PoShZYPCLydUjm-4DhAHEk4osgqtWKhqn0HjKoXQofDgPJxUBycGFEfjm67XjM48xaLeLb40d30ceyTDthTXBXOlToHAXLLEn3eCarvsQM9g99uvutWg-SDGF37PFYovlreby1D5JwLqHetpz-R1wVW4pBBYTrlXegjbd3k-lvKJfZcOJCv-zLo-TK_sx-O6ffnYJT0NTHnt-zHcblFj1-0G0hD98uF2oskWSmbZuect2iBjNIWJarv3P2nI4_S-z-CX41t6AECeox8sZrEDvd3nZ6bPAkI-QJtO22Ii6k_ld7QGiIeszw9CiI3j4v4N0Rqul21IufswjPTfPiXWFw"}';

//        $results = $this->httpRequest(
//            'POST',
//            '/auth/token',
//            [
//                'client_id' => $this->clientId,
//                'client_secret' => $this->getClientSecret(),
//                'code' => $code,
//                'grant_type' => 'authorization_code',
//                'redirect_uri' => null
//            ]
//        );

        return new AuthTokenResponse($results);
    }

    /**
     * @param $method
     * @param $uri
     * @param $options
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
