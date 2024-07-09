<!doctype html>
<html>

<head>
    <title>イシュー管理システム</title>

<head>

<body>

<?php
    $servername = "localhost";
    $username = "nk21137";
    $password = "yabukiisyabuki";
    $dbname = "ISSUE_MANAGEMENT";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql = 'SELECT username, reponame FROM repos';
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll();
?>


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

    <?php
    if ($rows) {
        echo '<table>';
        echo '<tr><th>username</th><th>reponame</th></tr>';
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['reponame']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No data found.';
    }
    ?>


</body>

</html>
