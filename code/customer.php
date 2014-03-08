<?php

//////grab settings/////////
$query = " select * from settings where sid = '1' ";
$results = cn($query, "");	

while ($row = mysql_fetch_array($results)) {
$cid = $row["cid"];
$image_id = $row["image_id"];
$bg_id = $row["bg_id"];
mysql_close();  
}
//////end settings//////


//////grab current customer/////
if ($cid) {
    $query = " select * from customers "
      ." where cid = '".$cid."' ";
    $results = cn($query, "");	
    
//    while ($row = mysql_fetch_array($results)) {
		$row = mysql_fetch_array($results);
    $name = $row["name"];
    $intro = $row["intro"];
    $descr = $row["descr"];
    $msg = $row["msg"];
    $cimage = $row["image"];
    mysql_close();  
//    }
} else {
    $name = "";
    $intro = "Welcome to SpeakerBus";
    $descr = "";
    $msg = "";
		$cimage = "";
}
//////end current customer///////
$name_align = 'center';
$name_size = '38';
$name_font = 'arial';
$name_weight = 'bold';
$name_style = 'italic';
function cssTmpl($align, $size, $font, $weight, $style) {
  $txt = ($align ? 'text-align:'.$align.';' : '');
  $txt .= ($size ? 'font-size:'.$size.'px;' : '');
  $txt .= ($font ? 'font-family:'.$font.';' : '');
  $txt .= ($weight ? 'font-weight:'.$weight.';' : '');
  $txt .= ($style ? 'font-style:'.$style.';' : '');
	$txt = ($txt ? ' style="'.$txt.'" ' : '');
	return $txt;
}
//Georgia,"Times New Roman",Times,Tahoma,Verdana,Arial,serif;
?>

<HTML>
<HEAD>
<TITLE></TITLE>
<!--meta http-equiv="refresh" content="60"-->
<script language="JavaScript" type="text/javascript">
<!--
function loadit(theImage, form) {
  //form.result.value = "";
  document.getElementById("fi").src = theImage;
	//document.images[0].width = document.images[0].width / 200 - 3 + '%';
	//document.images[0].height = document.images[0].height / 140 - 3 + '%';
	
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
	//document.write(rsize + '<br>' + dif + '<br>' + rwd + '=' + wd + '=' + document.images[0].width + '<br>' +rhg + '=' + hg + '=' + document.images[0].height);
	
	//document.getElementById("fi").width = wd;
	//document.getElementById("fi").height = hg;
	//document.images[1].width = wd;
	//document.images[1].height = hg;
	
	document.getElementById("fi").width = wd;
	document.getElementById("fi").height = hg;
}
//-->
</script>
</HEAD>

<?php 
  if ($cimage) {
		$tmp = 'onload="loadit(\''.$cimage.'\',this.form)"';
	}
?>
<body <?php echo $tmp; ?> >
<?php
/************variables available from DB*************
*$descr
*$intro
*$name
*$msg
*****************************************************/

?>

<div style="height:460px;color:#00529b;">
    <table border="0" width="100%">
       <tr>
    	    <td height="90" style="padding:4px">
    			  &nbsp;
    			</td>
    	 </tr>
       <tr>
    	    <td height="60" style="padding:4px">
    			<?php echo '<div'.$class.cssTmpl($name_align,$name_size,$name_font,$name_weight,$name_style).'>SPEAKERBUS</div>'; ?></td>
    	 </tr>
       <tr>
    	    <td height="60" style="padding:4px">
    			  <?php echo '<div'.$class.cssTmpl($name_align,$name_size,$name_font,$name_weight,$name_style).'>'.$intro.'</div>'; ?>
    			</td>
    	 </tr>
       <tr>
    	    <td height="54" style="padding:4px">
    			  <?php echo '<div'.$class.cssTmpl($name_align,$name_size,$name_font,$name_weight,$name_style).'>'.$name.'</div>'; ?>
    			</td>
    	 </tr>
       <tr>
    	    <td style="padding:4px;text-align:center;">
    			  <img name="fi" src="<?php echo $cimage; ?>" alt="">
    			</td>
    	 </tr>
       <tr>
    	    <td height="90" style="padding:4px">
    			  &nbsp;
    			</td>
    	 </tr>
    </table>
</div>

</body>
</html> 