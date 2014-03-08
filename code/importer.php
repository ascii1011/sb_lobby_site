<?php
  include "functions.php";
  
	/*
			echo 'ary:<pre>';
			echo print_r($_REQUEST);
			echo print_r($_FILES);
			echo '</pre>';
  */			
			
	//move_uploaded_file ($_FILES['file1'] ['tmp_name'],
    //   "iimages/{$_FILES['file1'] ['name']}"); 
		//echo "iimages/{$_FILES['file1'] ['name']}";
		//echo file_exists("iimages/{$_FILES['file1'] ['name']}");
		//exit;
	//if (!file_exists("iimages/{$_FILES['file1'] ['name']}"))
	//{	

			  //import
				//0 = error
				//1 = file exists
				//2 = error inserting into listing
				//3 = error updating customer info
				//4 = successful
				
	if ($_REQUEST['dest']=='edit'){
  	if (ImageCheck("iimages/{$_FILES['file1'] ['name']}") == 0) {
  	
          if (move_uploaded_file ($_FILES['file1'] ['tmp_name'], "iimages/{$_FILES['file1'] ['name']}") )
        	{			
        			if (ImageInsert("iimages/{$_FILES['file1']['name']}",$_FILES['file1']['size'],$_FILES['file1']['type'])) 
        			{
        				if (ImageUpdate("iimages/{$_FILES['file1']['name']}",$_REQUEST['cid']))
        				{
          		    header("Location:manage.php?dest=edit&import=4&cid=".$_REQUEST['cid']);
        				} else {
          		    header("Location:manage.php?dest=edit&import=3&cid=".$_REQUEST['cid']);
        				}
          		} else {
          		  header("Location:manage.php?dest=edit&import=2&cid=".$_REQUEST['cid']);
          		}	
        	} else {
          	header("Location:manage.php?dest=edit&import=1&cid=".$_REQUEST['cid']);
        	}
  	} else {
  	
  				if (ImageUpdate("iimages/{$_FILES['file1']['name']}",$_REQUEST['cid']))
  				{
    		    header("Location:manage.php?dest=edit&import=5&cid=".$_REQUEST['cid']);
  				} else {
    		    header("Location:manage.php?dest=edit&import=6&cid=".$_REQUEST['cid']);
  				}
  	}
	} elseif ($_REQUEST['dest']=='new') {
	 	if (ImageCheck("iimages/{$_FILES['file1'] ['name']}") == 0) {
  	
          if (move_uploaded_file ($_FILES['file1'] ['tmp_name'], "iimages/{$_FILES['file1'] ['name']}") )
        	{			
        			if (ImageInsert("iimages/{$_FILES['file1']['name']}",$_FILES['file1']['size'],$_FILES['file1']['type'])) 
        			{echo 4;
          		  header("Location:manage.php?import=4&dest=new&name=".$_REQUEST['name']."&intro=".$_REQUEST['intro']."&image=iimages/{$_FILES['file1'] ['name']}");
          		} else {echo 2;
          		  header("Location:manage.php?import=2&dest=new&name=".$_REQUEST['name']."&intro=".$_REQUEST['intro']);
          		}	
        	} else {echo 1;
          	header("Location:manage.php?import=1&dest=new&name=".$_REQUEST['name']."&intro=".$_REQUEST['intro']);
        	}
  	} else {
      header("Location:manage.php?import=5&dest=new&name=".$_REQUEST['name']."&intro=".$_REQUEST['intro']."&image=iimages/{$_FILES['file1'] ['name']}");
  	}
	}
	 
	//} else {
	//  echo "file already exists";
	//}

  
	  

?>