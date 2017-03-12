yii2-widget-fileinput
==========================

此扩展为解决 Yii2 framework 图片上传过程中不能预览的问题，目前只支持同步单图上传。

## 安装


推荐使用composer进行安装

```
$ php composer.phar require bailangzhan/yii2-widget-fileinput "@dev"
```

或者添加

```
"bailangzhan/yii2-widget-fileinput": "@dev"
```

到你的`composer.json`文件的`require`中

## 使用

视图文件
```php
<?= $form->field($model, 'imageColumn')->widget('manks\FileInput', [
	'clientOptions' => [
		// 'imageServer' => '',
	],
]) ?>
```

控制器
控制器的代码需要自行实现，只需要在save之前为图片字段赋值即可，如
```php
($file = Upload::up($model, 'imageColumn')) && $model->imageColumn = $file;
$model->save();
```

## 注意

你需要在params.php中配置`manks\FileInput::imageDomainConfigParam`，或者在`manks\FileInput::clientOptions`中配置固定参数`imageServer`，该参数是图片服务器的域名，在修改model的时候正确的展示图片

## 许可

**yii2-widget-fileinput** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
