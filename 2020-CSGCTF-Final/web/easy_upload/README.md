1. 注册账号
2. 通过脚本，删除 .htaccess
```
python2 uploaad.py --host http://172.16.9.20:9003/ -u admin@admin.com -p admin
```
3. 添加 task，添加 attachment（如 index.php）
4. 爆破文件名，/uploads/attachments/[0-9]{6}-index.php