<?php
namespace Rain;
class Tpl {

    public $var = array();

    protected $config = array(),
        $objectConf = array();

    protected static $plugins = null;

    protected static $conf = array(
        'checksum' => array(),
        'charset' => 'UTF-8',
        'debug' => false,
		'base_url' => '../',
        'tpl_dir' => 'templates/default/',
        'cache_dir' => 'cache/',
        'tpl_ext' => 'html',
        'php_enabled' => false,
        'auto_escape' => true,
        'sandbox' => true,
        'remove_comments' => false,
        'registered_tags' => array(),
    );

    protected static $registered_tags = array();


    public function draw($templateFilePath, $toString = FALSE) {
        extract($this->var);
        $this->config = $this->objectConf + static::$conf;

        ob_start();
        require $this->checkTemplate($templateFilePath);
        $html = ob_get_clean();

        $context = $this->getPlugins()->createContext(array(
                'code' => $html,
                'conf' => $this->config,
            ));
        $this->getPlugins()->run('afterDraw', $context);
        $html = $context->code;

        if ($toString)
            return $html;
        else
            echo $html;
    }


    public function drawString($string, $toString = false) {
        extract($this->var);
        // Merge local and static configurations
        $this->config = $this->objectConf + static::$conf;
        ob_start();
        require $this->checkString($string);
        $html = ob_get_clean();

        // Execute plugins, before_parse
        $context = $this->getPlugins()->createContext(array(
                'code' => $html,
                'conf' => $this->config,
            ));
        $this->getPlugins()->run('afterDraw', $context);
        $html = $context->code;

        if ($toString)
            return $html;
        else
            echo $html;
    }

    public function objectConfigure($setting, $value = null) {
        if (is_array($setting))
            foreach ($setting as $key => $value)
                $this->objectConfigure($key, $value);
        else if (isset(static::$conf[$setting])) {

            // add ending slash if missing
            if ($setting == "tpl_dir" || $setting == "cache_dir") {
                $value = self::addTrailingSlash($value);
            }
            $this->objectConf[$setting] = $value;
        }

        return $this;
    }

    public static function configure($setting, $value = null) {
        if (is_array($setting))
            foreach ($setting as $key => $value)
                static::configure($key, $value);
        else if (isset(static::$conf[$setting])) {

            // add ending slash if missing
            if ($setting == "tpl_dir" || $setting == "cache_dir") {
                $value = self::addTrailingSlash($value);
            }

            static::$conf[$setting] = $value;
            static::$conf['checksum'][$setting] = $value; // take trace of all config
        }
    }

    public function assign($variable, $value = null) {
        if (is_array($variable))
            $this->var = $variable + $this->var;
        else
            $this->var[$variable] = $value;

        return $this;
    }

    public static function clean($expireTime = 2592000) {
        $files = glob(static::$conf['cache_dir'] . "*.rtpl.php");
        $time = time() - $expireTime;
        foreach ($files as $file)
            if ($time > filemtime($file) )
                unlink($file);
    }

    public static function registerTag($tag, $parse, $function) {
        static::$registered_tags[$tag] = array("parse" => $parse, "function" => $function);
    }

    public static function registerPlugin(Tpl\IPlugin $plugin, $name = '') {
        $name = (string)$name ?: \get_class($plugin);

        static::getPlugins()->addPlugin($name, $plugin);
    }

    public static function removePlugin($name) {
        static::getPlugins()->removePlugin($name);
    }

    protected static function getPlugins() {
        return static::$plugins
            ?: static::$plugins = new Tpl\PluginContainer();
    }

    protected function checkTemplate($template) {

        // set filename
        $templateName = basename($template);
        $templateBasedir = strpos($template, '/') !== false ? dirname($template) . '/' : null;
        $templateDirectory = null;
        $templateFilepath = null;
        $parsedTemplateFilepath = null;

        // Make directories to array for multiple template directory
        $templateDirectories = $this->config['tpl_dir'];
        if (!is_array($templateDirectories)) {
            $templateDirectories = array($templateDirectories);
        }

        $isFileNotExist = true;

        if ($template[0] == '/') {
            $templateDirectory = $templateBasedir;
            $templateFilepath = $templateDirectory . $templateName . '.' . $this->config['tpl_ext'];
            $parsedTemplateFilepath = $this->config['cache_dir'] . $templateName . "." . md5($templateDirectory . serialize($this->config['checksum'])) . '.rtpl.php';
            // For check templates are exists
            if (file_exists($templateFilepath)) {
                $isFileNotExist = false;
            }
        } else {
            foreach($templateDirectories as $templateDirectory) {
                $templateDirectory .= $templateBasedir;
                $templateFilepath = $templateDirectory . $templateName . '.' . $this->config['tpl_ext'];
                $parsedTemplateFilepath = $this->config['cache_dir'] . $templateName . "." . md5($templateDirectory . serialize($this->config['checksum'])) . '.rtpl.php';

                if (file_exists($templateFilepath)) {
                    $isFileNotExist = false;
                    break;
                }
            }
        }

        if ($isFileNotExist === true) {
            $e = new Tpl\NotFoundException('Template ' . $templateName . ' not found!');
            throw $e->templateFile($templateFilepath);
        }

        // Compile the template if the original has been updated
        if ($this->config['debug'] || !file_exists($parsedTemplateFilepath) || ( filemtime($parsedTemplateFilepath) < filemtime($templateFilepath) )) {
            $parser = new Tpl\Parser($this->config, static::$plugins, static::$registered_tags);
            $parser->compileFile($templateName, $templateBasedir, $templateDirectory, $templateFilepath, $parsedTemplateFilepath);
        }
        return $parsedTemplateFilepath;
    }

    protected function checkString($string) {

        // set filename
        $templateName = md5($string . implode($this->config['checksum']));
        $parsedTemplateFilepath = $this->config['cache_dir'] . $templateName . '.s.rtpl.php';
        $templateFilepath = '';
        $templateBasedir = '';


        // Compile the template if the original has been updated
        if ($this->config['debug'] || !file_exists($parsedTemplateFilepath)) {
            $parser = new Tpl\Parser($this->config, static::$plugins, static::$registered_tags);
            $parser->compileString($templateName, $templateBasedir, $templateFilepath, $parsedTemplateFilepath, $string);
        }

        return $parsedTemplateFilepath;
    }

    private static function addTrailingSlash($folder) {

        if (is_array($folder)) {
            foreach($folder as &$f) {
                $f = self::addTrailingSlash($f);
            }
        } elseif ( strlen($folder) > 0 && $folder[0] != '/' ) {
            $folder = $folder . "/";
        }
        return $folder;

    }

}
