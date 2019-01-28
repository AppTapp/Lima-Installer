<?php
$mysql=false;
include('header.php');
if(!$internal)
{
    die();
}
$socket = stream_socket_server("tcp://0.0.0.0:1337", $errno, $errstr);
if (!$socket) {
  echo "$errstr ($errno)<br />\n";
} else {

  while ($conn = stream_socket_accept($socket)) {
echo "connect\n";
while (true) {
    fwrite($conn, 'The local time is ' . date('n/j/Y g:i a') . "\n");
sleep(5);
}
    //fclose($conn);
  }
  fclose($socket);
}
?>