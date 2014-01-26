<?php echo $form->form_open(); ?>
<p>
<?php echo $name->html(); ?>
	<?php echo $name->display_errors(); ?>
</p>
<p>
<?php echo $choice->html(); ?>
	<?php echo $choice->display_errors(); ?>
</p>
<p>
<?php echo $radiator->html(); ?>
	<?php echo $radiator->display_errors(); ?>
</p>
<p>
<?php echo $submit->html(); ?>
</p>
<?php echo $form->form_close(); ?>

