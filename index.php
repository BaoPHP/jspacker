<?PHP
#################################################################################
## Copyright (C) 2007 by Manifest Interactive                                  ##
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

require('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Manifest Interactive :: JavaScript Packer</title>

	<!-- //////////////////////////////////////////////////////////////////////////////////////////////
         __  __             _  __          _      ___       _                      _   _
        |  \/  | __ _ _ __ (_)/ _| ___ ___| |_   |_ _|_ __ | |_ ___ _ __ __ _  ___| |_(_)_   _____
        | |\/| |/ _` | '_ \| | |_ / _ Y __| __|   | || '_ \| __/ _ \ '__/ _` |/ __| __| \ \ / / _ \
        | |  | | (_| | | | | |  _|  __|__ \ |_    | || | | | ||  __/ | | (_| | (__| |_| |\ V /  __/
        |_|  |_|\__,_|_| |_|_|_|  \___|___/\__|  |___|_| |_|\__\___|_|  \__,_|\___|\__|_| \_/ \___|
		
	Please feel free to learn what you wish from our source code :)

	 ////////////////////////////////////////////////////////////////////////////////////////////// -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="Manifest, Interactive, JavaScript, Packer, Pack, Compact" />
	<meta name="description" content="Manifest Interactive Javascript Packer" />
	<meta name="author" content="Manifest Interactive" />
	<meta name="revisit-after" content="1 week" />
	<meta name="robots" content="index,follow" />
	<meta name="googlebot" content="index,follow" />
	<meta name="company" content="Manifest Interactive" />
	<meta name="language" content="EN" />
	<meta name="content-language" content="english" />
	<meta name="copyright" content="Manifest Interactive" />
	<meta name="rating" content="general" />
	<meta name="coverage" content="worldwide" />
	<meta name="resource-type" content="document" />
	<meta name="rating" content="general" />
	<meta http-equiv="imagetoolbar" content="no" />

	<script type="text/javascript" language="javascript" src="js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.jgrowl_compressed.js"></script>
	<script type="text/javascript" language="javascript" src="js/site.js"></script>
	<script type="text/javascript" language="javascript" src="http://www.manifestinteractive.com/mint/?js"></script>
    <script type="text/javascript" language="javascript">
	$().ready(function(){
		$(window).bind("resize", resizeWindow);
		var newHeight = $(window).height();
		$("#src").css("height", ((newHeight/2)-135));
		$("#packed").css("height", ((newHeight/2)-135));
	});
	function resizeWindow(e) {
		var newHeight = $(window).height();
		$("#src").css("height", ((newHeight/2)-135));
		$("#packed").css("height", ((newHeight/2)-135));
	}
	</script>
	
	<link rel="shortcut icon" href="http://www.manifestinteractive.com/favicon.ico" type="image/x-icon" />
	<link rel="alternate" href="http://www.manifestinteractive.com/rss.php" type="application/rss+xml" title="Manifest Interactive Media Portfolio" />
	<link rel="start" href="http://www.manifestinteractive.com" title="Home" />
	<style type="text/css" media="screen, projection">
		@import "css/style.css";
		@import "css/jquery.jgrowl.css";
	</style>
	
</head>

<body>
<div id="wrapper">
    <a href="http://www.manifestinteractive.com/tools/packer/"><img src="http://www.manifestinteractive.com/images/logo.gif" width="161" height="41" border="0" /></a><br /><br />
    
    <form action="index.php" method="post" onsubmit="return validate();" id="srcform" enctype="multipart/form-data" autocomplete="off">
    	<input type="hidden" name="MAX_FILE_SIZE" value="307200" />
        <h2>Source Code: <input name="srcfile" id="srcfile" type="file" /><span>&nbsp;<?PHP if($_FILES['srcfile']['name'] && $_FILES['srcfile']['size'] < 307200 && ($_FILES['srcfile']["type"] == "application/x-js" || $_FILES['srcfile']["type"] == "application/x-javascript" || $_FILES['srcfile']["type"] == "text/plain")) echo '&nbsp;Currently Using:&nbsp; <b>'.$_FILES['srcfile']['name'].'</b>'?></span></h2>
        <textarea name="src" wrap="off" id="src" rows="30" onfocus="if(this.value=='Upload Source File above, or Paste Code Here ...') this.value = ''" onblur="if(this.value=='') this.value = 'Upload Source File above, or Paste Code Here ...'"><?PHP if($treat){echo htmlspecialchars($script);}else{echo 'Upload Source File above, or Paste Code Here ...';}?></textarea>
        <div class="subnav">
            <label for="ascii-encoding"><b>Encoding:</b></label>
            <select name="ascii_encoding" id="ascii-encoding">
                <option value="0"<?php if ($treat && $encoding == 0) echo ' selected'?>>None</option>
                <option value="10"<?php if ($treat && $encoding == 10) echo ' selected'?>>Numeric</option>
                <option value="62"<?php if (!$treat) echo 'selected';if ($treat && $encoding == 62) echo ' selected';?>>Normal (Base62)</option>
            </select>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <label><input type="checkbox" name="fast_decode" id="fast-decode"<?php if (!$treat || $fast_decode) echo ' checked'?> /> Fast Decode</label>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <label><input type="checkbox" name="special_char" id="special-char"<?php if (!$treat || $special_char) echo ' checked'?> /> Special Characters</label>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <input type="submit" value="Compact" class="button" id="submitButton" />
        </div>
	</form>
    
<?php if($treat){ ?>
	<form action="js.php" method="post" onsubmit="return jsvalidate();" id="packform" enctype="multipart/form-data" autocomplete="off">
       	<h2>Packed Result:</h2>
        <input type="hidden" name="filename" value="<?=$filename?>" />
        <textarea readonly="readonly" name="packed" id="packed" rows="30"><?php echo htmlspecialchars($packed);?></textarea>
        <div class="subnav">
            <?PHP if(strlen($comp)>0) echo "<script type='text/javascript' language='javascript'>$.jGrowl('{$comp}', { header: 'COMPRESSION COMPLETE:', theme: '{$compclass}', sticky: true });</script>"; ?>
            <b>Compression Ratio:</b> <span<?=$style?>><?php echo $originalLength.'/'.$packedLength.' = '.$ratio; ?></span>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Performed in <?php echo $time; ?> Seconds
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <input type="button" onclick="decode()" class="button" value="Decode" />&nbsp;<input type="submit" value="Download" class="button" />
        </div>
	</form>
<?php } ?>
    <script type="text/javascript" language="javascript">
	$().ready(function(){
	<?PHP if($error) echo "$.jGrowl('{$error}', { header: 'COMPRESSION ERROR:', theme: 'gerror', sticky: true });"; ?>
	});
    </script>
</div>
</body>
</html>
