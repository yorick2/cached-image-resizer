![Under Construction][ico-under-construction]

[![License][ico-license]](LICENSE.md)
![Release][ico-in-development]
![Release][ico-release]
![Release][ico-tag]
![Download Size][ico-download-size]
![Last Commit][ico-last-commit]

![UNIT TESTS][ico-unit-tests]

![Github Top Language][ico-top-language]
![Vue version][ico-vue-version]
![PHP version][ico-php-version]

[ico-under-construction]: https://img.shields.io/badge/UNDER%20CONSTRUCTION!-red?style=for-the-badge

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge
[ico-in-development]: https://img.shields.io/badge/Release-Development-yellow?style=for-the-badge
[ico-release]: https://img.shields.io/github/v/release/yorick2/cached-image-resizer?style=for-the-badge
[ico-tag]: https://img.shields.io/github/v/tag/yorick2/cached-image-resizer?style=for-the-badge
[ico-download-size]: https://img.shields.io/github/languages/code-size/yorick2/cached-image-resizer?style=for-the-badge
[ico-last-commit]: https://img.shields.io/github/last-commit/yorick2/cached-image-resizer?style=for-the-badge

[ico-unit-tests]: https://github.com/yorick2/cached-image-resizer/actions/workflows/UnitTests.yml/badge.svg

[ico-top-language]: https://img.shields.io/github/languages/top/yorick2/cached-image-resizer?style=for-the-badge
[ico-vue-version]: https://img.shields.io/badge/Vue-2-brightgreen?style=for-the-badge&logo=vue.js
[ico-php-version]: https://img.shields.io/badge/PHP-8.1-brightgreen?style=for-the-badge&logo=php

# Funding
Thank you for any donations 

## Paypal
https://www.paypal.com/donate/?hosted_button_id=95TTM4Z9Q7MNG

# cached-image-resizer
Provide one image, then the multiple images of the given sizes are created and cached. Then placed in our picture element component providing the best image for the end users device. 

# PHP packages needed
Imagick

## adding packages on Ubuntu
sudo apt install php-imagick imagemagick

# Installation
To tell laravel about the PMImageResizer component we have a few options. 
 
## Option 1: 
add the below code to your `resources/js/app.js`
```js
import PMImageResizer from '../../vendor/paulmillband/cached-image-resizer/Components/Picture';
Vue.component("PMImageResizer", PMImageResizer);
```

## Option 2: using the vue component direct from the vendor folder
add ``'@vendor': path.resolve('vendor'),`` to the aliases array in file `/webpack.config.js`

e.g.
```php
module.exports = {
    resolve: {
        alias: {
            ...
            '@vendor': path.resolve('vendor'),
            ...
        },
    },
};
```
then add the below into your .vue code inside the script tag

```js
import PMImageResizer from '@vendor/paulmillband/cached-image-resizer/Components/Picture';
```

## Option 3: Copy the template file
If you have an issue there is always the simple option to create your own template from my file and use that. This also gives the option to create a more customised template.

#Using the component
Adding the component to another component.

```vue
<ImageResizer></ImageResizer>
```

#Technical notes
##Resize
Resize an image

##Crop
Resize And crop to fit size given

##Reformat
Resize and save in a new format e.g. use a webp image and save as a jpg

# Options
## .env
|'image_cache_folder' | cache folder path ( relative to the public path)|

# Testing
vendor/bin/phpunit 

## Run Vue example
npm install
npm run dev

## Run backend php example
composer install
npm run build
vendor/bin/testbench serve
go to http://localhost:8000/index.html