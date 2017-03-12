<?php

namespace manks;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * 图片上传插件
 *
 * @example 
 * 同步单图上传的使用
 * ```php
 *   echo $form->field($model, 'image_url')->widget('manks\FileInput');
 * ```
 *
 * @see http://www.manks.top
 */
class FileInput extends InputWidget
{
    /**
     * 图片域名参数，在params.php中进行配置
     * @use Yii::$app->params['imageServer']
     */
    public $imageDomainConfigParam = 'imageServer';
    /**
     * 客户端配置项
     * [[imageServer]] 指定的图片域名，该配置项和$this->imageDomainConfigParam至少配置一个，优先级别该配置项大于$this->imageDomainConfigParam，如果二者都未配置，则抛出异常
     * 
     */
    public $clientOptions = [];

    public function run ()
    {
        // 初始化操作
        $this->preInit();
        // 注册所需要的资源
        $this->registerClientScript();

        // 构建html结构
        if ($this->hasModel()) {
            $this->options = array_merge($this->options, $this->clientOptions);

            // 创建上传的input
            $file = Html::activeInput('file', $this->model, $this->attribute, $this->options);

            // 如果当前模型有该属性值，则默认显示
            if ($image = $this->model->{str_replace(['[', ']'], '', $this->attribute)}) {
                $imageServer = !empty($this->options['imageServer']) ? $this->options['imageServer'] : Yii::$app->params[$this->imageDomainConfigParam];
                // 显示该图片
                $li = Html::tag('li', '', ['class' => 'uploader__file', 'style' => 'background: url(' . $imageServer . $image . ') no-repeat; background-size: 100%;']);
                // 追加一个隐藏的input框，否则update的时候会覆盖原图片
                $file .= Html::activeInput('hidden', $this->model, $this->attribute, ['value' => $image]);
            }

            $uploaderFiles = Html::tag('ul', isset($li) ? $li : '', ['class' => 'uploaderFiles']);
            $inputButton = Html::tag('div', $file, ['class' => 'input-box']);
            echo Html::tag('div', $uploaderFiles.$inputButton, ['class' => 'file-div']);
        }
        else {
            throw new InvalidConfigException("'model'必须设置.");
        }
    }
    /**
     * pre init
     */
    public function preInit ()
    {
        if (!isset(Yii::$app->params[$this->imageDomainConfigParam]) && !isset($this->clientOptions['imageServer'])) {
            throw new InvalidConfigException("'FileInput clientOptions的imageServer配置项或者params.php的配置项FileInput::imageDomainConfigParam'至少要设置一个.");
        }
    }
    /**
     * Registers the needed client script and options.
     */
    public function registerClientScript ()
    {
        $view = $this->getView();
        FileInputAsset::register($view);
    }
}