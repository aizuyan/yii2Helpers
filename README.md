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
