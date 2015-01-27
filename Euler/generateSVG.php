
<?php
    $filepath = "/var/www/html/Euler/file3.txt";
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        move_uploaded_file ($_FILES['userfile'] ['tmp_name'], $filepath);
        //echo "File ". $_FILES['userfile']['tmp_name'] ." uploaded successfully. FILE PATH = ".$filepath;
    }  else  {
        //echo "Possible file upload attack: ";
        //echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
        print_r($_FILES); }

	$output = shell_exec("rm -rf /tmp/Euler3/file3*; /var/www/html/Euler/euler-project/src-el/euler -i file3.txt -o /tmp/Euler3/; dot -Tsvg /tmp/Euler3/file3_all.dot -o file3_all.svg;");
        echo $output;
	


	$data = file('/var/www/html/Euler/file3_all.svg'); // reads an array of lines
	function replace_a_line($data) {
		if (stristr($data, '<svg width')) {
			return "<svg\n";
   		}
   	return $data;
	}	
	$data = array_map('replace_a_line',$data);
	file_put_contents('/var/www/html/Euler/file3_all.svg', implode('', $data));	

?>
