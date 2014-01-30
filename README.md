FormKons
========

Basicaly forms are objects, right? Objects are fun, but forms are boring. Let's make forms as fun as objects by making them objects.

**This is alpha code** in developpement. You can try to figure out what's happening by yourself at this point. Docummentation will follow.

Basic concepts
--------------

We all agree that code should be separated from design/layout. The part where this principle is most commonly disregarded are forms. Why? Because forms is where layout meets code. Input elements are so highly connected to code that they are code. And here we are.

Formkons considers all active form tags as part of code. These tags are: form, input, textarea, button, select, option and optgroup(*). Fieldset and label are purelly presentational elements.
 
The code should have all controll over this active elements, that's why in formkons, they **must** be rendered by the code, but the code gives you simple methods to controll all attributes. All the other stuff is controlled directly by the design part. However, you have convenience methods that you can use to output your form in a one liner (but you will have less controll in that case).

In few steps
------------

Create a form object with the form tag attributes. If you omit attributes, you will get a default get method form.

```php

$myform = new Formkons($attributes);

```

Use the form object to create elements

```php

$myinput = $myform->add_element('input','myinput', $element_attributes);

```

Now, you can controll your element through the $myinput object. You can add validation methods for example.

```php

$myinput->add_validation($validation_methods_array);

```

You have some convenience methods in your element object. You can add a label or wrap the object in a pair of tags.
 
```php

$myinput->set_label('Please enter your name');
$myinput->set_wrapper('div',$wrapper_tag_attributes_array);

```

You can use your form object $myform to check if the form was submitted


```php

if($myform->submitted_and_valid()) {
    // access your data through the value property
    echo "My input is: " . $myinput->value;
    // or have all the values in an array
    $result = $myform->values_array();
}
else {
  // output the form
}

```
You can output the form qickly with the conveinence method

```php

echo $myform->html();

```

And you've done it. It's conveinient for the developpement phase and eventually for some simple forms. However, if you want to have full controll exit from php (or introduce a view file).
 
```

<?php echo $myform->form_open(); ?>

<div id="fancydiv">
    <p>
    <label for="myinput">Please enter your name:</label>
        <?php echo $myinput->html(); ?>
        <span class='errors'><?php echo $myinput->display_errors(); ?></span>
    </p>
</div>

<!-- and so on, and so on ... you see the pattern -->

<?php echo $myform->form_close(); ?>

```

To be avoided at any price in future developpement
--------------------------------------------------

Formkons should be html agnostic. That means non form tags can only be used optionally or in special convenience methods. All controll over html **must** allways be left to the user.




-------
(\*) *the optgroup tag is actually presentational but at the same time it's a part of select element* 

