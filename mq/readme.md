**_MQ_**
这是一个简单的消息代理，基于mariano/disque-php基础上封装而成，可直接调用。

1.disque的使用手册：http://disque.huangz.me/install.html

2.安装disque方法：
1).执行命令 git clone https://github.com/antirez/disque.git ，使用 Git 克隆 Disque 的项目文件夹.
2).执行 cd disque 命令，切换至 Disque 的项目文件夹。
3).执行 make 命令，编译 Disque 。
4).可选：执行 make test ，测试刚刚编译好的 Disque 程序。
5).执行 cd src 命令，进入 src 文件夹，里面有编译好的 Disque 服务器文件 disque-server 和 Disque 客户端文件 disque 。

3.composer拉mariano/disque-php包 
```bash
$ composer require mariano/disque-php --no-dev
  
注意：Disque\Connection\BaseConnection->connect() 方法中， 2020-04-16
      此处62行，有个判断逻辑错误:  if (!isset($this->host) || !is_string($this->host) || !isset($this->port) || !is_int($this->port)) {
     请修改为:    if ((!isset($this->host) || !is_string($this->host)) && (!isset($this->port) || !is_int($this->port))) {

 ```

  
4.自行把配置文件修改，调试