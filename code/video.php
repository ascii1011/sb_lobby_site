<?php

	
?>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
	  <td>
       <div align="center" style="background-color:#000000;">
          <OBJECT 
            ID="MediaPlayer" 
          	WIDTH=418 
          	HEIGHT=350 
          	classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" 
          	codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112" 
          	standby="Loading Microsoft Windows Media Player components..."
            type="application/x-oleobject">
          	
              <PARAM 
                NAME="FileName" 
              	VALUE="<?php echo $vars["video"]; ?>"> 
              <PARAM 
							  NAME="ShowControls" 
								VALUE="0"> 
							<PARAM 
							  NAME="ShowDisplay" 
								VALUE="0"> 
							<PARAM 
							  NAME="ShowStatusBar" 
								VALUE="0"> 
							<PARAM 
							  NAME="AutoSize" 
							  VALUE="0"> 
							<PARAM 
							  NAME="AutoStart" 
								VALUE="true">
              
              <Embed 
							  NAME="MediaPlayer"
                type="application/x-mplayer2" 
              	pluginspage="http://www.microsoft.com/windows/windowsmedia/download/AllDownloads.aspx/" 
              	filename="<?php echo $vars["video"]; ?>" 
              	src="<?php echo $vars["video"]; ?>" 
              	ShowControls=0 
              	ShowDisplay=0 
              	ShowStatusBar=0 
              	autostart=true 
              	width=418 
              	height=350> 
              </embed>
          </OBJECT>
      </div>
<script language="javascript"> 
   if (pluginlist.indexOf("Windows Media Player")!=-1){
	 }else{
	   document.write('<p align="center"><strong><a href="http://www.microsoft.com/windows/windowsmedia/default.mspx" target="_blank">You do not have Windows Media Player, Click here to Download</a></strong></p>');
	 }</script>
</td></tr></table>















