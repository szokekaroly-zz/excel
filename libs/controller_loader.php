<?php

include_once 'loader.php';
include_once 'controller.php';

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of controller_loader
 *
 * @author karcsi
 */
class Controller_loader extends Loader {

    public function __construct() {
        parent::__construct('controller/');
    }

    public function load_controller($controller) {
        $page = $this->base . $controller . '.php';
        if (file_exists($page)) {
            include_once($page);
        } else {
            throw new Exception('Missing page:' . $page);
        }
    }
}
