<?php

namespace Enotas\Endpoints;

use Enotas\Routes;

class NFSe extends Endpoint
{

    /**
     *
     * @param array $payload
     * @return \ArrayObject
     */
    public function getList(array $payload = null)
    {

        if (empty($payload['pageNumber'])) {
            $payload['pageNumber'] = 0;
        }

        if (empty($payload['pageSize'])) {
            $payload['pageSize'] = 10;
        }

        if (empty($payload['sortBy'])) {
            $payload['sortBy'] = 'dataCriacao';
        }

        if (empty($payload['sortDirection'])) {
            $payload['sortDirection'] = 'asc';
        }

        $baseFilter = 'status eq \'%s\'';
        if (empty($payload['status'])) {
            $payload['status'] = 'autorizada';
        }

        $payload['filter'] = sprintf($baseFilter, $payload['status']);

        return $this->client->request(
            self::GET,
            Routes::nfse()->base($payload['empresa_id']),
            ['query' => $payload]
        );
    }

    /**
     *
     * @param array $payload
     * @return \ArrayObject
     */
    public function get(array $payload = null)
    {

        if (empty($payload['id_externo'])) {
            $id = $payload['nfse_id'];
            $route = Routes::nfse()->details;
        } else {
            $id = $payload['id_externo'];
            $route = Routes::nfse()->details_external;
        }

        return $this->client->request(
            self::GET,
            $route($payload['empresa_id'], $id),
            ['query' => $payload]
        );
    }

    /**
     *
     * @param array $payload
     * @return \ArrayObject
     */
    public function issue(array $payload = null)
    {
        return $this->client->request(
            self::POST,
            Routes::nfse()->base($payload['empresa_id']),
            ['json' => $payload]
        );
    }
}
