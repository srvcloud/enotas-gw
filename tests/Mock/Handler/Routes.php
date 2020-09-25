<?php

namespace Enotas\Test\Mock\Handler;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class Routes
{

    /**
     *
     * @var array
     */
    private $mockRules;

    /**
     * @param array $mockRules
     */
    public function __construct(array $mockRules = null)
    {
        $this->mockRules = $mockRules ?? $this->defaultMockRules();
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return FulfilledPromise
     */
    public function __invoke(RequestInterface $request, array $options): FulfilledPromise
    {

        $method = $request->getMethod();
        $uri = $request->geturi()->getPath();

        foreach ($this->mockRules as $endpoint) {
            if ($endpoint->matchUri($uri) && $method === $endpoint->getMethod()) {
                return new FulfilledPromise(
                    $endpoint->response($request, $options)
                );
            }
        }

        return new FulfilledPromise(
            (new \GuzzleHttp\Client())->sendRequest($request)
        );
    }

    /**
     * @return void
     */
    private function defaultMockRules()
    {
        return [
            new \Enotas\Test\Mock\Endpoints\NFSe\Issue(
                '/\/v1\/empresas\/(.*)\/nfes/',
                'POST'
            ),
            new \Enotas\Test\Mock\Endpoints\NFSe\Get(
                '/\/v1\/empresas\/(.*)\/nfes\/(.*)/',
                'GET'
            ),
            new \Enotas\Test\Mock\Endpoints\NFSe\Cancel(
                '/\/v1\/empresas\/(.*)\/nfes\/(.*)/',
                'DELETE'
            ),
        ];
    }
}
