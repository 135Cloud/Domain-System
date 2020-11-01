<div class="card mb-4">
    <div class="card-body">
    <p>為您的帳戶添加雙因素認證，獲得額外的安全保護。添加雙因素認證之後需要您的密碼以及您的手機/設備才能登入您的帳戶。</p>
    <p>請按照以下步驟為您的帳戶啟用雙因素認證。我們推薦的 <a href="https://authy.com">Authy</a> ，因為它可以安全的備份您的 2FA 代碼，防止您的設備遺失。</p>
    <p> 這裡是一些可用於 2FA 的應用程式 </p>
    <ul>
        <li><a href="https://authy.com" target="_blank">Authy</a></li>
        <li><a href="https://www.microsoft.com/zh-tw/account/authenticator" target="_blank">Microsoft Authenticator</a></li>
        <li><a href="https://support.google.com/accounts/answer/1066447" target="_blank">Google Authenticator</a></li>
	</ul>
    <p> 2FA 設定步驟</p>
	<ol>
		<li>打開你使用的 2FA 應用程式</li>
		<li>掃描下方 QR Code 或輸入 <?=$_HTML['2fa_key']?></li>
		<li>最下方輸入出現於 2FA 應用程式中六位數密碼作為確認</li>
	</ol>
    <img src="<?=$_HTML['2fa_img']?>">
    <br>
    <p>提醒您，因無法登入而刪除雙因素身份驗證的過程對您自己和我們的人員來說都很麻煩且耗時，因此如果您確定可以隨時訪問您的設備，才添加雙因素驗證至您的帳戶。</p>
	<p>我們強烈建議您將上面列出的 QR Code 和代碼的備份保存在安全的地方。這將可以讓您在遺失、重新格式化或無法訪問當前設備的情況下輕鬆地將雙因素驗證添加回設備上。</p>
    <form method="POST">
        <div class="form-group">
            <label>應用程式產生的代碼</label>
            <input type="password" class="form-control<?=@$_HTML['status']?>" name="2fa">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
</div>