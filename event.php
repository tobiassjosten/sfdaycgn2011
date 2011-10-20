<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyEvent extends Event
{
    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

class MySubscriber implements EventSubscriberInterface
{
    public function onMyEvent1(MyEvent $event)
    {
        $event->stopPropagation();
        $event->setMessage('Bar');
    }

    public function onMyEvent2(MyEvent $event)
    {
        echo 'Foo';
    }

    static public function getSubscribedEvents()
    {
        return array(
            'my_event1' => 'onMyEvent1',
            'my_event2' => 'onMyEvent2',
        );
    }
}

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new MySubscriber());

$event = new MyEvent();
$event->setMessage('Foo');

$dispatcher->dispatch('my_event1', $event);
$dispatcher->dispatch('my_event2', $event);

echo $event->getMessage();
