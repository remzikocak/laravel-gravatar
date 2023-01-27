# Gravatar Helper for Laravel 9/10

This Package will help you to Generate Gravatar URL's with Laravel.

## Installation
You can install the package via composer:

``` bash
composer require remzikocak/laravel-gravatar
```

## Usage
**Get Users Gravatar URL:**
``` php
Gravatar::url('test@example.com');
```

**Get Users Gravatar with Custom Configuration:**
``` php
Gravatar::for('test@example.com')
            ->size(150)
            ->default('identicon')
            ->rating('x')
            ->get();
```

**Get HTML Image Tag:**
``` php
Gravatar::img('test@example.com')
```

**Get HTML Image Tag with attributes:**
``` php
Gravatar::img('test@example.com', [
    'class' => 'w-10 h-10 rounded-full'
])
```

**Check if Gravatar for an email exists:**
``` php
Gravatar::exists('test@example.com')
```

**Get Gravatar using 'HasGravatar' trait:**

First add 'HasGravatar' trait to your User Model.

``` php
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use RKocak\Gravatar\Traits\HasGravatar;

class User extends Authenticatable
{
    use Notifiable, HasGravatar;
```

after adding the Trait, you can use it like this

``` php
$user = App\User::find(1);

// This will return the Gravatar URL
$user->getGravatar();

// or get the Generator instance with preset email
$generator = $user->getGravatarGenerator();
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
