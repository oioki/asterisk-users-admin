<?php

class AMI
{
    private $socket = 0;
    private $p_Server, $p_Port, $p_Username, $p_Password;

    public function __construct($p_Server, $p_Port, $p_Username, $p_Password) {
        $this->p_Server   = $p_Server;
        $this->p_Port     = $p_Port;
        $this->p_Username = $p_Username;
        $this->p_Password = $p_Password;
    }

    public function sendCommand($cmd)
    {
        if ( !fwrite($this->socket, $cmd) )
            return "Error writing to socket\n";

        $response = stream_get_contents($this->socket);
        //print $response;

        return $response;
    }

    public function login()
    {
        // Create network socket
        $this->socket = fsockopen($this->p_Server, $this->p_Port);
        stream_set_timeout($this->socket, 0, 100000);  // 0.1 sec

        // Login via Asterisk Manager API
        $cmd = "Action: login\r\n"
       ."Username: {$this->p_Username}\r\n"
       ."Secret: {$this->p_Password}\r\n\r\n";

        $response = $this->sendCommand($cmd);
        //print $response;

        if ( strpos($response, "Message: Authentication accepted") == false )
        {
            echo "Error authenticating server: $response";
            exit;
        }
    }

    public function logoff()
    {
        $cmd = "Action: Logoff\r\n\r\n";
        $response = $this->sendCommand($cmd);
        fclose($this->socket);
    }
}

?>
