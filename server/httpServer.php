<?php
/**
 * HttpServer
 * use php to do a http-server
 *
 * @date    2019-08-30
 * @author  meijinfeng
 */

function server()
{
    $host = "0.0.0.0";
    $port = "12580";
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    $socket !== false ?: trace(socket_strerror(socket_last_error()), true);
    socket_set_option($socket, SOL_SOCKET, SO_REUSEPORT, 1);
    $bind = socket_bind($socket, $host, $port);
    $bind !== false ?: trace(socket_strerror(socket_last_error()), true);
    $listen = socket_listen($socket);
    $listen !== false ?: trace(socket_strerror(socket_last_error()), true);
}

function start()
{
    trace("httpServer building ...");
    $server = server();
    trace("httpServer built success");
    trace("waiting request ...");

    while (1) {
        $msg = socket_accept($server);
        $msg !== false ?: trace(socket_strerror(socket_last_error()), true);
        $httpMsg = socket_read($msg, 8192);
        trace("------------------------------------------");
        trace("request_time: " . time() . PHP_EOL . $httpMsg);

        $httpMsg = httpRequest($httpMsg);
        $body = $httpMsg['body'];

        $return = [
            'request' => $httpMsg,
            'response' => [
                'code' => 0,
                'msg'  => 'connect success'
            ]
        ];

        $return = httpResponse($return);
        socket_write($msg, $return, 8192);
        socket_close($msg);
        trace("this request end, waiting next request ...");
        trace("------------------------------------------");

        if ("EXIT" == strtoupper($body)) {
            socket_close($server);
            trace("this server has closed, Bye Bye !!!", true);
        }
    }
}

function httpRequest($httpRequest)
{
    $info = [];
    $info['header'] = [];
    $split = preg_split('/\n\s*\r/', $httpRequest);
    $headerLine = explode("\n", $split[0]);
    $info['body'] = trim($split[1]);

    foreach ($headerLine as $index => $row) {
        // line|header check
        if (0 === $index) {
            // request line
            $temp = explode(chr(32), $row);
            $info["method"] = trim($temp[0]);
            $info["uri"] = trim($temp[1]);
            $info["version"] = trim($temp[2]);
        } else {
            // request header
            $temp = explode(":", $row);
            $info["header"][$temp[0]] = $temp[1];
        }
    }

    return $info;
}

function httpResponse($responseBody)
{
    $line = "HTTP/1.1 200 OK\r\n";
    $header = "Server: PHP-CLI\r\n";
    $header .= "Date: " . date("Y-m-d H:i:s") . "\r\n";
    $blankLine = "\r\n";
    $body = json_encode($responseBody);

    $httpResponse = "{$line}{$header}{$blankLine}{$body}";
    return $httpResponse;
}

function trace($msg, bool $exit = false)
{
    $time = date("Y-m-d H:i:s");
    if (is_array($msg)
        || is_object($msg)) {
        print_r($msg);
    } else {

        echo "[{$time}]: {$msg}" . PHP_EOL;
    }

    !$exit ?: exit(0);
}

start();