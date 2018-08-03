# multiple-featured-post-images

Wordpress plugin that enables multiple featured images in post types

### Installation

Just a regular wp plugin installation

### How to setup new images

Using this plugin is just a matter of setting the your image data and getting the image url later.

Set the image data in your functions.php file or elsewhere:

```php
if ( class_exists('AMad_Multiple_Featured_Images') ) {
    $mfi = new AMad_Multiple_Featured_Images();
    $mfi->register_image(array('custom_image', 'Custom Image'));
    $mfi->run();
}
```

1. The code checks if the main plugin class exists, just for safety
2. ```custom_image``` is the id (slug) for the image data
3. ```Custom Image``` is the title of the metabox seen while editing the post
4. Then run the plugin code

### Get the selected image

To get the url for the selected image:

```php
$mfi->get_image_url( $post_id, 'custom_image' );
```

### Contributions

Are always welcome.
