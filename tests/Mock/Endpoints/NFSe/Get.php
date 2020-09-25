<?php

namespace Enotas\Test\Mock\Endpoints\NFSe;

use Enotas\Test\Mock\Endpoints\Endpoint;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

use function GuzzleHttp\Psr7\parse_query;

class Get extends Endpoint
{

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function success(RequestInterface $request, array $option): Response
    {
        $data = json_decode(self::jsonMock('NFSeMock'), true);
        $data['id'] = parse_query($request->getUri()->getQuery())['nfse_id'];
        return new Response(200, [], json_encode($data));
    }

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function error(RequestInterface $request, array $option): Response
    {
        return new Response(400, [], json_encode([
            [
                "codigo" => "NFe0001",
                "mensagem" => "A Nota fiscal não foi encontrada. Por favor, verifique se o id foi informado corretamente"
            ]
        ]));
    }
}
