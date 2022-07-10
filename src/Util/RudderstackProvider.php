<?php

namespace AssoConnect\RudderstackBundle\Util;

class RudderstackProvider
{
    private bool $isEnabled;

    /**
     * @param mixed[] $options
     * @throws \Exception
     */
    public function __construct(string $key, array $options)
    {
        $this->isEnabled = ('' !== $key);
        if ($this->isEnabled) {
            \Rudder::init($key, $options);
        }
    }

    /**
     * @param string[] $properties
     * @param mixed[] $context
     */
    public function track(string $event, string $id, bool $isAnonymous, array $properties, array $context): void
    {
        if (!$this->isEnabled) {
            return;
        }

        \Rudder::track([
            $isAnonymous ? 'anonymousId' : 'userId' => $id,
            'event' => $event,
            'properties' => $properties,
            'context' => $context
        ]);
    }

    /**
     * @param string[] $traits
     * @param mixed[] $context
     */
    public function identify(string $id, bool $isAnonymous, array $traits = [], array $context = []): void
    {
        if (!$this->isEnabled) {
            return;
        }

        \Rudder::identify([
            $isAnonymous ? 'anonymousId' : 'userId' => $id,
            'context' => array_merge($context, ['traits' => $traits]),
        ]);
    }

    /**
     * @param string[] $properties
     * @param mixed[] $context
     */
    public function page(string $id, bool $isAnonymous, string $name, array $properties = [], array $context = []): void
    {
        if (!$this->isEnabled) {
            return;
        }

        \Rudder::page([
            $isAnonymous ? 'anonymousId' : 'userId' => $id,
            'name' => $name,
            'properties' => $properties,
            'context' => $context,
        ]);
    }

    /**
     * @param string[] $traits
     * @param mixed[] $context
     */
    public function alias(
        string $id,
        bool $isAnonymous,
        string $previousId,
        array $traits = [],
        array $context = []
    ): void {
        if (!$this->isEnabled) {
            return;
        }

        \Rudder::alias([
            $isAnonymous ? 'anonymousId' : 'userId' => $id,
            'previousId' => $previousId,
            'context' => array_merge($context, ['traits' => $traits]),
        ]);
    }

    /**
     * @param string[] $traits
     * @param mixed[] $context
     */
    public function group(string $id, bool $isAnonymous, string $groupId, array $traits = [], array $context = []): void
    {
        if (!$this->isEnabled) {
            return;
        }

        \Rudder::group([
            $isAnonymous ? 'anonymousId' : 'userId' => $id,
            'groupId' => $groupId,
            'context' => array_merge($context, ['traits' => $traits]),
        ]);
    }

    public function flush(): void
    {
        if ($this->isEnabled) {
            \Rudder::flush();
        }
    }
}
