<form method="get">
<input name="submit" type="submit" value="Update" />
</form>
<?php
$url = 'https://github.com/gwhitcher/CakeBlog/archive'; //URL TO ZIP (DO NOT INCLUDE ZIP)
$file = 'master.zip'; //ZIP FILENAME
$parent_folder = 'CakeBlog-master'; //PARENT FOLDER INSIDE OF ZIP

//FUNCTION FOR COPYING FILES
function recursive_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recursive_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
}
//UNZIP
if(!empty($_GET['submit'])) {
	$hostfile = fopen(''.$url.'/'.$file, 'r');
	$fh = fopen($file, 'w');
	while (!feof($hostfile)) {
    	$output = fread($hostfile, 8192);
    	fwrite($fh, $output);
	}  
	fclose($hostfile);
	fclose($fh);

	require_once('pclzip.lib.php');
	$archive = new PclZip($file);
	if (($v_result_list = $archive->extract()) == 0) {
    	die("Error : ".$archive->errorInfo(true));
	}
	unlink($file); //REMOVE ZIP
	echo 'Succesfully updated.';
	recursive_copy($parent_folder,'test');
	unlink($parent_folder); //REMOVE FOLDER
}
?>