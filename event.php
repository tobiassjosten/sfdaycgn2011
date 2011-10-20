<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

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

$dispatcher = new EventDispatcher();

$dispatcher->addListener('my_event', function(Event $event) {
    echo 'Bar';
});
$dispatcher->addListener('my_event', function(Event $event) {
    $event->stopPropagation();
    $event->setMessage('Bar');
}, 1);

$event = new MyEvent();
$event->setMessage('Foo');

$dispatcher->dispatch('my_event', $event);

echo $event->getMessage();
