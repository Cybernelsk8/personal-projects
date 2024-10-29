<?php

namespace Core\Server;

use Core\Http\Client\Request;
use Core\Http\Client\Response;
use Core\Server\Server as ServerInterface;

class PhpNativeServer implements ServerInterface {

    // protected function uploadedFile() : array {
    //     $files = [];
    //     foreach ($_FILES as $key => $file) {
    //         if(!empty($file["tmp_name"])){
    //             $file[$key] = new File(
    //                 file_get_contents($file["tmp_name"]),
    //                 $file["type"],
    //                 $file["name"]
    //             );
    //         }
    //     }

    //     return $files;
    // }

    protected function requestData() : array {

        $headers = getallheaders();
        $isJson = isset($headers["Content-Type"]) && $headers["Content-Type"] == 'application/json';

        if($_SERVER["REQUEST_METHOD"] == "POST" && !$isJson){
            return $_POST;
        }

        if($isJson){
            $data = json_decode(file_get_contents("php://input"),true);
        } else {
            parse_str(file_get_contents("php://input"),$data);
        }


        return $data;
    }

    public function  getRequest(): Request {

        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);
        $uri = str_replace($scriptDir,'',$_SERVER['REQUEST_URI']);
        return (new Request())
            ->setUri(parse_url($uri,PHP_URL_PATH))
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setHeaders(getallheaders())
            ->setPostData($this->requestData())
            ->setQueryParameters($_GET);
    }

    public function sendResponse(Response $response) {
        header("Content-Type: None");
        header_remove("Content-Type");
        $response->prepare();
        http_response_code($response->status());
        foreach ($response->headers() as $header => $value) {
            header("$header: $value");
        }

        print($response->content());
    }
}