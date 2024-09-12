![Under Construction][ico-under-construction]

[![License][ico-license]](LICENSE.md)
![Release][ico-in-development]
![Release][ico-release]
![Release][ico-tag]
![Download Size][ico-download-size]
![Last Commit][ico-last-commit]

![UNIT TESTS][ico-unit-tests]

![Github Top Language][ico-top-language]

![Laravel version][ico-laravel-version]
![Vue version][ico-vue-version]
![PHP version][ico-php-version]
![PHPUNIT version][ico-phpunit-version]
![COMPOSER version][ico-composer-version]
![HTML version][ico-html-version]
![CSS version][ico-css-version]
![Javascript][ico-js-version]

[ico-under-construction]: https://img.shields.io/badge/UNDER%20CONSTRUCTION!-red?style=for-the-badge

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge
[ico-in-development]: https://img.shields.io/badge/Release-Development-yellow?style=for-the-badge
[ico-release]: https://img.shields.io/github/v/release/yorick2/cached-image-resizer?style=for-the-badge
[ico-tag]: https://img.shields.io/github/v/tag/yorick2/cached-image-resizer?style=for-the-badge
[ico-download-size]: https://img.shields.io/github/languages/code-size/yorick2/cached-image-resizer?style=for-the-badge
[ico-last-commit]: https://img.shields.io/github/last-commit/yorick2/cached-image-resizer?style=for-the-badge

[ico-unit-tests]: https://github.com/yorick2/cached-image-resizer/actions/workflows/UnitTests.yml/badge.svg

[ico-top-language]: https://img.shields.io/github/languages/top/yorick2/cached-image-resizer?style=for-the-badge&logoColor=white
[ico-laravel-version]: https://img.shields.io/badge/laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[ico-vue-version]: https://img.shields.io/badge/Vue%202-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white
[ico-php-version]: https://img.shields.io/badge/PHP%208.1-777BB4?style=for-the-badge&logo=php&logoColor=white
[ico-phpunit-version]: https://img.shields.io/badge/PHPUnit-777BB4?style=for-the-badge&logoColor=white
[ico-composer-version]: https://img.shields.io/badge/composer-885630?style=for-the-badge&logo=composer&logoColor=white
[ico-html-version]: https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white
[ico-css-version]: https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white
[ico-js-version]: https://img.shields.io/badge/javascript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white

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

## useful file paths locations
| description | file path |
| -------- | ------- |
| public path in vite laravel workbench | vendor/orchestra/testbench-core/laravel/public |

## Run Vue example
** terminal 1 **
vendor/bin/testbench serve

** terminal 2 **
// having issues with npm run dev. I assume it cos of the proxy. May fix later
npm install
npm run build
npm run preview

Go to the url npm states. For me its http://localhost:5173

## Run backend php example
composer install
npm run build
vendor/bin/testbench serve
go to http://localhost:8000 to check the server loaded ok
go to http://localhost:8000/index.html
