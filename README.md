Domain Events
==================

This is very simple implementation of domain events.

## Usage

```php
<?php

namespace Domain\User;
 
use \Fesor\DomainEvent\DomainEvents; 
 
class User {
    
    use DomainEvents;
    
    private $email;
    
    private $password;
    
    public function __constructor(Email $email, Password $password)
    {
        $this->email = $email;
        $this->password = $password;
        // remember event
        $this->rememberThat(new UserRegistered($this));
    }
}

```

Now we can know what happened with our entity during request:

```php
$user = new User(new Email($email), new Password($password));
$events = $user->releaseEvents(); // will return array with UserRegistered event
$tryAgain = $user->releaseEvents(); // will return empty array, since we already released all events

$dispatcher = new EventDispatcher();
$dispatcher->dispatch($events);
```
