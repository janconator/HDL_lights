<?php
$server_ip   = '192.168.1.255';
$server_port = 6000;
$secret = 'controlMyLights';

if(count($_GET) > 0) {
	if(isset($_GET["secret"])){	
		if(isset($_GET["room"])){
			if(isset($_GET["action"])){
				$command_start = 'c0a8010348444c4d495241434c45aaaa0f01fafffe00310102';
				$commands = array(
					'balcony'       => array('on' => '02640000b234', 'off' => '02000000f59f'),
					'living_room'   => array('on' => '03640000c480', 'off' => '03000000832b'),
					'dining_room'  => array('on' => '0464000095ad', 'off' => '04000000d206'),
					'bedroom'       => array('on' => '05640000e319', 'off' => '05000000a4b2'),
					'ceiling'       => array('on' => '065f00004d91', 'off' => '060000003f6e'),
					'guest_room_1'  => array('on' => '076400000e71', 'off' => '0700000049da'),
					'guest_room_2'  => array('on' => '09640000ac2b', 'off' => '09000000eb80'),
					'hall'          => array('on' => '0a64000037f7', 'off' => '0a000000705c'),
					'kitchen'       => array('on' => '0b6400004143', 'off' => '0b00000006e8'),
					'cooling'       => array('on' => '0c640000106e', 'off' => '0c00000057c5')
				);
	
				$message = hex2bin($command_start . $commands[$_GET["room"]][$_GET["action"]]);
		      
				if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
					socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1); 
					socket_sendto($socket, $message, strlen($message), 0, $server_ip, $server_port);
					socket_close($socket);
					echo "command: " . $commands[$_GET["room"]][$_GET["action"]] . " sent";	          
				} else {
					echo("can't create socket");
				}
			} else {
				echo "please set an action";
			}
		} else {
			echo "please set a room";
		}
	} else {
		echo "missing secret";
	}
} else {
  echo "missing parameters!";
}
?>
