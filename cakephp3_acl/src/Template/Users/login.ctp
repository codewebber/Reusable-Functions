<div class="form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create('',array('id'=>"popup_form")) ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
<!--<div id = "selected-area"></div>-->
<script>
/*$( document ).ready(function() {
	$("#popup_form").validate({
		  rules: { 
	          "email": {
	              required: true,
	              //email : true
	            }
		   },
		   messages: {
	            "email": {
	                required: "Please enter Username",
	                //email : "Please enter valid email"
	              }
		  		}
		  });
}); */
</script>
