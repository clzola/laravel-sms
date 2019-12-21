# Send SMS to your users

This package adds SMS component to your Laravel's projects. It supports few drivers out of the box that can be useful.

Example:

```php
SMS::to($user)
   ->content("Hi! Your order has been shipped!")
   ->send();
```
       
## Installation

You can install this package via composer using this command:

    composer require "clzola/laravel-sms:^1.0.0"
    
The package will automatically register itself.

You can publish the config-file with:

    php artisan vendor:publish --provider="clzola\Components\Sms\SmsServiceProvider" --tag="config"

This is the contents of the published config file:

```php
return [

    /*
     * Specify which database driver you want to use.
     */
    'default' => env('SMS_DRIVER', 'null'),


    /*
     * Specify sender name.
     */
    'from' => env('SMS_FROM', 'Laravel'),


    /*
     * List of drivers and theirs configurations.
     */
    'drivers' => [

        /*
         * Driver for sending sms messages to running emulator.
         */
        'emulator' => [

            /*
             * Specify Android SDK path
             */
            'android_sdk_path' => env('SMS_ANDROID_SDK_PATH'),

        ]

    ]
    
];
```
    
# Usage

This package exposes SMS facade. You specify recipient and content of the message and call `send()`:

```php
SMS::to($user)->content($message)->send();
```
    
Recipient of the message can be a valid phone number or any entity that implements `clzola\Components\Sms\Contracts\HasPhoneNumber` contract.

Example:

```php
use clzola\Components\Sms\Contracts\HasPhoneNumber;

class Company extends Model implements HasPhoneNumber 
{
    // ...
    
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }  
}

// ...

$company = Company::find(3);
SMS::to($company)->content($message)->send();
```
    
# Supported drivers

## Null Driver

This driver has empty send() method and discards all messages. Can be useful in the beginning for testing and setting up project.
To use this driver set `sms.default` to `'null'` or in your **.env** file set `SMS_DRIVE="null"`.

## Android Emulator Driver

This driver can send sms messages to currently running emulator.
To use this driver set `sms.default` to `'emulator'` or in your **.env** file set `SMS_DRIVE="emulator"`.
Also do not forget to set Android SDK path in your .env file `SMS_ANDROID_SDK_PATH="~/path/to/androd/sdk"`

## Infobip Driver

This driver can send actual sms messages to physical devices using [Infobip](https://www.infobip.com/) service.
To use this driver set `sms.default` to `'infobip'` or in your **.env** file set `SMS_DRIVE="infobip"`.
Also in your **config/services.php** add following configuration:

    "infobip" => [
        "api_key" => "YOUR_INFOBIP_API_KEY",
    ],
    
## Custom Driver

For now this package supports few drivers but you can register your own drivers.

First make sure that your driver extends `clzola\Components\Sms\Drivers\Driver` class and implements `send()` method.

```php
use clzola\Components\Sms\Drivers\Driver;

class CustomSmsDriver extends Driver 
{
    
    // ...
    
    public function send()
    {
        // Write code to send SMS message
    }
}
```
 
Next open your `AppServiceProvider` and in `boot()` method register this driver:
 
```php
class AppServiceProvider extends ServiceProvider
{
    // ...

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app("sms")->registerDriver("custom", new CustomSmsDriver(...));
    }
}
```