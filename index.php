<?php

include_once 'formkons.php';

$form = new Formkons(array("method"=>"post"));
$form->set_global_wrapper("p");

$name = $form->add_element("input", "name", array("type"=>"text"));
$name->set_label("Name");
$name->set_validation(array('required'));

$choice = $form->add_element("input","choice",array("type"=>"checkbox","value"=>"first"));
$choice->set_label("First choice", "after");
$choice->add_option('second');
$choice->set_label("Second choice", "after");
$choice->set_validation(array('restrict_to_options'=> array('options' =>array('first','second'),'strict'=>true)));

$radiator = $form->add_element("input","radiator",array("type"=>"radio","value"=>"neo"));
$radiator->set_label("Neo","after");
$radiator->add_option('trinity',array("checked"=>"checked"));
$radiator->set_label('Trinity',"after");
//$radiator->set_validation(array('restrict_to_options'=> array('neo','trinity')));

$myfile = $form->add_element("input", "myfile",array("type"=>"file"));
$myfile->set_label("Upload a file");

$submit = $form->add_element("input", "submit", array("type"=>"submit"));


if($form->submitted_and_valid()) {
	echo "Form was submitted<br>\n";
	echo "Name value is ". $name->value ."<br>\n";
	echo "The array of all values: <br>";
	echo "The winer is ". $radiator->value."<br>";
	var_dump($form->values_array());
	echo "<br><br>";
	var_dump($myfile->value);
	
}
else {
	
	echo $form->html();
	//include_once 'form_view.php';
}
