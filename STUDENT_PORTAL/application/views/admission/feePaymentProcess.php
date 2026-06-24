<form action="<?php echo PROD_GATEWAY_URL; ?>" method="post" name="txnSubmitFrm">
	<h4 class="text-center">Redirecting To Payment Please Wait..</h4>
	<h4 class="text-center">Please Do Not Press Back Button OR Refresh Page</h4>
	<input type="hidden" size="200" name="merchantRequest" id="merchantRequest" value="<?php echo $merchantRequest; ?>"  />
	<input type="hidden" name="MID" id="MID" value="<?php echo $reqMsgDTO->getMid(); ?>"/>
</form>
<script  type="text/javascript">
	//submit the form to the worldline
	document.txnSubmitFrm.submit();
</script>
