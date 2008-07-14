<?php
    	$mysock = socket_create(AF_INET, SOCK_STREAM, 0);
    	//socket_set_option($mysock, SOL_SOCKET, SO_KEEPALIVE, 1);
    	socket_bind($mysock, "127.0.0.1", 10000);
    	socket_listen($mysock);
    	$commSock = socket_accept($mysock);
    	//$test = socket_read($commSock, 1024);
    	while(true){
    		socket_write($commSock, "test WRITE\n--\n");
    	}
		socket_close($commSock);
		socket_close($mysock);
?>