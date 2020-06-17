<?php

namespace Rain\Tpl;

class Exception extends \Exception {

    protected $templateFile = '';

    public function templateFile($templateFile){
        if(is_null($templateFile))
            return $this->templateFile;

        $this->templateFile = (string) $templateFile;
        return $this;
    }
}

// -- end
