<?php

namespace Enotas\Test\Mock\Endpoints\NFSe;

use Enotas\Test\Mock\Endpoints\Endpoint;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

use function GuzzleHttp\Psr7\parse_query;

class Cancel extends Endpoint
{

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function success(RequestInterface $request, array $option): Response
    {
        $path = explode('/', $request->getUri()->getPath());
        return new Response(200, [], json_encode([
            'nfeId' => array_pop($path)
        ]));
    }

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function error(RequestInterface $request, array $option): Response
    {
        return new Response(400, [], json_encode([[
            "codigo" => "NF0001",
            "mensagem" => "Não foi possível solicitar o cancelamento da NF-e, pois a mesma já se encontra com o status = \"Cancelada\"."
        ]]));
    }
}
