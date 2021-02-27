<h1 align="center"><img src="/art/line-notify-banner.jpg" alt="Line Notify"></h1>

**The package for Laravel and PHP for Line application notification.**

[![Packagist](https://img.shields.io/packagist/dt/phattarachai/line-notify.svg)](https://github.com/phattarachai/line-notify/releases)
[![Maintainability](https://api.codeclimate.com/v1/badges/600b42e19f568f18d8ab/maintainability)](https://codeclimate.com/github/phattarachai/line-notify/maintainability)

Line Notify is a package for Laravel and PHP application to easily send notification to Line messaging application users
or groups. It builds on top of [Line Notify API](https://notify-bot.line.me/doc/en/), that provides a fluent interface
to send messages, images ,and stickers directly to Line service from Laravel and PHP.

# <a id="installing-line-notify"></a> Installing Line Notify

You need to use Composer to install Line-Notify into your project:

```
composer require phattarachai/line-notify
```

## Laravel Usage

Add a `LINE_ACCESS_TOKEN`  variable to your `.env`. You can get an access token for your application
from [Line Notify API](https://notify-bot.line.me/my/)

```env
// .env
LINE_ACCESS_TOKEN=#Token Go here#
```

Send a message via Line Notify.

```php
use Phattarachai\LineNotify\Facade\Line;

Line::send('message');
```

Send a message with an image.

```php
Line::imageUrl('https://lorempixel.com/1024/1024/')
    ->send('message');
```

You can also specify a thumbnail for your image

```php
Line::thumbnailUrl('https://lorempixel.com/240/240/')
    ->imageUrl('https://lorempixel.com/1024/1024/')
    ->send('message');
```

You can upload an image from your local path

```php
Line::imagePath('/path/to/your/image.png')
    ->send('message');
```

You can combine image uploading and image url together. The uploaded image will take precedence to image url.

```php
Line::thumbnailUrl('https://lorempixel.com/240/240/')
    ->imageUrl('https://lorempixel.com/1024/1024/')
    ->imagePath('/path/to/your/image.png')
    ->send('message');
```

Send a message with sticker. You can find a list of Sticker Package ID and Sticker ID
here https://devdocs.line.me/files/sticker_list.pdf

```php
Line::sticker(1, 138)
    ->send('message');
```

Notice that Line require to have a message for each and every request whether you send an image or sticker you still
required to provide a message for the API.

### <a name="config-publish"></a> Publishing the configuration file

Alternatively to adding a variable into your `.env`, you can publish `config/line-notify.php` file and add your token
there.

Run the following Artisan command in your terminal:

```
php artisan vendor:publish --provider="Phattarachai\LineNotify\LineNotifyServiceProvider"
```

You can set the token in this file.

```php
// File: /config/line-notify.php
return [
    'access_token' => env('LINE_ACCESS_TOKEN', null),
];
```

## Configuring (Laravel)

### <a name="config-auto-discovery"></a> Laravel 5.5 and newer

Line Notify wil register itself using
Laravel's [Auto Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

### <a name="config-service-loader"></a> Laravel 5.4 and older

You'll have to include `LineNotifyServiceProvider` in your `config/app.php`:

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    Phattarachai\LineNotify\LineNotifyServiceProvider::class,
]
```

## PHP Usage (outside Laravel)

```php
use Phattarachai\LineNotify\Line;

$line = new Line('YOUR-API-TOKEN-HERE');
$line->send('message');
```

## Screenshot

<h1 align="center"><img src="/art/screenshot.jpg" alt="Screenshot" width="30%"></h1>

## Support Me

<a href="https://store.line.me/stickershop/product/14535782">
    <img src="https://me.phattarachai.dev/wp-content/uploads/2021/02/Banner.png"
        alt="Sticker Line 500 Internal Server Error by phattarachai.dev" width="30%" />
</a>

I love creating Laravel and PHP packages to help making Web developer life easier. You can support me by buying my LINE
stickers from the [https://store.line.me/stickershop/product/14535782](LINE Store).

## Credit

A project by [phattarachai.dev](https://phattarachai.dev)

If my package make your life easier, please consider:

<a href="https://ko-fi.com/phattarachai#checkoutModal" target="_blank">Buy me a Coffee</a> |

<a href="https://twitter.com/phatchai" target="_blank">Follow Me on Twitter</a>S

## License

The MIT License (MIT)
