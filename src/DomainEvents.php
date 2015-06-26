<?php

namespace Fesor\DomainEvents;

trait DomainEvents
{
    /**
     * @var Event[]
     */
    private $pendingEvents;

    /**
     * @param Event $event
     */
    protected function rememberThat(Event $event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * @return Event[]
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        return $events;
    }
}
