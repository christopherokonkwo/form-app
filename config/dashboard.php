<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Dashboard will be accessible from. If the
    | domain is set to null, Dashboard will reside under the defined base
    | path below. Otherwise, this will be used as the subdomain.
    |
    */

    'domain' => env('DASHBOARD_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | This is the URI where Dashboard will be accessible from. If the path
    | is set to null, Dashboard will reside under the same path name as
    | the application. Otherwise, this is used as the base path.
    |
    */

    'path' => env('DASHBOARD_PATH', 'dashboard'),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be attached to every route in Dashboard, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with the list.
    |
    */

    'middleware' => [
        'web',
        'auth'
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Dashboard will use to put file uploads. You may
    | use any of the disks defined in the config/filesystems.php file and
    | you may also change the maximum upload size from its 3MB default.
    |
    */

    'storage_disk' => env('DASHBOARD_STORAGE_DISK', 'local'),

    'storage_path' => env('DASHBOARD_STORAGE_PATH', 'public/dashboard'),

    'upload_filesize' => env('DASHBOARD_UPLOAD_FILESIZE', 3145728),

    /*
    |--------------------------------------------------------------------------
    | Unsplash Integration
    |--------------------------------------------------------------------------
    |
    | Visit https://unsplash.com/oauth/applications to create a new Unsplash
    | app. Use the confidential Access Key given to you to integrate with
    | the API. Note that demo apps are limited to 50 requests per hour.
    |
    */

    'unsplash' => [
        'access_key' => env('DASHBOARD_UNSPLASH_ACCESS_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | E-Mail Notifications
    |--------------------------------------------------------------------------
    |
    | This option controls e-mail notifications that will be sent via the
    | default application mail driver. A default option is provided to
    | support the notification system as an opt-in feature.
    |
    |
    */

    'mail' => [
        'enabled' => env('DASHBOARD_MAIL_ENABLED', false),
    ],

];
