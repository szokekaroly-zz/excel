<?php

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of Controller
 *
 * @author karcsi
 */
class Controller {
    
    public function __construct() {
        include_once 'libs/model_loader.php';
        include_once 'libs/view_loader.php';
    }
}
