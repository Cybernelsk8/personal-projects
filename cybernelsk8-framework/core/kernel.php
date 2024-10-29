<?php

namespace Core;

use Core\Config\Config;
use Core\Database\Drivers\DatabaseDriver;
use Core\Database\Model;
use Core\DotEnv\DotEnv;
use Core\Routing\Router;
use Core\Http\Client\Request;
use Core\Http\Client\Response;
use Core\Server\Server;
use Core\Http\Exceptions\HttpNotFoundException;
use Core\Session\Session;
use Core\Session\SessionDrive;
use Core\Validation\Exceptions\ValidationException;

use Throwable;

class Kernel {

    public static string $root;
    public Router $router;
    public Request $request;
    public Server $server;
    public Session $session;
    public DatabaseDriver $database;
    public ?DotEnv $env = null;

    public static function bootstrap(string $root) {
        
        self::$root = $root;

        $app = singleton(self::class);

        return $app
                ->loadConfig()
                ->runServiceProviders('boot')
                ->setHttpHandlers()
                ->setUpDatabaseConnection()
                ->runServiceProviders('runtime');
    }


    protected function loadConfig(): self {

        DotEnv::load(self::$root."/.env");
        Config::load(self::$root."/config");
        return $this;
    }

    protected function setHttpHandlers() : self {

        $this->router = singleton(Router::class);
        $this->server = app(Server::class);
        $this->request = singleton(Request::class, fn () => $this->server->getRequest());
        $this->session = singleton(Session::class, fn() => new Session(app(SessionDrive::class)));

        return $this;
    }

    protected function setUpDatabaseConnection() : self {
        
        $this->database = app(DatabaseDriver::class);
        $this->database->connect(
            config("database.connection"),    
            config("database.host"),    
            config("database.port"),    
            config("database.database"),    
            config("database.username"),    
            config("database.password")
        );
        Model::setDatabaseDriver($this->database);

        return $this;
    }

    protected function runServiceProviders(string $type) : self {
        foreach(config("providers.$type",[]) as $provider) {
            $provider = new $provider();
            $provider->registerServices();
        }

        return $this;
    }

    protected function prepareNextRequest() {
        if($this->request->method() == 'GET'){
            $this->session->set('_previous',$this->request->uri());
        }
    }

    protected function terminate(Response $response)  {

        $response->setHeader('Access-Control-Allow-Origin',implode(",",config('cors.allowed_origins')));
        $response->setHeader('Access-Control-Allow-Methods',implode(",",config('cors.allowed_methods')));
        $response->setHeader('Access-Control-Allow-Headers',implode(",",config('cors.allowed_headers')));

        if (config('supports_credentials')) {
            $response->setHeader('Access-Control-Allow-Credentials', 'true');
        }

        if($this->request->method() === 'OPTIONS') {
            $response->setStatus(204);
        }
        
        $this->prepareNextRequest();
        $this->server->sendResponse($response);
        $this->database->close();
        exit();
    }

    public function run() {
        try {
            $this->terminate($this->router->resolve($this->request));
        } catch (HttpNotFoundException $e) {
            $this->abort(Response::text("404 Not Found")->setStatus(404));
        } catch (ValidationException $e) {
            $this->abort(json($e->errors()))->setStatus(422);
            // $this->abort(back()->withErrors($e->errors(),422)); //redireccion con enivio de errores en peticiones GET
        }catch (Throwable $e) {
            $response = json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);

            $this->abort($response);
        }
    }

    public function abort(Response $response) {
        $this->terminate($response);
    }
}