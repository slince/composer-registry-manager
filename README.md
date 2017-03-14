# Spider
网页爬行工具

## 安装
```
composer global require slince/spider *@dev
```

## Basic Usage

创建一个Spider并启动
```
use Slince\Spider\Spider;

$spider = new Spider();
$spider->run('http://www.baidu.com');

```

设置黑/白名单
```
//白名单
$spider = setWhiteUriPatterns([
    '/page-foo-regex/' 
]);
//黑名单
$spider = setBlackUriPatterns([
    '/page-bar-regex/' 
]);
//需要提供标准可用的正则表达式
example:
$spider = setBlackUriPatterns([
    '/page-bar-regex/' 
]);
```
事件
Spider在调度过程中会触发下面几个事件
* filterUri 过滤url事件，如果某个链接通过了spider的验证则会触发该事件；客户端可以通过监听该事件对链接做
进一步审查，如果设置不通过Spider会放弃对该链接的爬取
example: 
```
//...
/**
 * 过滤链接事件
 * @param FilterUriEvent $event
 */
public function onFilterUri(FilterUriEvent $event)
{
    $uri = $event->getUri();
    if ($uri->getHost() != 'baidu.com') {
        $event->skipThis(); //如果不是百度的链接跳过
    }
}
//...
```
* collectUri 开始采集链接
* downloadUriError 链接内容下载失败
* COLLECT_ASSET_URI 开始处理该链接下面资源链接
* COLLECT_COLLECTED_ASSET_URI_URI 该链接下面资源链接处理完毕
* collectedUri 页面链接处理完毕（包括页面资源内容链接，图片，样式文件链接等），开始处理页面下面其它页面链接

## 命令行工具

采集整站模板

example: 采集百度的模板
```
spider collect http://www.baidu.com 
```
你可以使用json文件进行配置，进行更精细化的优化，详细模板参见 [spider.json](./spider.json)
拷贝spider.json到工作目录，修改配置后执行
```
spider collect
```

