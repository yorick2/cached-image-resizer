![Under Construction][ico-under-construction]

[![License][ico-license]](LICENSE.md)
![Release][ico-in-development]
![Release][ico-release]
![Release][ico-tag]
![Download Size][ico-download-size]
![Last Commit][ico-last-commit]

![Github Top Language][ico-top-language]

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

[ico-top-language]: https://img.shields.io/github/languages/top/yorick2/cached-image-resizer?style=for-the-badge&logoColor=white
[ico-laravel-version]: https://img.shields.io/badge/laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[ico-vue-version]: https://img.shields.io/badge/Vue%202-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white
[ico-php-version]: https://img.shields.io/badge/PHP%208.1-777BB4?style=for-the-badge&logo=php&logoColor=white
[ico-phpunit-version]: https://img.shields.io/badge/PHPUnit-777BB4?style=for-the-badge&logoColor=white
[ico-composer-version]: https://img.shields.io/badge/composer-885630?style=for-the-badge&logo=composer&logoColor=white
[ico-html-version]: https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white
[ico-css-version]: https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white
[ico-js-version]: https://img.shields.io/badge/javascript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=white

# cached-image-resizer
Provide one image, then the multiple images of the given sizes are created and cached. Then placed in our picture element component providing the best image for the end users device. 

# installation
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
