<?php

namespace PHPMVC\LIB;

trait HelperMordy {

    public function redirect($path) {
        session_write_close(); 
        header('Location:'.$path);
        exit();
    }

}
