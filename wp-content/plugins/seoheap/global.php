<?php
plugin('base');
function selectbox($name,$opts,$curr=0,$attr='') {
	if (!is_array($opts)) {
		if (empty($name))
			return false;
		echo '<input type="text" readonly="readonly" name="',htmlq($name),'" value="',htmlq($opts),'"/>';
	}
	if (count($opts)<2) {
		foreach ($opts as $k=>$a) {
			echo '<input type="hidden" name="',htmlq($name),'" value="',htmlq($k),'"/>',html($a);
			return;
		}
	}
	echo '<select';
	if (is_array($curr)) {
		echo ' multiple="multiple" title="Ctrl+Click to select multiple options"';
		$name=rtrim($name,'[]').'[]';
	}
	if (!empty($name))
		echo ' name="'.htmlq($name).'"';
	if (!empty($attr))
		echo ' ',trim($attr);
	echo '>';
	foreach ($opts as $k=>$a) {
		echo '<option';
		if ((string)$k!=(string)$a)
			echo ' value="',htmlq($k),'"';
		if (is_array($curr))
			echo (in_array($k,$curr)) ? ' selected="selected"' : '';
		else
			echo ((string)$k===(string)$curr) ? ' selected="selected"' : '';
		echo '>',html($a),'</option>';
	}
	echo '</select>';
}
function printr($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
function nocache() {
	header("Expires: Sun, 14 Mar 1982 07:30:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("Cache-Control: no-store, no-cache, must-revalidate"); 
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");	
}
function json($c) {
	header('Content-Type: application/json');
	nocache();
	echo json_encode($c);
	exit;
}
function plugin($name='') {
	static $plugins=array();
	static $pluginobj=false;
	if (is_object($name))
		return $pluginobj=$name;
	if ($name=='')
		return $pluginobj;
	$name=basename($name);
	if (!$name)
		return;
	if (isset($plugins[$name]))
		return;
	$root=dirname(__FILE__).'/plugins/'.$name;
	if (!is_dir($root) || !is_file($root.'/include.php'))
		return;
	include $root.'/include.php';
	$plugins[$name]=1;
}
function qsql($sql,$parent=false,$flags=0) {
	$s=strtoupper((preg_match('#^\s*([a-z]+)#i',$sql,$r)) ? $r[1] : '');
	if ($s=='INSERT') {
		mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		return mysql_insert_id();
	} elseif ($s=='SELECT' || $s=='SHOW') {
		$o=array();
		$child=false;
		if (preg_match('#^(.*?)=>(.*?)$#',$parent,$r)) {
			$parent=$r[1];
			$child=$r[2];
		}
		$q=mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		while ($a=mysql_fetch_assoc($q)) {
			if ($parent===true) {
				$o=$a;
				break;
			} elseif ($parent!==false && ($flags & 1))
				@$o[$a[$parent]]=($child) ? $a[$child] : $a;
			elseif ($parent!==false)
				@$o[$a[$parent]][]=($child) ? $a[$child] : $a;
			 else
				$o[]=($child) ? $a[$child] : $a;
		}
		if (count($o)==0)
			return array();
		return $o;
	} else {
		mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		return mysql_affected_rows();
	}
}
function sqlq($value) {
	return '\''.mysql_escape_string($value).'\'';
}
function html($i) {
	$i=mb_convert_encoding($i,'HTML-ENTITIES','UTF-8');
	$i=htmlspecialchars($i,NULL,'UTF-8',false);
	//return $i;
	return preg_replace('#£|\xC2\xA3#u','&pound;',$i);
}
function htmlq($i) {
	$i=mb_convert_encoding($i,'HTML-ENTITIES','UTF-8');
	$i=htmlspecialchars($i,ENT_QUOTES,'UTF-8',false);
	//return $i;
	return preg_replace('#£|\xC2\xA3#u','&pound;',$i);
}
function stripslashes_gpc(&$value) {
	$value=stripslashes($value);
}
function req($value,$default='') {
	if (isset($_REQUEST[$value])) {
		if (is_string($_REQUEST[$value]))
			return ((get_magic_quotes_gpc()) ? stripslashes($_REQUEST[$value]) : $_REQUEST[$value]);
		else
			return $_REQUEST[$value];
	}
	return $default;
}
function reqi($value,$default=0) {
	return intval(isset($_REQUEST[$value]) ? $_REQUEST[$value] : $default);
}
function reqf($value,$default=0) {
	return floatval(isset($_REQUEST[$value]) ? $_REQUEST[$value] : $default);
}
function reqa($value,$default=array()) {
	if (!isset($_REQUEST[$value]) || !is_array($_REQUEST[$value]))
		return $default;
	$value=$_REQUEST[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value,'stripslashes_gpc');
	return $value;
}

function get($value,$default="") {
	return isset($_GET[$value]) ? ((get_magic_quotes_gpc()) ? stripslashes($_GET[$value]) : $_GET[$value]) : $default;
}
function geti($value,$default=0) {
	return intval(isset($_GET[$value]) ? $_GET[$value] : $default);
}
function getf($value,$default=0) {
	return floatval(isset($_GET[$value]) ? $_GET[$value] : $default);
}
function geta($value,$default=array()) {
	if (!isset($_GET[$value]) || !is_array($_GET[$value]))
		return $default;
	$value=$_GET[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value, 'stripslashes_gpc');
	return $value;
}
function post($value,$default="") {
	if (isset($_POST[$value])) {
		if (is_string($_POST[$value]))
			return ((get_magic_quotes_gpc()) ? stripslashes($_POST[$value]) : $_POST[$value]);
		else
			return $_POST[$value];
	}
	return $default;
}
function posti($value,$default=0) {
	return intval(isset($_POST[$value]) ? $_POST[$value] : $default);
}
function postf($value,$default=0) {
	return floatval(isset($_POST[$value]) ? $_POST[$value] : $default);
}
function posta($value,$default=array()) {
	if (!isset($_POST[$value]) || !is_array($_POST[$value]))
		return $default;
	$value=$_POST[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value,'stripslashes_gpc');
	return $value;
}
function allpost() {
	$o=$_POST;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
function allget() {
	$o=$_GET;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
function allreq() {
	$o=$_REQUEST;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
function htmlarray($a) {
	ob_start();
	_htmlarray($a);
	$a=ob_get_contents();
	ob_end_clean();
	return $a;
};
function _htmlarray($o) {
	echo '<ul class="htmlarray">';
	foreach ($o as $k=>$a) {
		if (empty($a))
			continue;
		echo '<li><b>',html($k),': </b> ';
		if (is_object($a) && get_class($a)=='ishtml')
			echo $a->html;
		elseif (is_array($a))
			_htmlarray($a);
		else {
			echo html((string)$a);
		}
		echo '</li>';
	}
	echo '</ul>';
}
function tidystring($content) {
	$c=strip_tags($content);
	$c=trim(preg_replace('#[\r\n\s\t]+#',' ',$c));
	$c=trim(preg_replace('#\[[^\]]+\]#','',$c));
	return $c;
}
function snippet($string, $word_limit) {
	$words = explode(' ',tidystring($string));
	return implode(' ', array_slice($words, 0, $word_limit));
}
function _encryptdecrypt($t,$hash=false) {
	$r=sha1(NONCE_SALT.SECURE_AUTH_KEY.AUTH_KEY.$hash);
	$c=0;
	$v='';
	for ($i=0;$i<strlen($t);$i++) {
		if ($c==strlen($r))
			$c=0;
		$v.=substr($t,$i,1)^substr($r,$c,1);
		$c++;
	}
	return $v;
}
function encrypt($t,$hash=false){
	$t=json_encode($t);
	srand((double)microtime()*1000000);
	$r=md5(rand(0,32000));
	$c=0;
	$v='';
	for ($i=0;$i<strlen($t);$i++){
		if ($c==strlen($r))
			$c=0;
		$v.=substr($r,$c,1).(substr($t,$i,1)^substr($r,$c,1));
		$c++;
	}
	return base64_encode(_encryptdecrypt($v,$hash));
}
function decrypt($t,$hash=false) {
	$t=_encryptdecrypt(base64_decode($t),$hash);
	$v='';
	for ($i=0;$i<strlen($t);$i++){
		$md5=substr($t,$i,1);
		$i++;
		$v.=(substr($t,$i,1)^$md5);
	}
	return json_decode($v,true);
}
function expiry($time) {
	return str_replace('=','%',encrypt($time));
}
function expired($code) {
	$time=(decrypt(str_replace('%','=',$code)));
	if (!is_numeric($time) || time()>$time)
		return false;
	return $time-time();		
}
function testcaptcha() {
	if (!isset($_SESSION['captchapassed'])) {
		$captchapassed=0;
		foreach ($_REQUEST as $k=>$a) {
			if (preg_match('#^captcha\-([a-f0-9]{32})(.+)$#',$k,$r)) {
				$a=strtoupper($a);
				$hash=decrypt($r[2],$r[1]);	
				if (expired($hash) && captchacode($r[1].$r[2])==$a)
					$captchapassed=$_SESSION['captchapassed']=1;
				else {
					unset($_SESSION['captchapassed']);
					$captchapassed=0;
				}
			}
		}
	} else
		$captchapassed=$_SESSION['captchapassed'];
	define('CAPTCHA',$captchapassed);
}

function captcha($attr='') {
	$code=expiry(time()+(16*60*60));
	$c=md5(microtime());
	$c=$c.encrypt($code,$c);
	echo '<img src="/captcha/captcha.png?code=',urlencode($c),'" alt="Captcha" class="captchaimg"/>';
	echo '<input type="text" name="captcha-',htmlq($c),'" ',$attr,'/>';
}
function captchacode($md5) {
	$q='ABCDEFGHJKLMNPQRTWXY346789';
	$l=strlen($q);
	$j=strlen($md5);
	$v=str_split(md5(decrypt($q)));
	for ($n=0;$n<$j;$n++) {
		$r=ord($md5[$n]);
		$a=$r % 5;
		$v[$a]+=$r;
	}
	$k='';
	for ($n=0;$n<5;$n++) {
		$a=$v[$n] % $l;
		$k.=$q[$a];	
	}
	return $k;
}

