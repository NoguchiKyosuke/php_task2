<!doctype html>
<html>

<head>
    <title>イシュー管理システム</title>

<head>

<body>
    <form action="index.php" method="POST">
        <label for="Title">イシュータイトル</label>
        <input type="text" name="Title" id="Title" repuired><br>

        <label for="Label">選択してください</label><br>
        <input type="radio" name="Label" value="bug" repuired>バグ<br>
        <input type="radio" name="Label" value="repuirement" repuired>機能要求<br>

        <label for="Rank">優先順位</label>
        <input type="number" name="Rank" id="Rank" repuired><br>

        <label for="ID">イシューコミットID</label>
        <input type="text" name="ID" id="ID" repuired><br>
        
        <input type="submit" value="submit">
    </form>
    
</body>

</html>
