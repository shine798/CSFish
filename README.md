# CSFish
## 项目使用效果
微信搜索“无影安全实验室”，看历史文章，标题为《CSFish—实现水坑钓鱼收杆&CS上线提醒&自动权限维持》

## 使用方法
修改CSFish.cna第4行代码为你要迁移的进程名，此处默认为explorer.exe

修改CSFish.cna第5行代码为自己CS监听器名称

修改CSFish.cna第40行代码为自己PHP服务器地址

修改fish.php第3行代码为自己钓鱼页面地址

修改fish.php第64或第71行代码为自己飞书或者钉钉的webhook地址（两个填一个即可，推荐使用飞书）

创建飞书webhook参考文章:https://blog.csdn.net/qq_74046217/article/details/133429541

备注：如果不想实现CS自动进程注入，删除CSFish.cna第3-20行代码即可

创作不易，希望师傅们点点免费的star，支持一下，万分感谢！！！
