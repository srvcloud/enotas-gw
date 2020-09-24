<?php

namespace Enotas;

use Enotas\Endpoints\Empresa;
use Enotas\Endpoints\NFSe;
use Enotas\Exceptions\InvalidJsonException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class Client
{

    /**
     * @var string
     */
    const BASE_URI = 'http://api.enotasgw.com.br/v1/';

    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \Enotas\Endpoints\Empresa
     */
    private $empresa;

    /**
     * @var \Enotas\Endpoints\NFSe
     */
    private $nfse;

    /**
     * @param string $apiKey
     * @param array|null $extras
     */
    public function __construct($apiKey, array $extras = null)
    {
        $this->apiKey = $apiKey;

        $options = ['base_uri' => self::BASE_URI];

        if (!is_null($extras)) {
            $options = array_merge($options, $extras);
        }

        $this->http = new HttpClient($options);

        $this->empresa = new Empresa($this);
        $this->nfse = new NFSe($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \Enotas\Exceptions\EnotasException
     * @return \ArrayObject
     *
     */
    public function request($method, $uri, $options = [])
    {
        try {
            $response = $this->http->request(
                $method,
                $uri,
                RequestHandler::bindApiKey($options, $this->apiKey)
            );
            return ResponseHandler::success((string)$response->getBody());
        } catch (InvalidJsonException $exception) {
            throw $exception;
        } catch (ClientException $exception) {
            ResponseHandler::failure($exception);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return \Enotas\Endpoints\Empresa
     */
    public function empresa()
    {
        return $this->empresa;
    }

    /**
     * @return \Enotas\Endpoints\NFSe
     */
    public function nfse()
    {
        return $this->nfse;
    }
}
