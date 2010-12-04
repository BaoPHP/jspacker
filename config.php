<?PHP
#################################################################################
## Copyright (C) 2008 by Manifest Interactive                                  ##
## http://www.ManifestInteractive.com                                          ##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ##
## LICENSE                                                                     ##
## Redistribution and use in source and binary/encoded forms, with or          ##
## without modification, is not permitted.                                     ##
##                                                                             ##
## THIS SOFTWARE IS PROVIDED BY MANIFEST INTERACTIVE 'AS IS' AND ANY           ##
## EXPRESSED OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE         ##
## IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR          ##
## PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL MANIFEST INTERACTIVE BE          ##
## LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR         ##
## CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF        ##
## SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR             ##
## BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,       ##
## WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE        ##
## OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,           ##
## EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                          ##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ##
## Author of file: Peter Russell Schmalfeldt                                   ##
#################################################################################

## TEST FOR CONNECTION TO THIS FILE DIRECTLY
if($_SERVER['PHP_SELF'] == '/config.php') die('You cannot access this file directy.');

## SET CONNECTION FOR OTHER FILES TO VALIDATE
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL & ~E_NOTICE); 
session_start();

function getmicrotime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

if(strlen($_POST['src']) > 0 || $_FILES['srcfile']) {
	
	$treat = false;
	
	$time = getmicrotime();
	$timelimit = 5;
	if(isset($_SESSION['SearchTime'])){
		$seconds = round(($time-$_SESSION['SearchTime']),2);
		if($seconds < $timelimit) sleep(($timelimit - $seconds));
		else $_SESSION['SearchTime'] = $time;
	}
	else {
		$_SESSION['SearchTime'] = $time;
	}
	
	require 'class.JavaScriptPacker.php';
	
	$error = '';
	$script = '';
	
	if(strlen($_POST['src']) > 0 && $_FILES['srcfile']['error'] == UPLOAD_ERR_NO_FILE){
		$script = $_POST['src'];
	}
	else if($_FILES['srcfile']['error'] != UPLOAD_ERR_NO_FILE){
		switch($_FILES['srcfile']['error']){
			case UPLOAD_ERR_OK:
				if($_FILES['srcfile']['size'] < 307200 && ($_FILES['srcfile']["type"] == "application/x-js" || $_FILES['srcfile']["type"] == "application/x-javascript" || $_FILES['srcfile']["type"] == "text/plain")){
					$fp = fopen($_FILES['srcfile']['tmp_name'], 'r');
					$script = fread($fp, $_FILES['srcfile']['size']);
					$script = addslashes($script);
					fclose($fp);
				} else {
					$error = "The file uploaded could not be used. Only JavaScript (.js) and Text (.txt) files accepted.";
				}
				break;
			case UPLOAD_ERR_INI_SIZE:
				$error = "The file uploaded exceeds our maximum file size.  Please try a smaller image";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$error = "The file uploaded exceeds our maximum file size for give images.  Please try a smaller image";
				break;
			case UPLOAD_ERR_PARTIAL:
				$error = "The file was only partially uploaded.  Please try a again";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$error = "Upload Error, no temp directory.";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$error = "The file can't be written.";
				break;
			default:
				break;
		}
	}
	
	if(strlen($script) > 0){
		$t1 = microtime(true);
		
		$encoding = (int)$_POST['ascii_encoding'];
		$fast_decode = isset($_POST['fast_decode']) && $_POST['fast_decode'];
		$special_char = isset($_POST['special_char'])&& $_POST['special_char'];
		
		if(get_magic_quotes_gpc()) $script = stripslashes($script);
		
		$packer = new JavaScriptPacker($script, $encoding, $fast_decode, $special_char);
		$packed = $packer->pack();
		$originalLength = strlen($script);
		$packedLength = strlen($packed);
		$ratio =  number_format($packedLength / $originalLength, 3);
		
		$t2 = microtime(true);
		$time = sprintf('%.4f', ($t2 - $t1) );
		
		$treat = true;
		$filename = (strlen($_FILES['srcfile']['name']) > 0) ? 'compact.'.$_FILES['srcfile']['name'] : 'compact.js';
		
		switch(true){
			case ($ratio < 1 && $ratio >= .5):
				$style = " style='color:orange'";
				$comp = "We did an OK job compressing your file. We tried as hard as we can. Is that not good enough for you ?!?";
				$compclass = "galert";
				break;
				
			case ($ratio <= .5):
				$style = " style='color:green'";
				$comp = "We did an awesome job compressing your file! You should be thrilled. And we know you are :)";
				$compclass = "ginfo";
				break;
				
			case ($ratio >= 1):
				$style = " style='color:red'";
				$comp = "Your Source file is actually smaller than we can compress... So keep it instead of using ours. Feel free to call us names.";
				$compclass = "gerror";
				break;
				
			default:
				$style = '';
				$comp = "";
				break;
		}
	}
}
?>