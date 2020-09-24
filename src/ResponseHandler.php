<?php

namespace Enotas;

use GuzzleHttp\Exception\ClientException;
use Enotas\Exceptions\EnotasException;
use Enotas\Exceptions\InvalidJsonException;

class ResponseHandler
{
    /**
     * @param string $payload
     *
     * @throws \Enotas\Exceptions\InvalidJsonException
     * @return \ArrayObject
     */
    public static function success($payload)
    {
        if (empty($payload)) {
            return null;
        }
        return self::toJson($payload);
    }

    /**
     * @param ClientException $originalException
     *
     * @throws EnotasException
     * @return void
     */
    public static function failure(\Exception $originalException)
    {
        throw self::parseException($originalException);
    }

    /**
     * @param ClientException $guzzleException
     *
     * @return EnotasException|ClientException
     */
    private static function parseException(ClientException $guzzleException)
    {
        $response = $guzzleException->getResponse();

        if (is_null($response)) {
            return $guzzleException;
        }

        $body = $response->getBody()->getContents();

        try {
            $jsonError = self::toJson($body);
        } catch (InvalidJsonException $invalidJson) {
            return $guzzleException;
        }

        if (is_array($jsonError)) {
            $jsonError = $jsonError[0];
        }

        return new EnotasException(
            $jsonError->codigo ?? null,
            $jsonError->mensagem ?? $jsonError->Message,
        );
    }

    /**
     * @param string $json
     * @return \ArrayObject
     */
    private static function toJson($json)
    {
        $result = json_decode($json);

        if (json_last_error() != \JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg());
        }

        return $result;
    }
}
