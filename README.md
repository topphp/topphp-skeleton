Topphp
===============

> Topphp-skeleton是基于ThinkPHP 6.0架构二次开发的骨架框架，运行环境要求PHP7.2+。

## 主要新特性

* 采用`PHP7`强类型（严格模式）
* 支持更多的`PSR`规范
* 原生多应用多版本支持
* 更强大和易用的查询
* 全新的事件系统
* 模型事件和数据库事件统一纳入事件系统
* 模板引擎分离出核心
* 内部功能中间件化
* SESSION/Cookie机制改进
* 对Swoole以及协程支持改进
* 对IDE更加友好
* 统一和精简大量用法
* 自动验证器中间件
* TopPHP异常处理
* SendMsg响应信息助手类
* 基础模型操作类
* 支持阿里云日志
* 多种扩展组件支持

## 安装

~~~
composer require topphp/topphp-skeleton
~~~

如果需要更新TP6框架使用
~~~
composer update topthink/framework
~~~

## 文档
TopPHP骨架默认自带应用
~~~
    admin 应用--后台管理（可分离模式【接口】，可非分离模式【视图】）
    index 应用--前台应用（可分离模式【接口】，可非分离模式【视图】）
    友情提示：以上应用均已配置好自动验证器中间件和Auth权限中间件（Auth需要开发者自行填充业务）
    
    api 应用--多版本接口应用：已配置好自动验证器中间件和V1、V2权限中间件（需要开发者自行填充V1、V2权限中间件业务）
    友情提示：多版本应用已配置好多版本路由，如无特殊需求，无需修改。如开发者不涉及多版本接口，可直接将此应用文件夹删除
~~~
TopPHP骨架已内置Top组件
~~~
1、单元测试组件（支持http请求）：topphp/topphp-testing
   Tips：单元测试http请求，只需要继承HttpTestCase即可直接通过如下示例调用；已内置get post put patch delete 请求。
         self::$httpClient->get(string $url, array $headers = []);
         
         
2、TopPHP日志组件（支持File日志与Aliyun日志）：topphp/topphp-log
   Tips：直接静态调用 Topphp\TopphpLog\Log 下的 Log 类即可使用，用法基本与TP6.0使用方式相同，并在原有TP6.0日志基础上进行了扩展。
        Log::write("日志信息，支持数组","debug","[可选]XXX业务","[可选]XXX操作","[可选]channel通道");
        
        
3、TopPHP客户端组件（支持Redis、Http、Socket客户端）：topphp/topphp-client
   Tips：提供助手类静态调用，简单方便。
        Http客户端：HttpHelper::post("http://www.domain.com", ["id" => 10001, "param1" => "value1"]);
        Redis客户端：RedisHelper::set("key", "val（支持数组）", 3600);
        
        
4、SendMsg Code响应信息助手类（支持自定义Code码与错误信息）
   Tips1：提供可选的错误信息Code响应方法，默认10000为成功，40000为失败，返回值类似 {"code":40000,"message":"系统异常","data":[]} ，并提供 json xml jsonp 返回格式，下面以 json 举例
   
  【场景：返回数据】
  
        SendMsg::jsonData("数据内容（支持数组）","http状态码（默认200）"); // Code 默认 10000
        
  【场景：返回数据列表形式，会在数据键data下增加一个list键，一般用于给前端返回数据列表使用】
  
        SendMsg::jsonList("列表内容（数组）","http状态码（默认200）"); // Code 默认 10000
        
  【场景：返回弹层/提示/消息/警告等信息】
  
        SendMsg::jsonAlert("错误信息","code码","附加数据（支持数组）","http状态码（默认200）"); // Code 默认 40000
        
  【场景：直接抛出信息，代码将在此句终止执行，直接发送响应，不推荐全部以这种方式进行响应，好的编码习惯，业务逻辑就应该尽量不使用强制抛出，而是try catch逐层返回】
  
        SendMsg::jsonThrow("错误信息","code码","附加数据（支持数组）","http状态码（默认200）"); // Code 默认 40000
        
  Tips2：另外提供代码内部逐层向上返回的数组方法
  
  【场景：返回数据数组】
  
        SendMsg::arrayData("数据内容（支持数组）","http状态码（默认200）"); // Code 默认 10000
        
  【场景：返回弹层/提示/消息/警告等信息的数组，注意，此处Code码为前置参数，为了方便业务判断】
  
        SendMsg::arrayAlert("code码","错误信息","附加数据（支持数组）","http状态码（默认200）"); // Code 默认 40000
        
  【场景：响应上面两种方式的数组信息，逐层返回后，我们可能需要将返回的数组信息直接发送响应给客户端，所以提供此方法，可以直接把上面返回的数组传递给此方法，进行http响应】
  
        $responseArray = SendMsg::arrayData("数据内容（支持数组）","http状态码（默认200）");
        SendMsg::jsonSend($responseArray, $isList = false);// 第二个参数表示是否data数据返回list形式（仅data为对象或数组有效），默认 false
  
  
5、自动验证器中间件 Check
  Tips：默认的 index admin 应用 与 api 多版本应用已配置好全局验证器Check中间件，开发者可以不用关心中间件的配置问题，只需要在对应的应用下validate目录添加验证器文件与配置规则即可，骨架会自动验证并返回信息。
       开发者可以结合对应的示例文件和TP6.0的验证器文档进行配置，骨架还提供单独验证某个字段的写法：
       单独验证：在验证器文件配置好单独验证的场景【"index@username"=>['username']】后，直接在控制器调用 checkOneRequestParam("username","post"); 方法即可
~~~

[附：TP6.0完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)

## 参与开发

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2019 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
