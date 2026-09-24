<?php
function check_user_pass_reappear_btn_hide($user_id)
{
	$result = false;
	global $conn;
	$final_result = $conn->Execute("SELECT is_pass FROM user_final_test_master WHERE is_pass=1 and user_id=".$user_id." ORDER By final_test_id DESC LIMIT 1");
	if($final_result->RowCount()>0){
		$result = true;
		return $result;
	}else
	{
		return $result;
	}
}


function check_final_eligibility($user_id)
{ 

	global $conn;
	$result = $conn->Execute("SELECT chapter_id FROM chapter_master cm WHERE cm.topic_id IN (SELECT ut.topic_id FROM user_topics ut, topic_master tm WHERE ut.topic_id=tm.topic_id AND tm.is_communication=0 AND ut.user_id=$user_id) AND cm.chapter_id NOT IN (SELECT chapter_id FROM user_chapter_test_master WHERE user_id=$user_id AND is_pass=1)");
	
	if($result->RowCount() == 0)
	{
		$hideshow = "SELECT final_test_id FROM user_final_test_master where user_id=".$user_id;
		$exec = $conn->Execute($hideshow);
		if($exec->RowCount() == 0)
		{
			return true;
		}
		else
		{
			$hideshow = "SELECT request_status FROM user_request where request_status='Approved' AND user_id=".$user_id;
			$exec = $conn->Execute($hideshow);
			if($exec->RowCount() > 0)
			{
				return true;
			}
		}
	}
	return false;
}

function check_final_reappear($user_id)
{
	global $conn;
	$result = $conn->Execute("SELECT chapter_id FROM chapter_master cm WHERE cm.topic_id IN (SELECT ut.topic_id FROM user_topics ut,topic_master tm WHERE ut.topic_id=tm.topic_id AND tm.is_communication=0 AND ut.user_id=$user_id) AND cm.chapter_id NOT IN (SELECT chapter_id FROM user_chapter_test_master WHERE user_id=$user_id AND is_pass=1)");
	if($result->RowCount() == 0)
	{
		$hideshow = "SELECT final_test_id FROM user_final_test_master where user_id=".$user_id;
		$exec = $conn->Execute($hideshow);
		
		$hideshow = "SELECT request_status FROM user_request where request_status='Pending' AND user_id=".$user_id;
		$exec1 = $conn->Execute($hideshow);
		if($exec->RowCount() > 0 && $exec1->RowCount() == 0)
		{
			return true;
		}
	}
	return false;
}

function convertPrice($price)
{
		if($_SESSION["currency"]=="USD"){
		$c_price = $_SESSION["currency"]." ".$price;
		}
		else{
		$query = "select currency_value from currency_master where currency_symbol='".$_SESSION['currency']."'";
			global $conn;
			$result  = $conn->Execute($query);
			$data = $result->FetchRow();
			$c_price = $price * $data['currency_value'];
			$c_price = $_SESSION["currency"]." ".$c_price;
		}
		return $c_price;
}	//Set Message


	function setMsg($str) {
		$_SESSION[SESSION_PREFIX.'msg']=$str;
	}
	
	//Print Message Array from session
	function getMsg($cls='') {
		$cls=trim($cls);
		if(isset($_SESSION[SESSION_PREFIX.'msg'])) {
			$tmp_msg=$_SESSION[SESSION_PREFIX.'msg'];
			unset($_SESSION[SESSION_PREFIX.'msg']);
			if(is_array($tmp_msg)) {
				if($cls=='') {
					print('<ul>');
				}else {
					print('<ul class="'.$cls.'">');					
				}
				foreach($tmp_msg as $tmp) {
					print('<li>'.$tmp.'</li>');
				}
				print "</ul>";
			}
			else {
				if($cls=='') {
					print($tmp_msg);
				} else {
					print('<span class="'.$cls.'">'.$tmp_msg.'</span>');
				}
			}
		}
	}


	//Remove XSS
function RemoveXSS($val){ 
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed 
   // this prevents some character re-spacing such as <java\0script> 
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs 
   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val); 
   // straight replacements, the user should never need these since they're normal characters 
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29> 
   $search = 'abcdefghijklmnopqrstuvwxyz'; 
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()'; 
   $search .= '~`";:?+/={}[]-_|\'\\'; 

   for ($i = 0; $i < strlen($search); $i++) { 
      // ;? matches the ;, which is optional 
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
      // &#x0040 @ search for the hex values 
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ; 
      // &#00064 @ 0{0,7} matches '0' zero to seven times 
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ; 
   } 

   // now the only remaining whitespace attacks are \t, \n, and \r 
   $ra1 = Array('javascript', 'vbscript', '<expression', '<applet', 'meta', '<xml', '<link', '<script', 'script>','&lt;script','script&gt;', '<embed', '<object', 'iframe', '<frame', 'frameset', 'ilayer', '<layer', 'bgsound', '<title'); 

   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 

   $ra = array_merge($ra1, $ra2); 
   $found = true; // keep replacing as long as the previous round replaced something 
   
   while ($found == true) { 
      $val_before = $val; 
      for ($i = 0; $i < sizeof($ra); $i++) { 
         $pattern = '/'; 
         for ($j = 0; $j < strlen($ra[$i]); $j++) { 
            if ($j > 0) { 
               $pattern .= '('; 
               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?'; 
               $pattern .= '|(&#0{0,8}([9][10][13]);?)?'; 
               $pattern .= ')?'; 
            } 

            $pattern .= $ra[$i][$j]; 
         } 
         $pattern .= '/i'; 
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
//		print $val."  -  ";
//		if(strtolower($val)!="description")
			 $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
			 
         if ($val_before == $val) { 
            // no replacements were made, so exit the loop 
            $found = false; 
         } 
      } 
   } 

   str_replace("desc<x>ription","description",$val);
   return $val; 
} 

//Function to use before sending data to a query
function str_prepare($string,$xss=false)
{
	$string=trim($string);
	if(get_magic_quotes_gpc()) 
	{
		if(ini_get('magic_quotes_sybase'))
		{
			$string= str_replace("''", "'", $string);
		}
		else
		{
			$string = stripslashes($string);
		}
	}
	if($xss)
	{
		$string=RemoveXSS($string);
	}
	$string=str_replace("\\r\\n","<br>",$string);
	$string=str_replace("\r\n","<br>",$string);
	//$string=mysql_real_escape_string($string);
	return $string;
}

function output($string)
{
	print stripslashes(replace_newline(html_entity_decode($string,ENT_QUOTES)));
}

function replace_newline($string, $replace='') {
	$order   = array("\\r\\n","\r\n","\n","\r");
	$replace = '<br />';
  return (string)str_replace($order, $replace, $string);
}


	//A substring function which maintain word boundaries
	function smartSubstr($str,$len,$lines=0) {
		$l=strlen($str);
		$j=0;
		$result='';
		if($len<$l) {
			for($i=$len;$i<$l;$i++) {
				$tmp=$str[$i];
				if($tmp==' ') {
					break;
				}
				$j++;
			}
			$result=substr($str,0,($len+$j));
		}else {
			$result=$str;
		}
		if($lines>0) {
			$arr=explode("\r\n",$result);
			$lc=count($arr);
			if($lines==1) {
				$result=$arr[0];
			}else {
				$out='';
				for($i=0;$i<$lines;$i++) {
					if($i<$lc) {
						//if(trim($arr[$i]) !='') {
							$out.=$arr[$i]."\r\n";
						//}
					}else {
						break;
					}
				}
				$result=$out;
			}
		}
		return $result;
	}
	
	
	//Translation function
	function tl($var,$out=true) {
		global $language;
		if(isset($language[$var])) {
			$output=$language[$var];
		}else {
			$output=$var;
		}
		if($out) {
			print($output);
		}else {
			return $output;
		}
	}
	
	function debugMsg($msg) {
		global $_debugMessages;
		if(isset($msg)) {
			$msg=trim($msg);
			if($msg!='') {
				$_debugMessages[]=$msg;
			}
		}
	}

	function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

function dateDiff($endDate, $beginDate, $type='days')
{
	$endDate=strtotime($endDate);
	$beginDate=strtotime($beginDate);
	$diff=$endDate - $beginDate;

	if($type=='days')
		$div=60*60*24;
	else if($type=='hours')
		$div=60*60;
	else if($type=='min')
		$div=60;
	else
		$div=1;
	$diff1=$diff/$div;
	return $diff1;

}


	//Fetch config for a module from Database
	function fetchDbConfig($confName) {
		global $conn;
		$result = $conn->Execute("SELECT array FROM ".TABLE_PREFIX."config WHERE cname = '$confName'");
		if($result && $result->RecordCount()>0){
			$base64Encoded = unserialize($result->fields['array']);
			foreach($base64Encoded as $key => $value){
				$decoded[base64_decode($key)] = stripslashes(base64_decode($value));
			}
			$clean=array();
			foreach($decoded as $key => $value){
				if(strcasecmp($value,'true')==0) {
					$clean[$key]=true;
					continue;
				}
				if(strcasecmp($value,'false')==0) {
					$clean[$key]=false;
					continue;
				}
				$clean[$key]=$value;
			}
			return $clean;
		} else {
			return FALSE;
		}
	}
	
	//Write config to Database
	function writeDbConf($confName, $values) {
		global $conn;
		if (is_array($values)) {
			if (count($values) < 1){
				return false;
			}
			else {
				// serialise the array for DB storage bas64 encode to stop serialize bug
				foreach($values as $key => $value) {
					$value = str_replace(array("\'","'"),"&#39;",$value);
					$newConfigBase64[base64_encode($key)] = base64_encode($value);
		
				}
				$configText = serialize($newConfigBase64);
				// see if database config exists
				$result = $conn->Execute("SELECT count(*) AS c FROM ".TABLE_PREFIX."config WHERE cname = '$confName'");
				//$tmp=$result->fields;
				if($result->fields['c']>0) {
					$conn->AutoExecute(TABLE_PREFIX.'config',array('array'=>$configText),'UPDATE',"cname='$confName'",true,MAGIC_QUOTES);
				} else {
					$conn->AutoExecute(TABLE_PREFIX.'config',array('array'=>$configText),'INSERT',false,true,MAGIC_QUOTES);
				}
				return true;
			}
		}
		else {
			return false;
		}
	}

// Generate a random password
function generate_password($length = 8)
{
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
 
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
} 

	function persons_age($BirthDate) {
		if(isset($BirthDate)) {
			list($year, $month, $day) = split('[-.]', $BirthDate);
			$tmonth = date('n');
			$tday = date('j');
			$tyear = date('Y');
			$years = $tyear - $year;
			if ($tmonth <= $month)
			{
			  if ($month == $tmonth)
			  {
				  if ($day > $tday)
					  $years--;
			  }
			  else
				  $years--;
			}
		}
		else {
			$years='N.A';
		}
		return $years;
	}
	
	function prep($str) {
		return trim(htmlentities($str));
	}


function check_email_address($email) 
{
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
} 

function rgb2array($rgb) {
    $r = base_convert(substr($rgb, 1, 2), 16, 10);
	$g = base_convert(substr($rgb, 3, 2), 16, 10);
	$b = base_convert(substr($rgb, 5, 2), 16, 10);

	return array($r,$g,$b);
}

function array_querystring($arr)
{
	$qrystr="?";
	$ctr = 1;
	foreach($arr as $key=>$value)
	{
		if($ctr == 1)
			$qrystr .= $key."=".$value;
		else
			$qrystr .= "&".$key."=".$value;
		
		$ctr++;
	}
	return $qrystr;
}

function log_issue($issue_log) {
	global $conn;
	$user_id = $_SESSION[SESSION_PREFIX.'USER_ID'];
	$issue = array();
	$issue["log_value"] = $issue_log;
	$issue["user_id"] = $user_id;
	$issue["log_date"] = date('Y-m-d H:i:s');
     $issue_insert = $conn->Autoexecute("security_log",$issue, "INSERT", true, false, MAGIC_QUOTES);
}

function induction_complete() {

    global $conn;
	$sql = "SELECT GROUP_CONCAT(page_id) as ids FROM cms_master ORDER BY page_id";
	$res = $conn->Execute($sql);
	$row = $res->FetchRow();
	$keys = explode(",",$row['ids']);
	
	$complete = true;
	
    foreach ( $keys as $key ) {
	
        if ( !isset( $_SESSION[SESSION_PREFIX.'pageViewed'][$key] )) {
            $complete = false;
			break;
        }
    }
	$_SESSION[SESSION_PREFIX.'INDUCTION_COMPLETE'] = $complete;
	
	if($complete)
	{
		$sql = "UPDATE user_master set induction_complete=1 WHERE user_id=".$_SESSION[SESSION_PREFIX.'USER_ID'];
		$res = $conn->Execute($sql);
	}
	
	return $complete;
    
}

?>