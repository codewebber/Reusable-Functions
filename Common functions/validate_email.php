<?php
	function validate_email($email) {
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			return 'Invalid';
		}else{		
			return 'Valid';
		}

	}
?>
