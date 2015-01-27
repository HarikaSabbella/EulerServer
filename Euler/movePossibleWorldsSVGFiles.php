<?php
        $output = shell_exec("cd /var/www/html/Euler/possibleWorldsSVGFiles; rm -rf *; cd /tmp/Euler3; cp *.svg /var/www/html/Euler/possibleWorldsSVGFiles/;");
	echo $output;


?>
