<?php
include_once 'libs/controller_loader.php';

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of Router
 *
 * @author karcsi
 */
class Router {
    
    private $controller_loder;
    private $params;
    private $controller;
    private $action;
    
    public function __construct() {
        $this->controller_loder = new Controller_loader();
    }
    
    private function set_controller() {
        if (isset($this->params) && $this->params[0]) {
            $this->controller = array_shift($this->params);
        } else {
            $this->controller = 'home';
            $this->params[0] = 'index';
        }
        try {
            $this->controller_loder->load_controller($this->controller);
        } catch (Exception $ex) {
            $this->controller = 'home';
            $this->params[0] = 'index';
            $this->controller_loder->load_controller($this->controller);
        }
        $class = ucfirst($this->controller);
        if (class_exists($class)) {
            $this->controller = new $class();
        } else {
            throw new Exception('Missing class:' . $class);
        }
    }
    
    private function set_action() {
        $this->action = array_shift($this->params);
        if (isset($this->action) && !method_exists($this->controller,$this->action)) {
            throw new Exception('Missing method:' . $this->action);
        } else {
            if (!isset($this->action)) {
                $this->action = 'index';
            }
        }
    }
    
    public function dispach() {      
        $request = filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL);
        $this->params = explode('/', $request, 3);
        $this->set_controller();
        $this->set_action();
        $actionMethod = $this->action;
        $this->controller->$actionMethod($this->params);
    }
}
