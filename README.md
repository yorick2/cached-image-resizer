# cached-image-resizer
Provide one image, then the multiple images of the given sizes are created and cached. Then placed in our picture element component providing the best image for the end users device. 

#installation
To tell laravel about the PMImageResizer component we have a few options. 
 
##Option 1: 
add the below code to your `resources/js/app.js`
```js
import PMImageResizer from '../../vendor/paulmillband/cached-image-resizer/Components/Picture';
Vue.component("PMImageResizer", PMImageResizer);
```

##Option 2: using the vue component direct from the vendor folder
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

##Option 3: Copy the template file
If you have an issue there is always the simple option to create your own template from my file and use that. This also gives the option to create a more customised template.

#Using the component
Adding the component to another component.

```vue
<ImageResizer></ImageResizer>
```
