<?php
	//$output3 = shell_exec("rm -rf file3_*; cd /tmp/Euler3; rm -rf *; /var/www/html/Euler/euler-project/src-el/euler -i -o var/www/html/Euler/file3.txt /tmp/Euler3 --ie > output.txt; /var/www/html/Euler/euler-project/bbox-lattice/lattice.sh /var/www/html/Euler/file3");	
	
	$output3 = shell_exec("rm -rf file3_*; /var/www/html/Euler/euler-project/src-el/euler -i file3.txt --ie > output.txt; /var/www/html/Euler/euler-project/bbox-lattice/lattice.sh file3");

	echo $output3;	
	echo "HELLO563"

?>
