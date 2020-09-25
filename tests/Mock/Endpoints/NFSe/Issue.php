<?php

namespace Enotas\Test\Mock\Endpoints\NFSe;

use Enotas\Test\Mock\Endpoints\Endpoint;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class Issue extends Endpoint
{

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function success(RequestInterface $request, array $option): Response
    {
        return new Response(200, [], json_encode([
            "nfeId" => $this->faker->regexify('[A-Za-z0-9]{8,8}\-[a-z0-9]{4,4}\-[0-9]{4,4}\-[a-z0-9]{4,4}\-[0-9]{12,12}')
        ]));
    }

    /**
     * @param RequestInterface $request
     * @param array $option
     * @return Response
     */
    public function error(RequestInterface $request, array $option): Response
    {
        return new Response(401, [], json_encode([
            [
                "codigo" => "AUT001",
                "mensagem" => "Acesso negado. APIKey invalida, por favor verifique se ela está correta."
            ]
        ]));
    }
}
