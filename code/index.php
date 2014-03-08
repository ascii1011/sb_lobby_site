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

<script language="JavaScript" type="text/javascript">
<!--resize of customer image
function loadit(theImage, form) {
  document.getElementById("fi").src = theImage;
	
	var size = 240;
	var rsize = size/60;
	var wd = document.getElementById("fi").width;
	var hg = document.getElementById("fi").height;
	var rwd = wd/60;
	var rhg = hg/60;	
	
	if (hg > wd) 
	{	  
		if (hg > size) 
		{
			var dif = size/hg;
  		hg = (rhg - (rhg - rsize)) * 60;
  		wd = (rwd*dif) * 60;		
		} else {
	    wd = document.getElementById("fi").width;
	    hg = document.getElementById("fi").height;		
		}
	} else if (wd > hg) 
	{
	  if (wd > size)
		{
			var dif = size/wd;
  		wd = (rwd - (rwd - rsize)) * 60;
  		hg = (rhg*dif) * 60;
		} else {
	    wd = document.getElementById("fi").width;
	    hg = document.getElementById("fi").height;		
		}
	} else 
	{
		var dif = (rwd-rsize)*.9;
	  if (wd > size) 
		{
		  hg = (rhg-dif)*(60);	
			wd = (rwd-dif)*(60);
		} else {
		  hg = (rhg-(rhg*.9))*(60);	
			wd = (rwd-(rwd*.9))*(60);
		}
	}	
	document.getElementById("fi").width = wd;
	document.getElementById("fi").height = hg;
}
//end of resize of customer image-->
</script>

<?php
  include "functions.php";

    function grabCurrentSettings() {
        //////grab settings/////////
        $query = " select * from settings where sid = '1' ";
        $results = cn($query, "");	
        
        while ($row = mysql_fetch_array($results)) {
        $set["cid"] = $row["cid"];
        $set["image_id"] = $row["image_id"];
        $set["video"] = $row["video"];
        $set["symbols"] = $row["symbols"];
        mysql_close();  
        }
        
        //////grab current customer/////
        if ($set["cid"]) {
            $query = " select * from customers "
              ." where cid = '".$set["cid"]."' ";
            $results = cn($query, "");	
            
        		$row = mysql_fetch_array($results);
            $set["cust"]["cid"] = $row["cid"];
            $set["cust"]["name"] = $row["name"];
            $set["cust"]["intro"] = $row["intro"];
            $set["cust"]["descr"] = $row["descr"];
            $set["cust"]["msg"] = $row["msg"];
            $set["cust"]["image"] = $row["image"];
            mysql_close();  
        }
    		return $set;
    }
	$vars = grabCurrentSettings();
 
  if ($cimage) {
		$tmp = 'loadit(\''.$cimage.'\',this.form);';
	}
	
?>
<script language="JavaScript" type="text/javascript">
<!--no scroll bar attempt
    var IE = (navigator.userAgent.indexOf('MSIE') != -1);
    
    function no_scrollbar()
    {
    	if(!IE)
    		return;
    	var root = document.all[1]; // IE >= 4
    
    	if(root.style.overflow != 'auto')
    		root.style.overflow = 'auto';
    	document.body.style.width = root.clientWidth + 'px';
    }
    function init()
    {
		  <?php echo $tmp ?>
    	no_scrollbar();
    
    	if(IE)
    		onresize = ie_tweaks;
    }
-->
</script>

<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="newsticker.css">


</HEAD>
<?php //height:548px ?>
<body  <?php echo $tmp; ?> >
  <div style="border:solid 3px;border-color:#eee;width:990px;height:606px;">
	  <div class="bdrs" style="width:330px;height:130px;">
		  <?php include "logo.html"; ?>
		</div>
		<div class="bdrs" style="width:630;height:130px;border-left:thin solid;">
		  <div style="width:608px;height:130px;float:left;border: 0px solid;">
			  <?php include "newsticker.html"; ?>
			</div>			
 
  		<div style="width:48px;height:130px;float:left;border: 0px solid;">
  		  <img 
				  src="img/bbc-news-logo.jpg" 
					style="width:48px;height:38px;background:#00529b;float:left;" alt="">
  		</div>
		</div>
		
	  <div class="bdrs" style="border-right:solid 3px;width:487px;height:474px;">
		  <?php include "customer.php"; ?>
		</div>
		<div class="bdrs" style="background:black;text-align:center;vertical-align;padding-left:3px;padding-top:50px;width:497px;height:424px;">
		  <?php include "video.php"; ?>
		</div>
  </div>
	<?php include "stockticker.html"; ?>
</body>
</html>