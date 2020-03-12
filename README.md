# Gravatar Helper for Laravel 6/7

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

**Get HTML Image Tag with custom attributes:**
``` php
Gravatar::img('test@example.com', [
    'class' => 'w-10 h-10 rounded-full'
])
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.