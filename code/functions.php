<?php


  function cn($qry,$db) {	
	  if ($db == "") {$db = "conference";}
    $cn = mysql_connect("127.0.0.1","root","B1ackjack") or die(mysql_error());
    //$cn = mysql_connect("127.0.0.1","root","workcraft") or die(mysql_error());
    mysql_select_db($db,$cn) or die(mysql_error());		
    $results = mysql_query($qry) or die(mysql_error());		
		return $results;
	}
	
	/*
	function VideoCheck($file) {	
	  $qry = " select feedpath from videofeeds "
  	        ." where feedpath = '".$file."' ";
		$result = cn($qry, "");
		$result = mysql_num_rows($result);		
		return $result;
	}
	
	function VideoFeedUpdateList($file) {	
	  if (VideoCheck($file)==0) {  		  
  	  $qry = " insert into videofeeds "
    	        ." (feedpath) "
    					." values "
    					." ('".$file."') ";
  		$result = cn($qry, "");
		}
	}
	*/
	
	function ImageCheck($file) {	
	  $qry = " select filepath from images "
  	        ." where filepath = '".$file."' ";
		$result = cn($qry, "");
		$result = mysql_num_rows($result);		
		return $result;
	}
	
	function ImageInsert($fp, $size, $type) {
	  //echo $fp.$size.$type; 
	  $qry = " insert into images "
  	        ." (filepath,size,type) "
  					." values "
  					." ('".$fp."', '".$size."', '".$type."') ";
		$result = cn($qry, "");
		
		return $result;
	}
	
	function ImageUpdate($fp, $cid) {
	  $qry = " update customers "
  	        ." set image = '".$fp."' "
  					." where cid = '".$cid."' ";
						//echo $qry;
		$result = cn($qry, "");
		return $result;
	}
	
	function CustMultiDimenSelect($ary, $value){    
		 foreach($ary as $key => $val){
       if ($val["cid"]==$value) {
    	   $out .= '<option value="'.$val["cid"].'" SELECTED />'.$val["name"];
    	 } else {	 
    	   $out .= '<option value="'.$val["cid"].'" />'.$val["name"];
    	 }
     }		 
  	 return $out;
  }
	
	function SelectVal($ary, $value){  
     if ($value=='') $out .= '<option value="" SELECTED />';  
		 foreach($ary as $key => $val){
       if ($val==$value) {
    	   $out .= '<option value="'.$val.'" SELECTED />'.$val;
    	 } else {	 
    	   $out .= '<option value="'.$val.'" />'.$val;
    	 }
     }		 
  	 return $out;
  }
	
	
  function PrintArray_testing($ary,$step){
	  $step++;  
		$padding = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$padit = cmc($padding,$step);  
		 foreach($ary as $key => $val){
		   if (is_array($val)) {
			   $out .= $padit.'['.$key.']-><br>'.PrintArray_testing($val,$step).'<br>';
			 } else {
		     $out .= $padit.'['.$key.'] = '.$val.'<br>';
			 }
     }		 
  	 return $out;
  }
	
	//concat multiple copies together
	function cmc($string, $multiplyby){
	  while ($multiplyby > 0) {
		  $string .= $string;
			$multiplyby--;
		} 
		return $string;
	}
	
?>