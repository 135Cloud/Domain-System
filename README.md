# Domain-System

135Cloud 域名系統原始碼
domain.135cloud.com

如有需要使用的話，歡迎使用，但請標註來源。

目前本系統無以下功能
1. 後臺管理介面
2. 使用者管理系統(目前使用Discuz! UCenter)
3. 安裝介面

本系統基本說明
1. Namesilo自動化註冊管理
2. Plesk 主機訂閱管理
3. 金流使用ECPay

安裝需修改
config.inc.php ------------> UCenter相關
config.php ----------------> 系統設定
app\controllers\cron.php --> 通知 Email 相關
