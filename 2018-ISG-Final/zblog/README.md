#### FLAG：
```
本地文件 /flag
```

#### 搭建:
```
# Environment: 
#	 Ubuntu 16.04 x64
# Requirements:
sudo su
apt update && apt upgrade -y && apt dist-upgrade -y
apt install apache2 php libapache2-mod-php mysql-server php-mysql php-xml python-pip
# Copy source
rm -rf /var/www/html
cp -r ./sources /var/www/
mv /var/www/sources /var/www/html
# Folder permission
chmod o+w /var/www/html/zb_users/plugin
chmod o+w /var/www/html/zb_users/upload
chmod o+w /var/www/html/zb_users/data
chmod o+w /var/www/html/zb_users/logs
chmod o+w /var/www/html/zb_users/cache
chown www-data:www-data /var/www/html/zb_users/c_options.php
chown a-w /var/www/html/zb_users/c_options.php
# Disable apache Indexes
<Directory /var/www>
        Options -Indexes -FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
# Restart server
service apache2 restart
# Disable `Totoro反垃圾评论`
# 1. Login
# 2. Enter: 插件管理
# 3. Disable `Totoro反垃圾评论`
# Run checker
```

#### 考察点:
* 任意文件读取 √
* 后台 GetShell (要求 plugins 目录可写) √
* 弱口令 √
	* 需要配置 admin/admin123 的管理员账号
* 高级后门利用 √
* 初级后门利用 √

#### Checker:
* 登陆功能
* 创建 Plugin 功能
* 留言功能
* 通用防御
