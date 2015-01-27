echo "preprocessing..."
python /var/www/html/Euler/euler-project/bbox-lattice/preprocess.py $1;
echo "saving all worlds...";
python /var/www/html/Euler/euler-project/bbox-lattice/awf.py i,o /var/www/html/Euler/euler-project/bbox-lattice/expWorlds.asp;
echo "creating the lattice without color...";
/var/www/html/Euler/binary/dlv -silent -filter=up  /var/www/html/Euler/euler-project/bbox-lattice/wexp-up.asp /var/www/html/Euler/euler-project/bbox-lattice/expWorlds_aw.asp > /var/www/html/Euler/euler-project/bbox-lattice/up.dlv;
echo "running euler to get MIS...";
#/var/www/html/Euler/euler-project/src-el/euler -i $1.txt -e mnpw --ie > /var/www/html/Euler/euler-project/bbox-lattice/output.txt;
echo "from MIS to MAC and get lattice..."
python /var/www/html/Euler/euler-project/bbox-lattice/lattice.py $1;
python /var/www/html/Euler/euler-project/bbox-lattice/latticedot2yaml.py $1;
dot -Tpdf $1_lat.dot -o $1_lat.pdf;
dot -Tsvg $1_lat.dot -o $1_lat.svg;
dot -Tpdf $1_fulllat.dot -o $1_fulllat.pdf;
dot -Tsvg $1_fulllat.dot -o $1_fulllat.svg;
echo "finish";
