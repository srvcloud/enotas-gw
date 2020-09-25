<?php

namespace Enotas\Test\Mock\Endpoints;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

abstract class Endpoint
{

    /**
     * @var string
     */
    protected $regexUri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var int
     */
    protected $successChance;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    abstract protected function success(RequestInterface $request, array $option): Response;

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    abstract protected function error(RequestInterface $request, array $option): Response;

    /**
     * @param string $regexUri
     * @param string $method
     * @param integer $successChance
     */
    function __construct(string $regexUri, string $method, int $successChance = 100)
    {
        $this->regexUri = $regexUri;
        $this->method = $method;
        $this->successChance = $successChance;
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function response(RequestInterface $request, array $option): Response
    {
        if ($this->whichCall()) {
            return $this->success($request, $option);
        } else {
            return $this->error($request, $option);
        }
    }

    /**
     * @return boolean
     */
    protected function whichCall(): bool
    {
        return rand(0, 99) < $this->successChance;
    }

    /**
     * @param [type] $uri
     * @return boolean
     */
    public function matchUri($uri): bool
    {
        return preg_match($this->regexUri, $uri);
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $mockName
     *
     * @return string
     */
    protected static function jsonMock($mockName)
    {
        return file_get_contents(__DIR__ . "/../data/$mockName.json");
    }
}
