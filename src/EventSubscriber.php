<?php

namespace Fesor\DomainEvents;

interface EventSubscriber
{
    /**
     * @return array
     */
    public function subscribe();
}
