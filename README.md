# Laravel Logdesk

## Installation

install this package

```bash
composer require jhonoryza/logdesk --dev
```

download desktop app here [https://github.com/jhonoryza/logdesk/releases/latest](https://github.com/jhonoryza/logdesk/releases/latest)

![image](https://github.com/jhonoryza/laravel-logdesk/assets/5910636/6debb591-1d10-46e1-a460-feb223113334)

## Usage

```php
logdesk('ok'); // string
logdesk(new User()); // object
logdesk(['foo' => 'bar') // array
logdesk(true); // boolean
```

or you can pass multiple value

```php
logdesk('ok', ['foo' => 'bar'], new User());
```

