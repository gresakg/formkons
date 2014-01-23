<?php

include_once 'konform.php';

$form = new Konform();

$submit = $form->add_element("input", "Submit", "submit");

echo $form->html();

