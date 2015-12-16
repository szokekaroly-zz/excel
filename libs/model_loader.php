<?php
include_once 'loader.php';
include_once 'model.php';

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of model_loader
 *
 * @author karcsi
 */
class Model_loader extends Loader {
    
    public function __construct() {
        parent::__construct('model/');
    }
    
    public function load_model($model) {
        $page = $this->base . $model;
        if (file_exists($page)) {
            include_once $page;
        } else {
            throw new Exception('Missing model:' . $page);
        }
    }
}
