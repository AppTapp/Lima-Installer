make clean
make
cp ./obj/limabe /var/www/6b859b9cf60b426921f612301fc21ded/LimaService
echo "build pushed to server"
sha1sum /var/www/6b859b9cf60b426921f612301fc21ded/LimaService

