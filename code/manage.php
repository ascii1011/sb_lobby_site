<?php
include "functions.php";
/*
			echo 'ary:<pre>';
			echo print_r($_REQUEST);
			echo '</pre>';
	*/		
/////////process requests/////////////


if ($_REQUEST["current"]=="update") {
  if (is_numeric($_REQUEST["custid"])) {	
	  //updates video feed info (if new inserts, else nothing)
		//VideoFeedUpdateList($_REQUEST['video']);
	  $_REQUEST["symbols"] = str_replace(" ", "", $_REQUEST["symbols"]);  
	  $query = " update settings "
	        ." set cid = '".$_REQUEST["custid"]."', " 
	        ." video = '".$_REQUEST["video"]."', " 
	        ." symbols = '".$_REQUEST["symbols"]."' " 
					." where sid = '1' ";
		$results = cn($query, "");
		if ($results==1) {
		  $result = 'Settings were updated successfully.';
		} else {
		  $result = 'An error has occured with this process, please try again or contact support.';
		}
	}
} else if ($_REQUEST["create"]=="create") {
  $name = addslashes(nl2br(strip_tags($_REQUEST["name"])));
  $intro = addslashes(nl2br(strip_tags($_REQUEST["intro"])));
  $descr = addslashes(nl2br(strip_tags($_REQUEST["descr"])));
  $msg = addslashes(nl2br(strip_tags($_REQUEST["msg"])));
  $image = addslashes(nl2br(strip_tags($_REQUEST["image"])));
		
	$query = " insert into customers "
	        ." (name, intro, descr, msg, image) "
					." values "
					." ('".$name."', '".$intro."', '".$descr."', '".$msg."', '".$image."') ";
					
	$results = cn($query, "");			
		if ($results==1) {
		  $result = 'Profile {'.ucfirst($name).'} was created successfully.';
			$_REQUEST['image'] = '';
		} else {
		  $result = 'An error has occured with this process, please try again or contact support.';
		}		
} else if ($_REQUEST["edit"]=="update") {
  $name = addslashes(nl2br(strip_tags(strtolower($_REQUEST["name"]))));
  $intro = addslashes(nl2br(strip_tags(strtolower($_REQUEST["intro"]))));
  $descr = addslashes(nl2br(strip_tags(strtolower($_REQUEST["descr"]))));
  $msg = addslashes(nl2br(strip_tags(strtolower($_REQUEST["msg"]))));
  $image = addslashes(nl2br(strip_tags(strtolower($_REQUEST["image"]))));
		  
	$query = " update customers "
	        ." set name = '".$_REQUEST["name"]."', " 
	        ." intro = '".$_REQUEST["intro"]."', "
	        ." descr = '".$_REQUEST["descr"]."', "
	        ." msg = '".$_REQUEST["msg"]."', "
	        ." image = '".$_REQUEST["image"]."' "
					." where cid = '".$_REQUEST["cid"]."' ";
					
	$results = cn($query, "");			
		if ($results==1) {
		  $result = 'Profile {'.ucfirst($name).'} was updated successfully.';
		} else {
		  $result = 'An error has occured with this process, please try again or contact support.';
		}		
}else if ($_REQUEST["edit"]=="delete") {
  
	if ($_REQUEST["cid"]!=0) {
	  $query = "delete from customers where cid = '".$_REQUEST["cid"]."' ";
					
	  $results = cn($query, "");			
		if ($results==1) {
		  $result = 'The record was deleted successfully.';
			$_REQUEST["cid"] = "";
		} else {
		  $result = 'An error has occured with this process, please try again or contact support.';
		}		
	}
}

if (!$_REQUEST["dest"]) $_REQUEST["dest"] = "settings";
if (!$_REQUEST["cid"]) $_REQUEST["cid"] = "1";

////////////////////end process requests/////////////////////
		
//grab customer list
  $query = " select * from customers order by cid asc ";
  $results = cn($query, "");	
  $total = mysql_num_rows($results);  
  if ($total > 0 ) {		 		
	    $cnt=0;
								 
      while ($items = mysql_fetch_array($results)) {
        	 $cust[$cnt]["cid"] = $items["cid"];
        	 $cust[$cnt]["name"] = $items["name"];
					 $cnt++;
			}
	}
//end grab customer list


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

function grabCustomerInfo($cid) {
  $query = " select * from customers "
          ." where cid = '".$cid."' ";
        $results = cn($query, "");	
        
    		$row = mysql_fetch_array($results);
        $cust["cid"] = $row["cid"];
        $cust["name"] = $row["name"];
        $cust["intro"] = $row["intro"];
        $cust["descr"] = $row["descr"];
        $cust["msg"] = $row["msg"];
        $cust["image"] = $row["image"];
        mysql_close();

				return $cust;
}

/*
function grabVideoList() {
    $query = " select feedpath from videofeeds order by vid ";
    $results = cn($query, "");	        
    
		$i=0;
    while ($row = mysql_fetch_array($results)) {
      $set[$i] = $row["feedpath"];
			$i++;
    }
    mysql_close();

		return $set;
}
*/

function grabImageList() {
    $query = " select filepath from images order by iid ";
    $results = cn($query, "");	        
    
		$i=0;
    while ($row = mysql_fetch_array($results)) {
      $set[$i] = $row["filepath"];
			$i++;
    }
    mysql_close();

		return $set;
}

/*
			echo 'ary:<pre>';
			echo print_r($cust);
			echo '</pre>';
			*/
			//PrintArray_testing($curr, 0);
	

if ($_REQUEST["dest"]=="settings") {
  $curr = grabCurrentSettings();
	//$videos = grabVideoList();
  $body = '<table border="0" width="100%">'
          .'<tr>'
        	  .'<td><form action="manage.php" method="post">'
        		   .'<table border="0" width="100%">'
                 .'<tr>'
        	         .'<td>'
    							 				.'Set profile '
        		       .'</td>'
        	         .'<td>'
        					 	.'	 &nbsp;<select style="width:400px" name="custid">'.CustMultiDimenSelect($cust, $curr['cust']['cid']).'</select>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td colspan="2" height="40" valign="bottom">'
        					 	.'	 <b>Settings</b>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td>'
        					 	.'<div>Video Feed:</div>'
        		       .'</td>'
        	         .'<td>'
									  //.'	 <!--select style="width:400px" name="video">'.SelectVal($videos, $curr["video"]).'</select-->'
        					 	.'<div><input style="width:400px;" type="text" name="video" value="'.$curr["video"].'" /></div>'
									 .'</td>'
									.'</tr>'
									.'<tr>'
        	         .'<td>'
        					 	.'<div>Symbols:</div>'
        		       .'</td>'
        	         .'<td>'
        					 	.'<div><textarea name="symbols" rows="4" style="width:400px;">'.$curr["symbols"].'</textarea></div>'
									 .'</td>'
        	       .'</tr>'
									.'<tr>'
									 .'<td colspan="2">'
									 				.'<input type="hidden" name="dest" value="settings" />'
    							 				.'<input type="submit" name="current" value="update" />'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td colspan="2" height="40" valign="bottom">'
        					 	.'	 <b>Customer Information</b>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td>'
        					 	.'<div>Name:</div>'
        		       .'</td>'
        	         .'<td>'
        					 	.'<div>'.$curr["cust"]["name"].'</div>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td>'
        					 	.'<div>Introduction:</div>'
        		       .'</td>'
        	         .'<td>'
        					 	.'<div>'.$curr["cust"]["intro"].'</div>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td colspan="2">'
        					 	.'<div>'.$result.'</div>'
        		       .'</td>'
        	       .'</tr>'
        			 .'</table>'
        		.'</form></td>'
        	.'</tr>'
					.'</table>';
} else if ($_REQUEST["dest"]=="new") {
  $imagelist = grabImageList();
  $body = '<table border="0" width="100%">'
          .'<tr>'
        	  .'<td width="200" style="border-right:thin solid;margin-top:70px;" valign="top">'
						  .'<select multiple size="22" style="width:180px;">'.CustMultiDimenSelect($cust, 0).'</select>'
        		.'</td>'
        	  .'<td><form action="manage.php" method="post">'
        		   .'<table border="0">'
                 .'<tr>'
        	         .'<td colspan="2" height="40" valign="top">'
        					 	.'	 <b>Create a customer profile</b>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td>'
        					 	.'<div>Name:</div>'
        		       .'</td>'
        	         .'<td>'
        					 	.'<div><input style="width:300px;" type="text" name="name" /></div>'
        		       .'</td>'
        	       .'</tr>'
                 .'<tr>'
        	         .'<td>'
        					 	.'<div>Intro:</div>'
        		       .'</td>'
        	         .'<td>'
        					 	.'<div><textarea name="intro" rows="4" style="width:300px;"></textarea></div>'
        		       .'</td>'
        	       .'</tr>'
								 
                         .'<tr>'
                	         .'<td>'
                					 	.'<div>Image:</div>'
                		       .'</td>'
                	         .'<td>'
													  .'	 <select name="image" style="width:300px;">'.SelectVal($imagelist, $_REQUEST['image']).'</select>'
                		       .'</td>' 
                	       .'</tr>'
												 
												 
								 
                         .'<tr>'
                	         .'<td>'
									 				.'<input type="hidden" name="dest" value="new" />'
    							 				.'<input type="submit" name="create" value="create" />'
													.'</form>'
                		       .'</td>' 
                	       .'</tr>'
												 
												 
								 .'<tr>'
								 										
        	     .'<table>'
        					.'<tr>'					
                	  .'<td colspan="2" style="width:300px;border:thin solid;">'
        						  .'<form method="post" ENCTYPE="multipart/form-data" ACTION="importer.php">'
                      .'<div style="padding-top:5px;">'
											  .'Import Image'
											.'</div>'
                      .'<div style="float:left;">'
									 			 .'<input type="hidden" name="dest" value="new" />'
        								 .'<input type="hidden" name="cid" value="'.$_REQUEST["cid"].'" />'
											   .'<div><input TYPE="FILE" NAME="file1" VALUE="testfile" SIZE="25" MAXLENGTH="1024"></div>'
                         .'<div><INPUT TYPE=SUBMIT VALUE="Import">'
                         .'<input TYPE="RESET" NAME="Cancel" VALUE="Reset"></div>'		
											.'</div>'												
        						  .'</form>'
                		.'</td>'						
                	.'</tr>'
        			 .'</table>'
							 
							  .'</tr>'
        	       .'<tr>'
        	         .'<td colspan="2">'
        					 	.'<div>'.$result.'</div>'
        		       .'</td>'
        	       .'</tr>'
        			 .'</table>'
        		.'</td>'
        	.'</tr>'
					.'</table>';

					
//						  .'<select multiple size="22" style="width:180px;">'.CustMultiDimenSelectWithOnclick($cust, 0).'</select>'
					
} else if ($_REQUEST["dest"]=="edit") {

  $custedit = grabCustomerInfo($_REQUEST["cid"]);
  $imagelist = grabImageList();
	
	
			/*echo 'ary:<pre>';
			echo print_r($custedit);
			echo print_r($imagelist);
			echo '</pre>';*/
	
  $body = '<table border="0" width="100%">'
          .'<tr>'
        	  .'<td width="200" style="border-right:thin solid;margin-top:70px;" valign="top">'
						  .'<select multiple size="22" style="width:180px;" onchange="if (this.selectedIndex > -1) document.location.href=\'manage.php?dest=edit&cid=\' + this.value;">'
							  .CustMultiDimenSelect($cust, 0)
							.'</select>'
        		.'</td>'  	  
						.'<td>'						
        		   .'<table border="0"><tr><td><form action="manage.php" method="post">'
    								 .'<table>'
										     .'<tr>'
                	         .'<td colspan="2" height="40" valign="top">'
                					 	.'	 <b>Edit a customer profile</b>'
                		       .'</td>'
                	       .'</tr>'
                         .'<tr>'
                	         .'<td>'
                					 	.'<div>Name:</div>'
                		       .'</td>'
                	         .'<td>'
                					 	.'<div><input style="width:300px;" value="'.$custedit["name"].'" type="text" name="name" /></div>'
                		       .'</td>'
                	       .'</tr>'
                         .'<tr>'
                	         .'<td>'
                					 	.'<div>Intro:</div>'
                		       .'</td>'
                	         .'<td>'
                					 	.'<div><textarea name="intro" rows="4" style="width:300px;">'.$custedit["intro"].'</textarea></div>'
                		       .'</td>'
                	       .'</tr>'
                         .'<tr>'
                	         .'<td>'
                					 	.'<div>Image:</div>'
                		       .'</td>'
                	         .'<td>'
													  .'	 <select name="image" style="width:300px;">'.SelectVal($imagelist, $custedit["image"]).'</select>'
                		       .'</td>' //.'<div><input style="width:300px;" value="'.$custedit["image"].'" type="text" name="image" /></div>'
                	       .'</tr>'
                	       .'<tr>'
                	         .'<td colspan="2">'
        													.'<input type="hidden" name="cid" value="'.$_REQUEST["cid"].'" />'
        									 				.'<input type="hidden" name="dest" value="edit" />'
        									 				.'<div style="padding-top:20px;">'
            							 				.'<input type="submit" name="edit" value="update" />'
            							 				.'<input type="submit" name="edit" value="delete" />'
        													.'</div>'
                		      .'</tr>'
												.'</table></form></td>'
										.'</tr><tr>'
												.'<td>'												
        	     .'<table>'
        					.'<tr>'					
                	  .'<td colspan="2" style="width:300px;border:thin solid;">'
        						  .'<form method="post" ENCTYPE="multipart/form-data" ACTION="importer.php">'
                      .'<div style="padding-top:5px;">'
											  .'Import Image'
											.'</div>'
                      .'<div style="float:left;">'
									 			 .'<input type="hidden" name="dest" value="edit" />'
        								 .'<input type="hidden" name="cid" value="'.$_REQUEST["cid"].'" />'
											   .'<div><input TYPE="FILE" NAME="file1" VALUE="testfile" SIZE="25" MAXLENGTH="1024"></div>'
                         .'<div><INPUT TYPE=SUBMIT VALUE="Import">'
                         .'<input TYPE="RESET" NAME="Cancel" VALUE="Reset"></div>'		
											.'</div>'												
        						  .'</form>'
                		.'</td>'						
                	.'</tr>'
        			 .'</table>'							 
												.'</td>'
												.'</tr><table>'		
									 .'</td>'
									 
							 
							 
        		.'</td>'	
					.'</tr>'
					.'</table>';


 
}
?>

<HTML>
<HEAD>
<TITLE></TITLE>
<script>
function Chart(qs)
{
	window.location.href = 'manage.php' + qs;
}		
</script>
<script language="JavaScript" type="text/javascript">
<!--
//-->
</script>
<?php //<link rel="stylesheet" type="text/css" href="style.css"> ?>
</HEAD>

<body>



<div style="font-size:6px;font-family:Arial;width:800px;border:thin solid;">
<table border="0">
  <tr>
	  <td style="border-bottom:thin solid;width:798px;">
		   <table border="0" width="796px">
         <tr>
	         <td height="80" valign="top">
					 		 <div>
							 <a href="index.php">
               <img style="margin:12px 0 0 10px;border:0px;float:left;" src="type_B_voice_with.jpg" width="340" height="100" />
							 </a>
							 </div>
							 <div style="float:left;padding-top:98px;padding-left:40px;"><?php echo $result; ?></div>
               
		       </td>
	         <td>
					 		 &nbsp;
		       </td>
	       </tr>
			 </table>
		</td>
	</tr>
  <tr>
	  <td>
		   <table border="0" width="100%">
         <tr>
	         <td width="110" valign="top" style="border-right:solid thin;">
					 
    					 <table border="0">
                 <tr>
        	         <td>
        					 		 <a href="manage.php?dest=settings">Settings</a>
        		       </td>
        	       </tr>
                 <tr>
        	         <td>        					 		 
        					 		 <a href="manage.php?dest=new">New Profile</a>
        		       </td>
        	       </tr>
                 <tr>
        	         <td>
        					 		 <a href="manage.php?dest=edit">Edit Profile</a>
        		       </td>
        	       </tr>
                 <tr>
        	         <td>
        					 		&nbsp; 
        		       </td>
        	       </tr>
        			 </table>
					 		 
		       </td>
	         <td style="width:500px;">
					 		 <?php echo $body; ?>
		       </td>
	       </tr>
			 </table>
		</td>
	</tr>
</table>
</div>



</body>
</html>	