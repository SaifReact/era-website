<?php


namespace App\Exceptions;

/**
 * Class BannerException
 * @package App\Exceptions
 */
class BannerException extends \Exception implements LogicalExceptionable
{
    /**
     * BannerException constructor.
     * @param $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message, $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
