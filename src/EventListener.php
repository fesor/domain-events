<?php

namespace Fesor\DomainEvents;

interface EventListener
{
    /**
     * @param Event $event
     */
    public function handle(Event $event);
}
