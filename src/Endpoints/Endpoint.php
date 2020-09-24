<?php

namespace Enotas\Endpoints;

use Enotas\Client;

abstract class Endpoint
{
    /**
     * @var string
     */
    const POST = 'POST';
    /**
     * @var string
     */
    const GET = 'GET';
    /**
     * @var string
     */
    const PUT = 'PUT';
    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var \Enotas\Client
     */
    protected $client;

    /**
     * @param \Enotas\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
