<?php

namespace Enotas\Endpoints;

use Enotas\Routes;

class Empresa extends Endpoint
{

    /**
     *
     * @param array $payload
     * @return \ArrayObject
     */
    public function getList(array $payload = null)
    {

        if (is_null($payload) || !isset($payload['pageNumber'])) {
            $payload['pageNumber'] = 0;
        }

        if (is_null($payload) || !isset($payload['pageSize'])) {
            $payload['pageSize'] = 10;
        }

        return $this->client->request(
            self::GET,
            Routes::empresa()->base(),
            ['query' => $payload]
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function get(array $payload)
    {
        return $this->client->request(
            self::GET,
            Routes::empresa()->details($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function upsert(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::empresa()->base(),
            ['json' => $payload]
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function enable(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::empresa()->enable($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function disable(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::empresa()->disable($payload['id'])
        );
    }
}
