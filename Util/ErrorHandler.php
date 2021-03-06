<?php

namespace AssoConnect\RudderstackBundle\Util;

use Psr\Log\LoggerInterface;

/**
 * Class ErrorHandler
 */
class ErrorHandler
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * ErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string|int $code
     * @param string     $msg
     */
    public function __invoke($code, $msg)
    {
        $this->logger->error(sprintf('Rudderstack error %s : %s', $code, $msg));
    }
}
