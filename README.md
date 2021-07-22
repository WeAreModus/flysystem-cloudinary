# WeAreModus\Flysystem\Cloudinary

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This is a [Flysystem adapter](https://github.com/thephpleague/flysystem) for [Cloudinary API](http://cloudinary.com/documentation/php_integration).

## Installation

```bash
composer require wearemodus/flysystem-cloudinary '~2.0'
```

Or just add the following string to `require` part of your `composer.json`:

```json
{
  "require": {
    "wearemodus/flysystem-cloudinary": "~2.0"
  }
}
```

## Bootstrap

``` php
<?php
use WeAreModus\Flysystem\Cloudinary\ApiFacade as CloudinaryClient;
use WeAreModus\Flysystem\Cloudinary\CloudinaryAdapter;
use League\Flysystem\Filesystem;

include __DIR__ . '/vendor/autoload.php';

$client = new CloudinaryClient([
    'cloud_name' => 'your-cloudname-here',
    'api_key' => 'api-key',
    'api_secret' => 'You-know-what-to-do',
    'overwrite' => true, // set this to true if you want to overwrite existing files using $filesystem->write();
]);

$adapter = new CloudinaryAdapter($client);
// This option disables assert that file is absent before calling `write`.
// It is necessary if you want to overwrite files on `write` as Cloudinary does it by default.
$filesystem = new Filesystem($adapter, ['disable_asserts' => true]);
```

## Cloudinary features

Please, keep in mind three possible pain-in-asses of Cloudinary:

* It adds automatically file extension to its public_id. In terms of Flysystem, cloudinary's public_id is considered as filename. However, if you set public_id as 'test.jpg' Cloudinary will save the file as 'test.jpg.jpg'. In order to work
  it around, you can use [PathConverterInterface](doc/path_converter.md).
* It does not support folders creation through the API
* If you want to save your files using folder you should set public_ids like 'test/test.jpg' and allow automated folder creation in your account settings in Cloudinary dashboard.

#### Good news!

The library supports [Cloudinary Transformations](doc/transformations.md)!

## WeAreModus Fork

This fork includes some essential changes needed for my use-case. See CHANGELOG.md for a full list of changes, but here are the cliff notes:

- Added explicit PHP types _(this will prevent compatibility with PHP `<7.4`)_
- Updated dependencies _(PHP >=7.4, PHPUnit ^9, cloudinary_php ^2, php_codesniffer 3.*)_
- DataUri now reads the mime-type of media using only the first 1 MB, in order to prevent memory overflow for large files due to `finfo->buffer()`
- ApiFacade constructor now accepts an uploadOptions argument containing options that are passed through to the Cloudinary SDK's upload function

### Using with Laravel-MediaLibrary

In order to integrate this Cloudinary filesystem with Laravel-MediaLibrary, you will need to create a new filesystem driver as outline below:

1. Define your Cloudinary `.env` variables
    - `CLOUDINARY_CLOUD_NAME=`
    - `CLOUDINARY_API_KEY=`
    - `CLOUDINARY_API_SECRET=`
1. Define a new filesystem driver in your `filesystems.php` config file _(within the 'disks' array)_
   ```php
   'disks' => [
        ...
   
        'cloudinary' => [
            'driver'     => 'cloudinary',
            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
            'api_key'    => env('CLOUDINARY_API_KEY'),
            'api_secret' => env('CLOUDINARY_API_SECRET'),
        ],
   ]
   ```
1. Create a new CloudinaryServiceProvider `php artisan make:provider CloudinarySeviceProvider`, and insert this code into the `boot()` method
    ```php
    use WeAreModus\Flysystem\Cloudinary\ApiFacade as CloudinaryClient;
    use WeAreModus\Flysystem\Cloudinary\CloudinaryAdapter;
    use WeAreModus\Flysystem\Cloudinary\Converter\TruncateExtensionConverter;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\ServiceProvider;
    use League\Flysystem\Filesystem;
   
   ...
   
   public function boot() 
   {
        Storage::extend('cloudinary', function ($app, $config) {
        $client = new CloudinaryClient(
                [
                    'cloud_name' => $config['cloud_name'],
                    'api_key'    => $config['api_key'],
                    'api_secret' => $config['api_secret'],
                    'overwrite'  => $config['overwrite'] ?? true,
                ], // Cloudinary API options
                [
                    'resource_type'          => 'auto',
                    'eager'                  => [
                        ['fetch_format' => 'mp4', 'format' => '', 'video_codec' => 'h264', 'quality' => '70'], // f_mp4,vc_h264,q_70
                        ['fetch_format' => 'png', 'format' => '', 'quality' => '70'], // f_png,q_70
                    ],
                    'eager_async'            => 'true',
                    'eager_notification_url' => 'https://mysite.test/webhook/eager',
                    'notification_url'       => 'https://mysite.test/webhook/upload',
                    ...
                ], // Upload options
                new TruncateExtensionConverter()
           );
            
            return new Filesystem(new CloudinaryAdapter($client));
        });
   }
   ```
1. Finally, simply define `'cloudinary'` as your diskName when managing media
    ```php
    $this->addMediaCollection('videos')->useDisk('cloudinary'); // Use Cloudinary as disk for the entire collection
    // OR
    $model->addMedia($mediaPath)
          ->toMediaCollection('videos', 'cloudinary'); // USe Cloudinary as disk for this media only
   ```
