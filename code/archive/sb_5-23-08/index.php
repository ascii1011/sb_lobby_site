<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>SpeakerBus NY Lobby</TITLE>
<script src="rssticker.js" type="text/javascript">
/***********************************************
* Advanced RSS Ticker (Ajax invocation)- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/
</script>
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="newsticker.css">


</HEAD>
<?php //height:548px ?>
<body>
  <div style="border:solid 3px;border-color:#eee;width:990px;height:606px;">
	  <div class="bdrs" style="width:360px;height:130px;">
		  <?php include "logo.html"; ?>
		</div>
		<div class="bdrs" style="width:628px;height:130px;border-left:thin solid;">
		  <?php include "newsticker.html"; ?>
		</div>
	  <div class="bdrs" style="border-right:solid 3px;width:487px;height:474px;">
		  <?php include "customer.php"; ?>
		</div>
		<div class="bdrs" style="background:black;text-align:center;vertical-align;padding-left:3px;padding-top:50px;width:497px;height:424px;">
		  <?php include "bloom.html"; ?>
		</div>
  </div>
	<?php include "stockticker.html"; ?>
</body>
</html>