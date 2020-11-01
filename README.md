# 135Cloud Domain System 1.0.0()

135Domain 原始碼

https://domain.135cloud.com

如有需要使用的話，歡迎使用，但請標註來源。

由於目前 135Cloud 使用環境為，用戶管理藉由 UCenter 管理，後續版本會新增自己的用戶管理功能。

目前本系統無以下功能
1. 後臺管理介面
2. 使用者管理系統(目前使用Discuz! UCenter)
3. 安裝介面

本系統基本說明
1. Namesilo自動化註冊管理
2. Plesk 主機訂閱管理
3. 金流使用ECPay

目前安裝需修改以下檔案並手動匯入資料表
1. config.inc.php // UCenter相關
2. config.php // 系統設定
3. app\controllers\cron.php // 通知 Email 相關
