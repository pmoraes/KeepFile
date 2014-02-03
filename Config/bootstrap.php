<?php

if (!CakePlugin::loaded('Attach')) {
	throw new CakeException("You need to attach the load!");
}

$tmpDir = APP . 'tmp' . DS . 'files';
if (!is_dir($tmpDir)) {
	mkdir($tmpDir); 
	chmod($tmpDir, 0777);
}
