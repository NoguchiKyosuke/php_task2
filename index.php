<!doctype html>
<html>

<head>
    <title>イシュー管理システム</title>

</head>

<body>

<?php
    $servername = "localhost";
    $username = "nk21137";
    $password = "yabukiisyabuki";
    $dbname = "ISSUE_MANAGEMENT";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>


    <form action="index.php" method="POST">
        <label for="Issue_ID">イシューID</label>
        <input type="number" name="Issue_ID" id="Issue_ID" required><br>
        
        <label for="Title">イシュータイトル</label>
        <input type="text" name="Title" id="Title" required><br>


        <label for="Label">選択してください</label><br>
        <input type="radio" name="Label" value="bug" required>バグ<br>
        <input type="radio" name="Label" value="feature" required>機能要求<br>

        <label for="Rank">優先順位</label>
        <input type="number" name="Rank" id="Rank" required><br>

        <label for="Status">進捗状況</label><br>
        <input type="radio" name="Status" value="not_Started" required>未着手<br>
        <input type="radio" name="Status" value="in_progress" required>着手中<br>
        <input type="radio" name="Status" value="completed" required>完了<br>

        <label for="Commit_ID">イシューコミットID</label>
        <input type="text" name="Commit_ID" id="Commit_ID" required><br>

        <label for="Complete_ID">完了コミット</label>
        <input type="text" name="Complete_ID" id="Complete_ID" required><br>

        <input type="submit" id="submit" value="submit">
    </form>

    <?php

    if(isset($_POST['submit'])){
        $issue_id = $_POST['Issue_ID'];
        $title = $_POST['Title'];
        $label = $_POST['Label'];
        $priority = $_POST['Rank'];
        $status = $_POST['Status'];
        $commit_id = $_POST['Commit_ID'];
        $complete_id = $_POST['Complete_ID'];

        $sql = "INSERT INTO issues(issue_id, title, label, priority, status, issue_commit, complete_commit) VALUES(:issue_id, :title, :label, :priority, :status, :commit_id, :complete_id);";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':issue_id', $issue_id);
        $stmt -> bindParam(':title', $title);
        $stmt -> bindParam(':label', $label);
        $stmt -> bindParam(':priority', $priority);
        $stmt -> bindParam(':status', $status);
        $stmt -> bindParam(':commit_id', $commit_id);
        $stmt -> bindParam(':complete_id', $complete_id);

        $stmt -> execute();
    }

    $sql = 'SELECT issue_id, title, label, priority, status, issue_commit, complete_commit FROM issues;';
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
   

    if ($rows) {
        echo '<table>';
        echo '<tr><th>イシューID</th><th>タイトル</th><th>ラベル</th><th>優先順位</th><th>状態</th><th>イシューコミットID</th><th>完了コミットID</th></tr>';
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['issue_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['label']) . '</td>';
            echo '<td>' . htmlspecialchars($row['priority']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';
            echo '<td>' . htmlspecialchars($row['issue_commit']) . '</td>';
            echo '<td>' . htmlspecialchars($row['complete_commit']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No data found.';
    }
    ?>


</body>

</html>
