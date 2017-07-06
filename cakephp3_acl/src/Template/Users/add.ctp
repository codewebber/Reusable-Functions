<script>
$( document ).ready(function() {
	 //alert('hi');
    $('.creload').on('click', function() {
        var mySrc = $(this).prev().attr('src');
        var glue = '?';
        if(mySrc.indexOf('?')!=-1)  {
            glue = '&';
        }
        $(this).prev().attr('src', mySrc + glue + new Date().getTime());
        return false;
    });

	$('.valid_capcha').on('click',function() {
		var captcha = $('#securitycode').val();
		if(captcha == "")
		{
			$('#captch_msg').html("Please enter security code");
		}
		else
		{
		 $.ajax({
			    type: 'POST',
			    url: '<?php echo $this->request->webroot;?>users/validation_captcha',
			    data: {captcha:captcha},
			    cache: false,
			    success: function (data){
			    	if(data == 1)
					{
						$('#captch_msg').html("Invalid security code please try again");
						
					}
			}
		 });
		}
	});	
	 $('input#securitycode').keypress(function(e) {
		 $('#captch_msg').html("");
	 });
    
});
    </script>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('group_id', ['options' => $groups]);
	    echo $this->Captcha->create('securitycode'); //$settings are optional
        ?>
	<span id = "captch_msg" style = "color:red;"><?php if($msg) { echo $msg; }?></span>
    </fieldset>
    <?= $this->Form->button('Submit',array('class'=>'valid_capcha')) ?>
    <?= $this->Form->end() ?>
</div>
<!--<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Captcha->create('securitycode'); //$settings are optional
        ?>
        <span id = "captch_msg" style = "color:red;"><?php if($msg) { echo $msg; }?></span>
        <?php echo $this->Form->input('image_path', ['label' => 'Image','type' => 'file']); ?>
    </fieldset>
    <?= $this->Form->button('Submit',array('class'=>'valid_capcha')) ?>
    <?= $this->Form->end() ?>
</div>-->
