<?php

namespace AssoConnect\RudderstackBundle\EventListener;

use AssoConnect\RudderstackBundle\Util\RudderstackProvider;
use Doctrine\Common\Annotations\Reader;
use AssoConnect\RudderstackBundle\Configuration\Page;
use AssoConnect\RudderstackBundle\Configuration\Track;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AnnotationListener
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var RudderstackProvider
     */
    protected $rudderstackProvider;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var string
     */
    protected $guestId;

    /**
     * AnnotationListener constructor.
     *
     * @param Reader                $reader
     * @param TokenStorageInterface $tokenStorage
     * @param RudderstackProvider   $rudderstackProvider
     * @param string                $guestId
     */
    public function __construct(Reader $reader, TokenStorageInterface $tokenStorage, RudderstackProvider $rudderstackProvider, $guestId)
    {
        $this->reader = $reader;
        $this->rudderstackProvider = $rudderstackProvider;
        $this->tokenStorage = $tokenStorage;
        $this->guestId = $guestId;
    }

    /**
     * @param ControllerEvent $event
     *
     * @throws \ReflectionException
     */
    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        list($controllerObject, $methodName) = $controller;

        $controllerReflectionObject = new \ReflectionObject($controllerObject);
        $reflectionMethod = $controllerReflectionObject->getMethod($methodName);

        $userId = $this->getUserId();
        foreach ($this->reader->getMethodAnnotations($reflectionMethod) as $configuration) {
            if ($configuration instanceof Page) {
                $message = $configuration->getMessage();
                $message['userId'] = $userId;

                $this->rudderstackProvider->page(
                    $message
                );

                $this->rudderstackProvider->flush();
            }

            if ($configuration instanceof Track) {
                $message = $configuration->getMessage();
                $message['userId'] = $userId;

                $this->rudderstackProvider->track($message);

                $this->rudderstackProvider->flush();
            }
        }
    }


    /**
     * @return string|null
     *
     * @throws \ReflectionException
     */
    private function getUserId()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return $this->guestId;
        }

        if (!is_object($user = $token->getUser())) {
            return $this->guestId;
        }

        $reflect = new \ReflectionClass($user);
        if ($reflect->hasMethod('getId')) {
            $userId = $user->getId();
            if (null !== $userId) {
                return $userId;
            }
        }

        return $this->guestId;
    }
}
