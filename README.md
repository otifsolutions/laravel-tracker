## Laravel-tracker

The Package will track users activity and generate the complete log in database tables

### Requirements
`php >= 7.4`

`laravel >= 8.0`

## Installation

[**Composer**](https://getcomposer.org/download/) recommended to install package

```sh
 composer require otifsolutions/laravel-tracker
```

Now put the middleware at the end of `App\Http\Kernel` global HTTP middlware stack
 
```php
\Illuminate\Session\Middleware\StartSession::class,     // got from web
\OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities::class
```

and then run migrations by 

```
php artisan migrate
```

### Defaults

The package is enabled by default, once it is installed, it will start logging/tracking your site 
visits into database tables. To check what default settings are, 
see [**OTIFSolutions\LaravelTracker\Traits\UtilityMethods**](https://github.com/otifsolutions/laravel-tracker/blob/main/src/Traits/UtilityMethods.php) class constructor

```php
$this->trackerStatus = Setting::get('trackerStatus') ?: true;
$this->trackCookies = Setting::get('trackCookies') ?: false;
$this->trackMiscData = Setting::get('trackMiscData') ?: false;
$this->trackHttpRequests = Setting::get('trackHttpRequests') ?: true;
```

Package made database table hold records of certain days, and removes the rest of the data, 
by default it is set to `10` days, you can either change this too by

```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('keep_except', $numDays);
```

### Set your own keys

You can use your keys and values using `laravel tinker` by setting `keyName` and `value`,
here are the keys `trackCookies`, `trackerStatus`, `trackMiscData`, `trackHttpRequests`, these keys hold
`boolean` values only, so remember to add third parameter as *'bool'*

```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('yourKey', $trueFalse, 'bool');
```

### Relationships defined between Models
**NovaSession** is the parent model. It has *one-to-many* relation with **UserActivity**, 
*one-to-many* relation with **RequestData** and *one-to-many* relation with **MyCookie**. 
**ActivitySummary** does not have any relation with any model.


### Licence
The MIT License (MIT). Please see [**License file**](https://github.com/otifsolutions/laravel-tracker/blob/main/LICENSE) for more information
