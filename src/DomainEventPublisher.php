<?php

namespace Fesor\DomainEvents;

interface DomainEventPublisher
{
    /**
     * Releases all pending events.
     *
     * @return Event[]
     */
    public function releaseEvents();
}
