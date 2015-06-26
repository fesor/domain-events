<?php

namespace Fesor\DomainEvents;

class EventDispatcher
{
    /**
     * @var EventListener[]
     */
    private $listeners;

    /**
     * @var \SplObjectStorage
     */
    private $subscribers;

    /**
     * @param EventListener[]   $listeners
     * @param EventSubscriber[] $subscribers
     */
    public function __construct(array $listeners = [], array $subscribers = [])
    {
        $this->clearListeners();
        $this->clearSubscriber();

        foreach ($listeners as $listener) {
            $this->addListener($listener);
        }

        foreach ($subscribers as $subscriber) {
            $this->addSubscriber($subscriber);
        }
    }

    /**
     * @param Event[] $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $this->handleEvent($event);
        }
    }

    public function addListener(EventListener $listener)
    {
        $this->listeners[] = $listener;
    }

    public function removeListener(EventListener $listener)
    {
        $index = array_search($listener, $this->listeners);
        if (false === $index) {
            return true;
        }

        array_splice($this->listeners, $index, 1);

        return true;
    }

    public function clearListeners()
    {
        $this->listeners = [];
    }

    public function addSubscriber(EventSubscriber $subscriber)
    {
        $this->subscribers->attach($subscriber, $subscriber->subscribe());
    }

    public function removeSubscriber(EventSubscriber $subscriber)
    {
        if ($this->subscribers->contains($subscriber)) {
            $this->subscribers->detach($subscriber);
        }
    }

    public function clearSubscriber()
    {
        $this->subscribers = new \SplObjectStorage();
    }

    public function isEventPublisher($object)
    {
        return is_object($object) && $object instanceof DomainEventPublisher
        || in_array('Fesor\\DomainEvents\\DomainEvents', class_uses($object));
    }

    private function handleEvent(Event $event)
    {
        foreach ($this->listeners as $listener) {
            $listener->handle($event);
        }

        foreach ($this->getHandlersForEvent($event) as $handler) {
            call_user_func($handler, $event);
        }
    }

    private function getHandlersForEvent(Event $event)
    {
        $handlers = [];
        foreach ($this->subscribers as $subscriber) {
            $subscription = $this->subscribers[$subscriber];
            if (isset($subscription['class']) && !is_a($event, $subscription['class'])) {
                continue;
            }

            $handlers[] = [$subscriber, $subscription['method']];
        }

        return $handlers;
    }
}
