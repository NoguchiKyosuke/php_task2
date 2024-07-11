<!doctype html>
<html>

<head>
    <title>ログイン_イシュー管理システム</title>

</head>

<body>

    <form action="table.php" method="POST">
        <label for="Username">ユーザ名</label>
        <input type="text" name="Username" id="Username" required><br>

        <label for="Reponame">レポジトリ名</label>
        <input type="text" name="Reponame" id="Reponame" required><br>

        <input type="submit" id="Login" name="Login" value="ログイン">
    </form>

</body>

</html>
