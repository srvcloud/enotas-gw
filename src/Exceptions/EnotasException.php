<?php

namespace Enotas\Exceptions;

final class EnotasException extends \Exception
{
    /**
     * @var string
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     */
    public function __construct($errorCode, $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;

        $exceptionMessage = $this->buildExceptionMessage();

        parent::__construct($exceptionMessage);
    }

    /**
     * @return string
     */
    private function buildExceptionMessage()
    {

        $message = [];

        if (!is_null($this->errorCode)) {
            array_push(
                $message,
                sprintf('ERROR CODE: %s', $this->errorCode)
            );
        }

        if (!is_null($this->errorMessage)) {
            array_push(
                $message,
                sprintf('MESSAGE: %s', $this->errorMessage)
            );
        }

        return join('. ', $message);
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}
