<?php 
  
    include "functions.php";
/* Class. */
Class yahoo
{
    /* Function. */
    function get_stock_quote($symbol)
    {
        // Yahoo! Finance URL to fetch the CSV data.
        $url = sprintf("http://finance.yahoo.com/d/quotes.csv?s=$symbol&f=sl1d1t1c1ohgv&e=.csv", $symbol);
        $fp  = fopen($url, 'r');
        if (!fp) {
            echo 'Error : cannot recieve stock quote data.';
        } else {
            $data = @fgetcsv($fp, 4096, ', '); 
            fclose($fp);
            $this->symbol = $data[0]; // Stock symbol.
            $this->last   = $data[1]; // Last Trade (current price).
						$this->change = $data[4]; // + or - amount change.
						$this->changecolor = $this->Color($this->change);
						$this->changeimage = $this->Image($this->change);
						$this->change = $this->Change($this->change);
						$this->volume = $this->Format_Volume($data[8]);
        }
    }
				
		//format change
		function Change($str) 
		{  		
      $str = str_replace("+", "", $str);
      $str = str_replace("-", "", $str);
		  return $str;
		}
				
		//format changeimage
		function Image($str) 
		{
      $first = $str{0};
  		
      if ($first == '+') {       // If we gained print the # in GREEN.
          $str = 'up1.gif';
      } elseif ($first == '-') { // If we lost RED.
          $str = 'down3.gif';
      } else {                   // NO color.
          $str = 'stay4.gif';
      } 
		  return $str;
		}
				
		/*format changecolor*/
		function Color($str) 
		{
      $first = $str{0};
  		
      if ($first == '+') {       // If we gained print the # in GREEN.
          $str = 'rssChangeUp';
      } elseif ($first == '-') { // If we lost RED.
          $str = 'rssChangeDown';
      } else {                   // NO color.
          $str = 'rssChangeStay';
      } 
		  return $str;
		}
		
		
		
		/*Format Volume*/
		function Format_Volume($str) 
		{
  		$len = strlen($str);
  		
  		if ($len<4) {
  		  $dif = 3;
  			$dot = 4;
  		  $sym = '@';
  		} else if ($len > 3 && $len < 7) {
  		  $dif = $len - 2;
  		  $sym = 'K@';
  			$dot = $len-3;
  		} else if ($len > 6 && $len < 10) {
  		  $dif = $len - 5;
  		  $sym = 'M@';
  			$dot = $len-6;
  		} else if ($len > 9 && $len < 13) {
  		  $dif = $len - 8;
  		  $sym = 'B@';
  			$dot = $len-9;
  		}
			
  		$newvol = '';
  		for ($i=0; $i<$dif; $i++) {
  			$newvol .= $str[$i];
  		  if ($i==$dot-1) {
  			  $newvol .= '.';
  			}
  		}
  		return $newvol.$sym;		
		}
}

    function grabSettings() {
        //////grab settings/////////
        $query = " select * from settings where sid = '1' ";
        $results = cn($query, "");	
        
				$i = 0;
        while ($row = mysql_fetch_array($results)) {
				  $symbols = trim($row["symbols"]);
          mysql_close();  
        }
    		return $symbols;
    }
		
 		function populate()
		{ 
      // Stock symbols.
			$sym = grabSettings();
      $symbols = explode(',',$sym);
      //$symbols = file('stocks2.xml');

      /*$symbols = array('^GSPC',
    		'BAC','PFE','C','VZ','T','GM',
    		'MO','JPM','GE','DD','MRK','HD',
    		'MCD','CVX','JNJ','KO','BT','INTC');
      $symbols = array('^GSPC');*/

      /*
      $symbols = array('^GSPC',
      		'BAC','PFE','C','VZ','T','GM',
      		'MO','JPM','GE','DD','MRK','HD',
      		'MCD','CVX','JNJ','KO','BT','INTC',
      		'MMM','PG','CAT','BA','AA','UTX',
      		'WMT','AIG','AXP','MSFT','XOM','IBM',
      		'DIS','HPQ','GC','BP','CL','TB','YR','RL');
      
      */
		
			$quote = new yahoo; // new stock.
		  $i = 0;
      $fo = '<?xml version="1.0" ?><rss version="2.0" ><channel>';      
      foreach ($symbols as $symbol) {
          $quote->get_stock_quote($symbols[$i++]); // Pass the Company's symbol.
      				
      		$fo .= '<item>'
      				.'<symbol>'.$quote->symbol.'</symbol>'
      				.'<last>'.$quote->last.'</last>'
      				.'<change>'.$quote->change.'</change>'
      				.'<changecolor>'.$quote->changecolor.'</changecolor>'
      				.'<changeimage>'.$quote->changeimage.'</changeimage>'
      				.'<volume>'.$quote->volume.'</volume>'
      				.'</item>';      				
      }      
      $fo .= '</channel></rss>';
      echo $fo;		
		}
		
		populate();

		
?>