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

Now put these middlewares at the end of `App\Http\Kernel` global HTTP middlware stack *(order of middlewares is important)*
 
```php
\Illuminate\Session\Middleware\StartSession::class,   
\OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities::class
```


### Or
If you want your certain group of routes to be tracked, apply the middleware to the route group in **web.php** like 
```php
use OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities;

Route::middleware([TrackActivities::class])->group(static function () {
    // your routes to be tracked
});
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

**Remember** ( If key `trackerStatus` is `false` then no other key will work and won't track anything )

Package made database table hold records of certain days, and removes the rest of the data, 
by default it is set to `20` days, you can either change this too by

```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('keep_except', $numDays);
```

### Set your own keys

You can use your keys and values using `laravel tinker` **`(php artisan tinker)`** by setting `keyName` and `value`,
here are the keys `trackCookies`, `trackerStatus`, `trackMiscData`, `trackHttpRequests`, these keys hold
`boolean` values only, so remember to add third parameter as *'bool'*

```php
OTIFSolutions\Laravel\Settings\Models\Setting::set('yourKey', $trueFalse, 'bool');
```

### Clearing old data
Data is generated on every page hit by user, at the end we have bulk of data, 
we have command to remove that data data, which is sheduled to be executed after 30 days
at `08::00 AM` and time will be started when package will be installed, though we can run 
this command manually anytime to remove the data (before set days, default is 20)

```
php artisan clear:records
```

### Note 
In **Linux** environments, sometimes, when you install a package, it wants some permissions for package to work, like
*laravel.log* and *storage* etc residing in laravel project. You have to grant it 
permissions by running this command inside your laravel proejct , *for debian based linux distros like Ubuntu*

**for all files in project**
```ssh
sudo chmod -R 0777 *
```

**for certain single file**
```ssh
sudo chmod -R 0777 file
```

where *file* is *absolute path* to the file


### Relationships defined between Models
**NovaSession** is the parent model. It has *one-to-many* relation with **UserActivity**, 
*one-to-many* relation with **RequestData**, *one-to-many* relation with **MyCookie**
and *one-to-many* relation with **MiscData**.



### Licence
The MIT License (MIT). Please see [**License file**](https://github.com/otifsolutions/laravel-tracker/blob/main/LICENSE) for more information
