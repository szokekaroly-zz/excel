<?php

defined('SERVER_ROOT') OR exit('No direct script access allowed');

/**
 * Description of loader
 *
 * @author karcsi
 */
class Loader {
    
    protected $base;
    
    public function __construct($base) {
        $this->base = $base;
    }
}
