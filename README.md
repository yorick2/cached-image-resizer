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

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=for-the-badge
[ico-in-development]: https://img.shields.io/badge/Release-Development-yellow?style=for-the-badge
[ico-release]: https://img.shields.io/github/v/release/yorick2/cached-image-resizer?style=for-the-badge
[ico-tag]: https://img.shields.io/github/v/tag/yorick2/cached-image-resizer?style=for-the-badge
[ico-download-size]: https://img.shields.io/github/languages/code-size/yorick2/cached-image-resizer?style=for-the-badge
[ico-last-commit]: https://img.shields.io/github/last-commit/yorick2/cached-image-resizer?style=for-the-badge

[ico-unit-tests]: https://github.com/yorick2/cached-image-resizer/actions/workflows/UnitTests.yml/badge.svg

[ico-top-language]: https://img.shields.io/github/languages/top/yorick2/cached-image-resizer?style=for-the-badge&logoColor=white
[ico-laravel-version]: https://img.shields.io/badge/laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[ico-vue-version]: https://img.shields.io/badge/Vue%203-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white
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
```shell script
sudo apt install php-imagick imagemagick
```

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
import PictureComponent from '@vendor/paulmillband/cached-image-resizer/Components/Picture';
```

## Option 3: Copy the template file
If you have an issue there is always the simple option to create your own template from my file and use that. This also gives the option to create a more customised template.

#Using the component
Adding the component vue page

```vue
<PictureComponent
    :shouldCrop="true"
    extension="webp"
    src="700x700.jpg"
    alt="alt text"
    :sizesAttribute="['200w', '400w', '600w']"
    :requiredWidthSizes="['200', '400', '600']"
    :requiredHeightSizes="['0', '0', '0']"
    loading=""
/>
```

For svgs allowing a fallback image of specified extension is created
```vue
  <PictureSvgComponent
      alt="alt"
      :fallbackImageHeight="0"
      :fallbackImageWidth="400"
      fallbackImageExtension="webp"
      svg="laptop-400X266.svg"
  loading=""
    />
```

[see some more examples](./App.vue)

#Technical notes
New image created with the given specification if, its been previously created and found in the cache folder "public/images/cache".

## The cache
The cache folder isn't cleared automatically and cached files needs to be removed after changes to the original file for them to be seen. If there is an issue a new file using a cached image after all cached files have been removed I would suggest removing the **contents** of the cache folder and ensure all server/cdn caching is refreshed.

##SVGs
Fallback image of specified extension created

##Resize
Resize the image to the exact dimensions given, unless 0 is given where that measurement is calculated to scale

##Resize and Crop
Resize and crop to fit size given. If one size is 0 it uses the current size for that axis. If -1 is used for a crop coordinate then the image is cropped centrally

##Resize and reformat
Resize the image to the exact dimensions given, unless 0 is given where that measurement is calculated to scale. Then a different format image created e.g. use a jpeg image and save as a webp

##Resize,crop and reformat
Resize, crop to fit size given and reformat. If one size is 0 it uses the current size for that axis. If -1 is used for a crop coordinate then the image is cropped centrally. Then a different format image created e.g. use a jpeg image and save as a webp

# Options
## .env
|'image_cache_folder' | cache folder path ( relative to the public path)|

# Testing
```shell script
vendor/bin/phpunit
```

## useful file paths locations
| description | file path |
| -------- | ------- |
| public path in vite laravel workbench | vendor/orchestra/testbench-core/laravel/public |

## Run Vue example
** terminal 1 **
```shell script
composer install
vendor/bin/testbench serve
```

** terminal 2 **
```shell script
npm install
npm run dev
```

or for full build testing
```shell script
npm install
npm run build
npm run preview
```

Go to the url npm states. For me its http://localhost:5173

## Run backend php example
```shell script
composer install
npm run build
vendor/bin/testbench serve
go to http://localhost:8000 to check the server loaded ok
go to http://localhost:8000/index.html
```
