<?php

namespace Core\Http\Client;

class Response {

    protected int $status = 200;
    protected array $headers = [];
    protected ?string $content = null;


    public function status() : int {
        return $this->status;
    }

    public function setStatus(int $status) : self {
        $this->status = $status;
        return $this;
    }

    public function headers(string $key = null) : array|string|null {
        if(is_null($key)){
            return $this->headers;
        }

        return $this->headers[strtolower($key)] ?? null;
    }

    public function setHeader(string $header, string $value) : self {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    public function removeHeader(string $header) {
        unset($this->headers[strtolower($header)]);
    }

    public function content() : ?string {
        return $this->content;
    }

    public function setContent(string $content) : self { // PATRON BUILDER DEVOLVERSE ASI MISMO PARA ANIDAR SETER CON FLECHAS
        $this->content = $content;
        return $this;
    }

    public function setContentType(string $value) : self {
        $this->setHeader("Content-Type", $value);
        return $this;
    }

    public function prepare() {
        if(is_null($this->content)){
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length",strlen($this->content));
        }
    }

    public static function json(array $data, int $status) : self { //PATRON FACTORY ENCAPSULAR A ASI MISMO ALGO COMPLEJO CON EL PATRON BUILDER
        return (new self())
            ->setContentType("application/json")
            ->setStatus($status)
            ->setContent(json_encode($data));
    }

    

    public static function text(string $text) : self {
        return (new self())
            ->setContentType("text/plain")
            ->setContent($text);
    }

    public static function response(array|string|null $data = null, int $status ) : self {
        
        if(!is_null($data)){

            if(is_array($data)){
                return self::json($data,$status);
            }
        
            return self::text($data)->setStatus($status);
        }
    
        return new self();
    }

    public static function redirect(string $uri) : self {

        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptDir = dirname($scriptName);
        //scriptDir completa la ruta si no la prefieres pasar en el redirect como ruta si no como uri
        return (new self())
            ->setStatus(302)
            ->setHeader("Location", $uri);
    }

    public function withErrors(array $errors, int $status = 400) : self {
        $this->setStatus($status);
        session()->flash('_errors',$errors);
        return $this;
    }
}