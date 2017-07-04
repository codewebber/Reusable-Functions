<script>
/** before running this need to include latest jquery library file**/
$( document ).ready(function() {
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
            echo $this->Form->input('email');
            echo $this->Form->input('password');
	   /****************** below line for display captcha *************/
            echo $this->Captcha->create('securitycode'); 
           /******************* ends here ******************/
        ?>
        <span id = "captch_msg" style = "color:red;"><?php if($msg) { echo $msg; }?></span>
        <?php echo $this->Form->input('image_path', ['label' => 'Image','type' => 'file']); ?>
    </fieldset>
    <?= $this->Form->button('Submit',array('class'=>'valid_capcha')) ?>
    <?= $this->Form->end() ?>
</div>
