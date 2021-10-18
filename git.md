# git基础命令

工作区(生产车间)----git add . ----->暂存区(小推车)-------git commit -m 'xxx'--------> 本地版本库(仓库)
git init                         #初始化一个版本库
git add .                      #将文件添加到小推车
git mv a.php b.php     #将小推车中的a.php改名为b.php
git commit -m '注释'   #将小推车的东西提交到版本库
git rm a.php               #将版本库和工作区的a.php删除
git rm --cache a.php  #将版本库的a,php删除或者说将小推车的a.php删除,回到未跟踪状态,回到工作区,
git reset HEAd -- a.php # 与上一条命令执行结果一样啊, 此命令针对从未提交过的新文件

git reset HEAD a.php       #将已添加到小推车的a.php放回工作区,让文件回到未暂存时的状态,从绿色变成红色,对从未提交过的新文件没用
git reset HEAD -- a.php   #如果a.php未提交过(git status 显示 new file: xxx),得使用 --
git checkout -- a.php      #放回到工作区然后执行此命令可以回退到上一次提交


git reset --hard HEAD^     #回退到上个版本
git reset --hard HEAD~3    #回退到前3次提交之前，以此类推，回退到n次提交之前
git reset --hard commit_id   #退到/进到，指定commit的哈希码（这次提交之前或之后的提交都会回滚）
回滚后提交可能会失败，必须强制提交
强推到远程：(可能需要解决对应分支的保护状态)
git push origin HEAD --force

#git init后,此时其实还未存在分支,需要先创建个文件提交一次后才可以创建新分支
#比如我现在是在ask分支,但ask分支从未提交过,就算有文件,此时都是可以直接切换到其他分支的
#若ask分支有提交过,此时改动了ask分支,想在不commit情况下切换到其他分支,是会报错的,除非使用
#下面的命令
git stash       #比如现在我在ask(ask分支已经提交过一次)分支开发到一半放到了暂存区,但我不想提交(commit),现需要切换到bbs分支
                    但默认会提示切换失败,需要提交,此时就可以使用此命令将当前分支暂存起来,放到临时存储区
git stash list    #查看暂存分支
git stash apply                 #!前提是先切换到目标分支,再恢复(恢复暂存分支)切换到想要恢复的分支执行此命令,就会恢复之前的状态
git stash drop stash@{0}  #删除暂存分支, 
git stash pop                    #!前提是先切换到目标分支,再恢复,恢复并删除暂存分支

git tag           #查看已有的标签
git tag v1.0    #添加标签
git tag -a tagName -m '备注信息'   #添加带备注的tag
git tag -a tagName commit的hash前几位 -m '备注'  #给指定的某个commit号加tag,commit号可通过git log获得,取前几位即可
git log --decorate           #当我们执行 git log --decorate 时，我们可以看到我们的标签了：
git push origin :<tagName>   #把本地tag 推送到远端：
git push origin --tags            #若存在很多未推送的本地标签，你想一次全部推送的话：

#rebase :replace base:替换基础
#从主分支派生出ask分支,我在开发ask分支期间,master分支有改变,或者说master分支提交点往后挪了一下,此时ask分支开发完了,需要合并了,转到master合并
#git log graph 查看到有合并分支等等,这个概念我有点模糊,需要百度一下
git  rebase master    #将子分支的基础点往后挪,挪到主分支最新点,,如果派生出ask分支后master分支未改变过,不需要执行此命令

git clone xxxx                                 #从远程仓库克隆项目到本地,克隆下来本地默认只有一个master分支,git branch -a 查看本地与远程分支


------------------举个例子-----------------------------=====
现在我刚到公司,组长把我分配到某个组来完成ask分支功能
那么我要做的是:
git clone  git@github.com:xxxxx  dirname   #把项目克隆到dirname目录
git branch -a                        #查看本地与远程存在的分支,比方存在如下分支:本地:master,远程:master,ask,bbs
既然安排我开发ask分支,那么现在我把远程ask分支检出到我本地的ask分支,命令如下
git pull origin ask:ask           #将远程ask检出到本地ask并会在本地创建ask分支
git checkout ask  #切换到ask分支开始写代码吧
......开发中
开发完了
git add .
git commit -m '完成了ask'  #提交到本地版本库
如果不需要合并那直接推送到远程,一般没问题都会直接合并然后再推送
不合并:
git push          #把当前分支推送到远程,出现fatal error,因本地与远程分支未关联
git push --set-upstream origin ask  #关联,执行完此命令,会顺便提交代码到远程
合并:
1,切换到master分支执行
git pull   #把master更新到最新状态
2,把ask分支的基准点移到master最新的基准点,因为也许master有过更新,如没有更新则不需要执行rebase
git checkout ask   #切换到ask
git rebase master  #将ask分支移动到master最新点
git checkout master #切换到master进行合并
git merge ask       #合并
git branch --merged  #查看成功合并的分支
git push    #推送
如果ask分支没用了可以删除了,一般不管他
git branch -d ask  #删除本地的ask
git push origin --delete ask   #删除远程的
git branch -a  #查看分支

--------------------------------------------------------======



git remote add origin ssh地址           #   git remote add [shortname] [url]     把本地仓库与远程仓库进行关联  origin只是个地址别名,可以自定义,如, git remote add test xxxx
git remote rm name                      # 删除和远程仓库的关联
git remote rename old_name new_name    # 修改仓库名
git remote show                           #显示远程仓库的名
git remote -v                               # 显示所有远程仓库
git push -u origin master            #推送代码到github  origin也是地址别名,

#生成压缩包
git archive master --prefix='aaa/' --format=zip > bbb.zip
说明: 将master分支打包成bbb.zip压缩包,并将文件放到压缩包里面的aaa目录
--prefix    #指定子目录
--format  #压缩包格式,zip|tar.gz.......

#使用系统别名自定义git全局指令
vim .bash_profile
alias gs="git status"
.......

git config user.name                 #查看当前版本库配置文件中的用户名
git config --global user.name    #查看全局配置中的用户名
git config --global user.email    #查看全局配置中的邮箱
git config user.name 'zhang'   #将当前版本库配置的用户名设置为zhang
git log                                     #查看提交日志,只显示作者日期和commit -m的注释
git log --graph
git log -p -1                            #查看最近一次提交的详细信息  -2最近两次...
git log --oneline                     #只显示所有简短的哈希字符串和-m备注
git log --name-status            #查看所有文件的改动
git commit --amend             #可以修改最近一次提交时的注释内容,这里需要注意的是:比如,现在我创建了个b.php,执行,git add . ,执行git commit --amend, 执行git status发现暂存区空了,默认就提交了啊,把这个文件提交合并到上一次提交了,一条指令可以认为把这次提交归纳到最新一次提交中
git log --name-only -1          #查看最近一次提交,显示注释内容,文件名
git config --global alias.a add #简化命令 ,执行git a. =git add .
#简化命令
cd
subl .gitconfig
[alias]
   a = add
......

#分支--------------------------------
#比如我现在到ask分支开发,我没提交,切换到master分支上可以看到我在ask分支所创建的文件包括内容,如果提交后再切换到master,再未合并之前是看不到我在ask分支所做的事
git branch         #查看分支列表
git branch ask #创建ask分支
git checkout ask #切换到ask分支 
git checkout -b bbs #创建并切换到bbs分支
git merge bbs #将bbs合并到主分支master,前提必须切换到master分支上
git branch -d ask #删除ask分支,而且ask是已合并的分支,删除前建议查看是否已经合并,慎用-D
git push origin --delete ask   #删除远程的ask分支
git branch -D ask  #删除未合并的ask分支,-d不能删除未合并的,-D可以
git branch --merged   #查看已经合并的分支
git branch --no-merged   #查看未合并的分支
git branch -a     #显示远程分支和本地分支
git push --set-upstream origin ask      #把本地ask分支与远程服务器的分支进行关联,说白了就是本地有master,ask两个分支,在远程只有一个master,当推送ask时,就会报错,让你进行关联

冲突: 解决冲突后重新git add . git commit -m 'xxx'
HEAD是指针,指向当前所在的分支指针,当前分支指针又指向最新提交
cat .git/HEAD         #查看HEAD指针指向哪一个分支
cat .git/refs/heads/ask   #比如现在所在分支是ask,查看ask分支指针指向最新的提交,查询结果就是最新提交的hash值,可通过git log -p -1查看hash值



# git自动部署

![image-20211019024412281](C:\Users\admin\AppData\Roaming\Typora\typora-user-images\image-20211019024412281.png)



1,在github创建好一个项目

2,在服务器创建好一个站点,站点目录得是空目录,否则克隆不了github项目

​    使用宝塔面板创建的站点,ls -a  可以看到有好几个文件,说明不是空目录

​     那么我们就不要那个目录,把那个目录删除也行,或者mv改名也行,只要保证是空就好

​	我的做法就是,把宝塔创建站点时的目录删除,克隆的时候指定目录名

3,克隆(https方式)到服务器

​	git clone https://github.com/xxxxxxxx.git  站点目录名称

4, 克隆(ssh方式)到本地,ssh克隆推送就不需要密码了,前提是要把公钥放到github

​	git clone git@github.com:xxxxxxxxxx.git   目录名称

5,配置github中项目的setting--->webhook,就配置两项好了,payladurl和secret

  Payload URL

```
http://您的站点名称/webhook.php        #如  http://www.baidu.com/webhook.php
```

​	secret

​	autoploy



6,在本地创建一个webhook.php,复制如下内容到webhook.php

```
<?php

// github项目 setting/webhok 中的secret,可以自定义
$secret = "autoploy";

// $path 您的站点目录
$path = "/www/wwwroot/站点根目录";

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if($signature) {
	$hash = "sha1=". hash_hmac('sha1', file_get_contents("php://input"), $secret);
	if(strcmp($signature, $hash) == 0 ) {
		echo shell_exec("cd {$path} && /usr/bin/git reset --hard origin/main && /usr/bin/git clean -f && /usr/bin/git pull 2>&1");
		exit();
	}
}

http_response_code(404);
?>
```

7, 推送到远程仓库

  	git add .                        git commit -m 'xx'            git push

8,	在服务器上拉取一次github上代码,因为此时服务器还没有webhook.php,所以手动拉取一次

​	  git  pull

​      如果出现如下情况:

```
warning: Pulling without specifying how to reconcile divergent branches is discouraged. You can squelch this message by running one of the following commands sometime before your next pull:

git config pull.rebase false  # merge (the default strategy)
git config pull.rebase true   # rebase
git config pull.ff only       # fast-forward only

You can replace "git config" with "git config --global" to set a default preference for all repositories. You can also pass --rebase, --no-rebase, or --ff-only on the command line to override the configured default per invocation.
```

 执行:  git config pull.ff false

9,修改权限,

  进入项目目录执行

 chown -R www .

 chmod -R g+s .

---------------------------------------------------------------------------------------------

# 杂项请忽略ignore

分别给每个功能都创建一个独立的分支
git checkout -b 分支名称            #创建分支
git branch                                  #查看分支
git push -u origin 分支名称        #第一次提交到云仓库需要 -u 分支名称则是准备在云仓库创建的名称
接着开发项目吧
开发完功能了
git branch
git status   		   #查看文件状态
git add .    		   #将文件添加到暂存区
git status			   #查看文件是否变绿了,绿了就代表成功添加到暂存区
git commit -m '完成了xx功能'    #提交到xx某某分支了
git push                                    #推送到云端
git checkout master                   #切换到主分支,因为主分支还不是最新的
git branch
git merge 分支名称                   #合并分支
git push                                    #将本地的master代码也推送到云端