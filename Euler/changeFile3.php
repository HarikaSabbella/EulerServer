<?php
	shell_exec("rm /var/www/html/Euler/file3.txt");
	$filepath = "/var/www/html/Euler/file3.txt";
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        	move_uploaded_file ($_FILES['userfile'] ['tmp_name'], $filepath);
	}  
	else  {
        	print_r($_FILES); 
	}

	$output = shell_exec("rm -rf /tmp/Euler3/file3*; /var/www/html/Euler/euler-project/src-el/euler -i file3.txt -o /tmp/Euler3/; dot -Tsvg /tmp/Euler3/file3_all.dot -o file3_all.svg");
        echo $output;


?>
