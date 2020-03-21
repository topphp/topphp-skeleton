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
* Snowflake雪花算法
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
    admin 应用--后台管理（可分离模式，可非分离模式）
    index 应用--前台应用（可分离模式，可非分离模式）
    友情提示：以上应用均已配置好自动验证器中间件和Auth权限中间件（Auth需要开发者自行填充业务）
    
    api 应用--多版本接口应用：已配置好自动验证器中间件和V1、V2权限中间件（需要开发者自行填充权限中间件业务）
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
       
       
6、基础模型操作类
  Tips：提供模型操作的基本快捷方法，提升模型操作代码复用率，方便开发，包含如下方法：
       a、生成数据表主键id（适用于自定义主键情况）protected genSqlId()
       b、获取资源数据指定列的数组 protected getSourceColumn()
       c、数组分页 protected dataPage()
       
       // 以下为公共方法
       a、获取模型抛出的异常报错 getModelError()
       b、获取当前模型表所有字段名 getTableFieldName()
       c、新增数据 add()
       d、批量新增数据 addAll()
       e、大数据量批量新增（支持分批插入，一般应用于插入数据超千条场景） addLimitAll()
       f、编辑数据 edit()
       g、更新指定字段值（支持主键更新） updateField()
       h、指定字段自增（支持主键查询） fieldInc()
       i、指定字段自减（支持主键查询） fieldDec()
       j、指定字段自增/自减（支持主键查询，支持多字段步进处理） fieldStep()
       k、多条件批量更新（支持主键批量更新） updateAll()
       l、多条件批量更新（原生where查询） updateAllRaw()
       m、删除数据（支持主键删除，支持多条件删除，支持软删除） remove()
       n、删除数据（原生where查询，不支持直接传入主键id值删除，其他规则同remove） removeRaw()
       o、查询链式（支持主键查询，支持TP链式操作，融合软删除） queryChain()
       p、查询字段值（支持主键查询，支持select查询返回二维数组，默认find查询） findField()
       q、查询一条（支持主键查询，支持select查询返回二维数组，默认select查询） selectOne()
       r、查询所有（支持主键查询，支持排除字段） selectAll()
       s、查询排序（支持主键查询，支持原生SQL语句Order排序，支持Limit限制条数） selectSort()
       t、查询首条数据（支持前Limit条） selectFirst()
       u、查询最后一条数据（支持后Limit条） selectEnd()
       v、满足条件的数据随机返回（支持随机取Limit条） selectRand()
       w、查询某个字段的值相同的数据（同一张表指定字段值相同的数据，支持结果排序） selectSameField()
       x、查询指定字段值重复的记录（支持多字段匹配，支持结果排序） selectRepeat()
       y、查询指定字段值不重复的记录【仅查询不重复的】（支持多字段匹配，支持结果排序） selectNoRepeat()
       z、FIND_IN_SET查询（查询指定字段包含指定的值或字符串的数据集合） selectFieldInSet()
       I、FIND_IN_SET查询（查询指定字段在指定的集合的数据集合，效果类似于 field in (1,2,3,4,5) 的用法） selectFieldInList()
       II、查询List（支持分页，支持each回调） selectList()
       III、查询列（支持指定字段的值作为索引） selectColumn()
       
       // 以下为联查方法
       a、设置基础查询条件（用于简化基础alias、join和主表field） setBaseQuery()
       b、Join联查(innerJoin，如果表中有至少一个匹配，则返回行) selectJoin()
       c、leftJoin联查（即使右表中没有匹配，也从左表返回所有的行） selectLeftJoin()
       d、rightJoin联查（即使左表中没有匹配，也从右表返回所有的行） selectRightJoin()
       e、fullJoin联查（只要其中一个表中存在匹配，就返回行，Mysql数据库不支持） selectFullJoin()
       f、一对多子查询（支持分页，支持主表、子表字段过滤，返回值类似TP的with查询返回） selectChild()
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
