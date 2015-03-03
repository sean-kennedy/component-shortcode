# Component Shortcode

A simple Wordpress shortcode to load decoupled template-parts outside of a theme folder, load template code within `the_content()` area and pass in variables.

Perfect for use with the fantastic [Advanced Custom Fields](http://www.advancedcustomfields.com/) plugin.

## Why have a component shortcode?

Traditionally, using custom fields or theme template-parts requires custom logic of some sort in the Wordpress theme files. This is not ideal as it means your content is tightly coupled to your theme.

Adding the ability to load these templates from a `/wp-content/components/` folder allows themes to be swapped around without having to migrate custom template code. Templates can also be loaded in the middle of `the_content()`.

Additionally, passing in variables from the shortcode allows a large amount of flexibility in your template logic (passing in class names, colours, other fields etc).

## Usage

Install the Component Shortcode plugin.

Use the shortcode in any content areas. The only required attribute is template:

`[component template="my_template"]`

Create the `my_template.php` template file in `/wp-content/components/` and add your custom theme code.

That's all that's required to start using components!

### Passing in variables

The shortcode can also take any number of custom attributes that become variables available to you in your template file:

`[component template="my_template" class="blue" is_featured="true" test="blah"]`

Then in your template code these variables will become available in an array called `$cs_vars`:

```
<?php

echo $cs_vars['template']; // my_template.php
echo $cs_vars['class']; // blue
echo $cs_vars['is_featured']; // true
echo $cs_vars['test']; // blah

// All variables
foreach($cs_vars as $key => $value) {
	echo $key.' = '.$value.'<br>';
}
	
?>
```

Note the template value will also become available (in case you want to use it).

## Why use with Advanced Custom Fields?

ACF is an awesome plugin, it's by far the best solution for extending Wordpress content. ACF has its [own shortcode](http://www.advancedcustomfields.com/resources/shortcode/) but unfortunately it only works for text based values.

Fields like repeater and flexible content require template code to display the content to the user. The template code can be placed into template-parts (partials) and loaded via Wordpress's `get_template_part()` function, however this only searches within the theme directory.

There is also no way to load say a repeater field in the middle of `the_content()`. Component Shortcode fixes these shortcomings.

#### ACF Example:

Install Component Shortcode and create an ACF field.

Add this to the a page/post body text:

`[component template="my_acf_template" field="acf_field_name"]`

Then in `/wp-content/components/` create a file named `my_acf_template.php` and insert your normal ACF template code.

Inside `my_acf_template.php` you can then use the ACF field:

```
<?php if (have_rows($cs_vars['field'])) : ?>

	<ul>

	<?php while (have_rows($cs_vars['field'])) : the_row();
		
		$sub_field = get_sub_field('sub_field');
 
		?>
		
		<li><?php echo $sub_field; ?></li>
 
	<?php endwhile; ?>
	
	</ul>
 
<?php endif; ?>
```

That's it! When `the_content()` is called the ACF template will be loaded in (even in between text) no matter which theme you use.