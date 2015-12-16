<?php
include_once 'loader.php';

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of view_loader
 *
 * @author karcsi
 */
class View_loader extends Loader {
    
    public function __construct() {
        parent::__construct('view/');
    }
    
    public function load_view($view, $data = array()) {
        $page = $this->base . $view . '.php';
        if (file_exists($page)) {
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }
            include $page;
        } else {
            throw new Exception('Missing page:' . $page);
        }
    }
}
