<?php

namespace bailangzhan;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public $css = [
    	'css/fileinput.css'
    ];
    public $js = [
        'js/fileinput.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }
}
