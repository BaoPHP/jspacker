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

require('config.php');

header('Content-type: text/javascript');
header("Content-type: application/force-download");
header("Content-Transfer-Encoding: Binary");
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$_POST['filename'].'"'); 
echo "/*\n   PACKED BY: Manifest Interactive's JavaScript Packer on ".date("n/j/Y")."\n   URL: http://www.manifestinteractive.com/tools/packer/\n   WRITTEN BY: Peter Schmalfeldt\n*/\n";

if(strlen($_POST['packed']) == 0 || strlen($_POST['filename']) == 0){
	echo '// !!! Error Creating Javascript File';
	exit();
}
else {
	echo stripslashes($_POST['packed']);
	exit();
}
?> 