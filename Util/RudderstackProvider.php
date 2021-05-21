<?php

namespace AssoConnect\RudderstackBundle\Util;

use Rudder as Analytics;

class RudderstackProvider
{
    const RUDDERSTACK_PROVIDER__ENV_PROD = 'prod';
    const RUDDERSTACK_PROVIDER__ENV_DEV = 'dev';

    private bool $isEnabled;

    public function __construct($key, $environment, array $options, Callable $logger)
    {
        $this->isEnabled = $environment === self::RUDDERSTACK_PROVIDER__ENV_PROD && $key;
        $options['error_handler'] = $logger;
        if ($this->isEnabled) {
            Analytics::init($key, $options);
        }
    }

    /**
     * @param array $message
     *
     * @return bool
     */
    public function track(array $message)
    {
        return $this->process('track', $message);
    }

    /**
     * @param array $message
     *
     * @return bool
     */
    public function identify(array $message)
    {
        return $this->process(__FUNCTION__, $message);
    }

    /**
     * @param array $message
     *
     * @return bool
     */
    public function page(array $message)
    {
        return $this->process(__FUNCTION__, $message);
    }

    /**
     * @param array $message
     *
     * @return bool
     */
    public function alias(array $message)
    {
        return $this->process(__FUNCTION__, $message);
    }

    /**
     * @param array $message
     *
     * @return bool
     */
    public function group(array $message)
    {
        return $this->process(__FUNCTION__, $message);
    }

    /**
     * @return mixed
     */
    public function flush()
    {
        if ($this->isEnabled) {
            return Analytics::flush();
        }

        return true;
    }

    /**
     * @param array  $msg
     * @param string $string
     *
     * @return bool
     */
    public function validate(array $msg, $string)
    {
        try {
            Analytics::validate($msg, $string);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @return bool
     */
    private function process($name, array $params)
    {
        if ($this->isEnabled) {
            return Analytics::$name($params);
        }

        return true;
    }
}
