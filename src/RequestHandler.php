<?php

namespace Enotas;

class RequestHandler
{
    /**
     * @param array $options
     * @param string $apiKey
     *
     * @return array
     */
    public static function bindApiKey(array $options, $apiKey)
    {

        $options['headers'] = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . $apiKey,
        ];

        return $options;
    }
}
