<?php
namespace Rain\Tpl;

require_once __DIR__ . '/IPlugin.php';

class Plugin implements IPlugin
{
    protected $hooks = array();

    public function  __construct($options = array())
    {
        $this->setOptions($options);
    }
	
    public function declareHooks() {
        return $this->hooks;
    }

    public function setOptions($options) {
        foreach ((array) $options as $key => $val) {
            $this->setOption($key, $val);
        }
        return $this;
    }
	
    public function setOption($name, $value) {
        $method = 'set' . ucfirst($name);

        if (!\method_exists($this, $method)) {
            throw new \InvalidArgumentException('Key "' . $name . '" is not a valid settings option' );
        }
        $this->{$method}($value);
        return $this;
    }
}
