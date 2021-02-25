<h1 align="center"><img src="/art/line-notify-banner.jpg" alt="Line Notify"></h1>

**The package for Laravel and PHP for Line application notification.**

[comment]: <> ([![Travis]&#40;https://travis-ci.org/corcel/corcel.svg?branch=master&#41;]&#40;https://travis-ci.org/corcel/corcel?branch=master&#41;)

[![Packagist](https://img.shields.io/packagist/dt/phattarachai/line-notify.svg)](https://github.com/phattarachai/line-notify/releases)

[comment]: <> ([![Test Coverage]&#40;https://codeclimate.com/github/corcel/corcel/badges/coverage.svg&#41;]&#40;https://codeclimate.com/github/corcel/corcel/coverage&#41;)

[comment]: <> ([![Maintainability]&#40;https://api.codeclimate.com/v1/badges/3dc8135eee70ae7da325/maintainability&#41;]&#40;https://codeclimate.com/github/corcel/corcel/maintainability&#41;)

Line Notify is a package for Laravel and PHP application to easily send notification to Line messaging application users
or groups. It builds on top of [Line Notify API](https://notify-bot.line.me/doc/en/), that provides a fluent interface
to send messages, images ,and stickers directly to Line service from Laravel and PHP.

# <a id="installing-line-notify"></a> Installing Line Notify

You need to use Composer to install Line-Notify into your project:

```
composer require phattarachai/line-notify
```

## Laravel Usage

Add a `LINE_ACCESS_TOKEN`  variable to your .env

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

Alternative to adding a variable into your `.env` you can publish a config file and add your token in
the `config/line-notify.php` file

Run the following Artisan command in your terminal:

```
php artisan vendor:publish --provider="Phattarachai\LineNotify\LineNotifyServiceProvider"
```

Now you have a `config/line-notify.php` config file, where you can set the access token for your application. You can
get an access token for your application from [Line Notify API](https://notify-bot.line.me/my/)

After published a configuration file to your `config/line-notify.php`. You can set an variable to your .env or set it in
you config file.

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

<h1 align="center"><img src="/art/screenshot.jpg" alt="Screenshot" width="50%"></h1>

## Credit

A project by [phattarachai.dev](https://phattarachai.dev)

If my package make your life easier, please consider:

<a href="https://ko-fi.com/phattarachai#checkoutModal" target="_blank">Buy me a Coffee</a> |

<a href="https://twitter.com/phatchai" target="_blank">Follow Me on Twitter</a>S

## License

The MIT License (MIT)
