# Usefull scripts to be used with telemesure.net service.

Telemesure.net services offers many differents way to handle data and to interract with the service.
We provide here some examples of ready to use scripts for some basic usages.

##### "receiver.php" Receive data frame pushed by the service.
The script is a simple php script you install in a defined server directory. It will be called by telemesure.net to receive incomming data.
It will write the data pushed by telemesure.net to a text file.

Install the script on your server and create a log directory.
Give write permission to the 'log' directory for the server to be able to write the file.
Configure the reception mode matching the one configured in telemesure.net (GET, POST, POST EXTENDED) by modifying the define in the script.
Configure telemesure.net in the transmitter section to send to your URL.
For example : http://myserver.net/receiver.php

After the data push from telemesure.net, you should have the info in your log file.

##### License

MIT License / read license.txt