Usage
=====

Usage as service
----------------

.. code-block:: php

    $analytics = $this->get('rudderstack.analytics');
    $analytics->page([])

Usage with Annotations
----------------------

User for annotations is getting from TokenStorage.
If user doesn't exit, id set to 'guest' or from configuration 'guest_id'

.. code-block:: php

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
