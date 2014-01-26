<?php

include_once 'formkons.php';

$form = new Formkons(array("method"=>"post"));


$name = $form->add_element("input", "name", array("type"=>"text"));
$name->set_label("Name");
$name->set_validation(array('required'));

$choice = $form->add_element("input","choice",array("type"=>"checkbox","value"=>"first"));
$choice->set_label("First choice", "after");
$choice->add_option('second');
$choice->set_label("Second choice", "after");

$radiator = $form->add_element("input","radiator",array("type"=>"radio","value"=>"neo"));
$radiator->set_label("Neo","after");
$radiator->add_option('trinity',array("checked"=>"checked"));
$radiator->set_label('Trinity',"after");

$submit = $form->add_element("input", "submit", array("type"=>"submit"));


if($form->submitted_and_valid()) {
	echo "Form was submitted<br>\n";
	echo "Name value is ". $name->value ."<br>\n";
	echo "The array of all values: <br>";
	echo "The winer is ". $radiator->value."<br>";
	var_dump($form->values_array());
	
}
else {
	
	echo $form->html();
	//include_once 'form_view.php';
}
