## Laravel-tracker

This Package that tracks users activity and generates the complete log in database tables

### Requirements
`php >= 7.4`

`laravel >= 8.0`

## Installation

[**Composer**](https://getcomposer.org/download/) recommended to install package

```sh
 composer require otifsolutions/laravel-tracker
```

Now put the middleware in your `App\Http\Kernel` global HTTP middlware stack
 
```php
\OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities::class;
```

and then run migrations by 

```
php artisan migrate
```

#### Defaults:

The package is enabled by default, once it is installed, it will start logginc/tracking your site visits into database tables. To check what default settings are , see `OTIFSolutions\LaravelTracker\Traits\Utilities` class constructor

```php
$this->trackCookies = Setting::get('trackCookies') ?: false;
$this->trackerStatus = Setting::get('trackerStatus') ?: true;
$this->trackMiscData = Setting::get('trackMiscData') ?: true;
$this->trackHttpRequests = Setting::get('trackHttpRequests') ?: true;
```

You can your own keys and values using `laravel tinker` by setting `keyName` and `value`
```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('yourKey', $value);
```

if the value is `bool`, don't forget to add third parameter to this method by
```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('yourKey', $value, 'bool');
```

#### Licence
The MIT License (MIT). Please see [**License file**](https://github.com/otifsolutions/laravel-tracker/blob/main/LICENSE) for more information
