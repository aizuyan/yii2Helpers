# yii2Helpers
the libraries to yii2

#### [yii2 curl类库](https://github.com/aizuyan/yii2Helpers/blob/master/CurlHelpers.php)
使用方法简单：
```php
use component\helpers\CurlHelpers;

$config = [
  'headers' => [
 	  'Content-Type' => 'application/x-protobuf',
  ],
  'options' => [
    CURLOPT_TIMEOUT => 10,
  ],
  'userAgent' => 'PHP v5.36XXXX',
  'referer' => 'http://www.jd.com',
];

$curl = new CurlHelpers($config);
$ret = $curl->post($url, $data);
$ret = $curl->get($url, $data);
```

#### [请求路径作为文件名记录日志](https://github.com/aizuyan/yii2Helpers/blob/master/FileTarget.php)
使用很简单，只需要修改配置文件：
```php
'log' => [
    'traceLevel' => 3,
    'targets' => [
        [
            'class' => 'component\log\FileTarget',
            'levels' => ['trace', 'info', 'error', 'warning'],
        ],
    ],
],
```

