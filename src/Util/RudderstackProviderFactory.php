<?php

namespace AssoConnect\RudderstackBundle\Util;

class RudderstackProviderFactory
{
    /** @var mixed[] */
    private array $sources;
    /** @var mixed[] */
    private array $options;

    /**
     * @param mixed[] $sources
     * @param mixed[] $options
     */
    public function __construct(array $sources, array $options)
    {
        $this->sources = $sources;
        $this->options = $options;
    }

    public function getInstance(string $sourceName): RudderstackProvider
    {
        $key = null;

        foreach ($this->sources as $source) {
            if ($source['name'] === $sourceName) {
                $key = $source['write_key'];
            }
        }

        if ($key === null) {
            throw new \InvalidArgumentException(
                'The source name should match with one of the names provided in configurations file.'
            );
        }

        return new RudderstackProvider($key, $this->options);
    }
}
