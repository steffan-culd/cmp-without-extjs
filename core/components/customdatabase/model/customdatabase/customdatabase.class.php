<?php
class CustomDatabase {
    public $modx;
    public $config = array();
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
 
        $basePath = $this->modx->getOption('customdatabase.core_path',$config,$this->modx->getOption('core_path').'components/customdatabase/');
        $assetsUrl = $this->modx->getOption('customdatabase.assets_url',$config,$this->modx->getOption('assets_url').'components/customdatabase/');
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);
		$this->modx->addPackage('customdatabase',$this->config['modelPath']);
 
    }
}