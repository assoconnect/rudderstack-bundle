# Rudderstack Bundle

Bundle include Rudderstack library for analytics

include [rudderlabs/rudder-php-sdk](https://github.com/rudderlabs/rudder-php-sdk)

Documentation
-------------

The bulk of the documentation is stored in the [Resources/doc](vendor/assoconnect/rudderstack-bundle/Resources/doc) folder in this bundle

## Installation

Installing the bundle via packagist is the quickest and simplest method of installing the bundle. Here are the steps:

### Step 1: Composer require

    $ php composer.phar require "assoconnect/reudderstack-bundle":"dev-master"

### Step 2: Enable the bundle in the kernel

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new AssoConnect\RudderstackBundle\RudderstackBundle(),
            // ...
        );
    }

That's it! You are ready to use Rudderstack with symfony.

## Configuration

Required rudderstack write key:

### Symfony 4.X || 5.X :

```yml
# config/packages/rudderstack.yml

rudderstack:
    write_key: "%env(RUDDERSTACK_KEY)%"  # add your key
    guest_id: "guest" # default guest. Guest id for annotation Track and Page
    env: prod #default prod. Can be prod (sending to rudderstack) and dev (not sending)
    options:
        consumer: socket #default
        debug: false #default
        ssl: false #default
        max_queue_size: 10000 #default
        batch_size: 100 #default
        timeout: 0.5 #default
        filename: null #default
```

### Symfony 2.X || 3.X

```yml
# app/config/config.yml

rudderstack:
        write_key: "%your_key%" #add your key
        guest_id: "guest" # default guest. Guest id for annotation Track and Page
        env: prod #default prod. Can be prod (sending to rudderstack) and dev (not sending)
        options:
            consumer: socket #default
            debug: false #default
            ssl: false #default
            max_queue_size: 10000 #default
            batch_size: 100 #default
            timeout: 0.5 #default
            filename: null #default
```

## Usage

Get `rudderstack.analytics` service from the service container and start using it:

```php
$analytics = $this->get('rudderstack.analytics');
$analytics->page([])
```

Or using Annotations (Page and Track)

User for annotations is getting from TokenStorage.
If user doesn't exit, id set to `guest` or from configuration 'guest_id'

```php
use AssoConnect\RudderstackBundle\Configuration\Page;
use AssoConnect\RudderstackBundle\Configuration\Track;

/**
     * @Route("/", name="homepage")
     *
     * @Page(
     *     name="index",
     *     category="page",
     *     properties={"foo":"bar"}
     * )
     * @Track(
     *     event="visit homepage",
     *     properties={"bar":"foo"},
     *     useTimestamp=true,
     *     context={"aa":"bb"}
     * )
     */
    public function indexAction(Request $request)
    {
        // your code
    }
```


Refer to [rudderstack analytics-php library](https://github.com/rudderlabs/rudder-php-sdk).
