# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2021-07-22

* **Updated** ApiFacade::upload() options to default to resource_type 'auto' _(adds video support)_
* **Updated** PHPUnit version to `^9` to support PHP 8.0
* **Updated** tests to work with PHPUnit `^9`
* **Updated** Composer dependencies to latest versions
* **Updated** ApiFacade to accommodate breaking changes in cloudinary_php `^2.0`
* **Changed** ApiFacade no longer extends \Cloudinary\Api
* **Added** ApiFacade defines its own deleteResourcesByPrefix
* **Changed** references to delete_resources_by_prefix now use deleteResourcesByPrefix
* **Added** explicit PHP types
* **Changed** \Cloudinary\Api\Error to \Cloudinary\Api\Exception\ApiError
* **Changed** ApiFacade::__construct() $options parameter to $cloudinaryOptions
* **Updated** ApiFacade::__construct() to accept an additional $uploadOptions argument
* **Updated** DataUri::__toString() to determine mime-type using only the first 1 MB of media content to avoid memory overflow problems with large files
* **Removed** ApiFacade::deleteResources()
* **Removed** ApiFacade::setUploadPreset()



## [1.3.0] - 2020-08-20

* **Changed** Switched from [delete_resources](https://cloudinary.com/documentation/admin_api#delete_resources) to [destroy](https://cloudinary.com/documentation/image_upload_api_reference#destroy_method) API for file deletes. This allows to easier use `invalidate` option.

## [1.2.0] - 2020-06-17

* **Changed** bump phpunit version to ^6
* **Changed** drop PHP 5 support
* **Fix** Deprecation errors in PHP 7.4

## [1.1.1] - 2018-02-21

* **Added** `GetVersionedUrl` plugin to get URL of specific file version 
(or latest one if no version provided)
* **Added** `setDeleteOptions` function for `ApiFacade` class which is necessary to pass options 
to during `delete` method execution: for example you can pass `invalidate` option 
to Cloudinary API to force cache invalidation.

## [1.1.0] - 2018-01-27

* **Added** ReadTransformation and GetUrl plugins for Flysystem to utilize more Cloudinary features
* **Added** PathConverterInterface to make it possible to implement 
your own logic in path to public id conversions

* **Fix** TypeError on listContents of non-existent folder


## [1.0.1] - 2016-04-26

* **Fix** `normalizeMetadata` method to handle `\ArrayObject` and regular arrays

## [1.0.0] - 2015-12-18

Initial release.
