<div class="card mb-4">
    <div class="card-body">
        <form method="POST">
            <p> 2FA 已設定，如要關閉請於下方輸入程式產生的 6 位數 token</p>
            <p><?=@$_HTML['status'] ?></p>
            <div class="form-group">
                <label>2FA token</label>
                <input type="password" class="form-control" name="2fa">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>