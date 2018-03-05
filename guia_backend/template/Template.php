<?php

class Template {

    protected $_file;
    protected $_data = array();

    public function __construct($file = null) {
        $f = fopen($file, "r") or die("Unable to open file!");
        $this->_file = fread($f, filesize($file));
        fclose($f);
    }

    public function set($key, $value) {
        $this->_file = str_replace($key,$value,$this->_file);
    }

    public function render() {
       return $this->_file;
    }

}
