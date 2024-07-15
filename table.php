<!doctype html>
<html>

<head>
    <title>イシュー管理システム</title>

    <link href="table.css" rel="stylesheet" type="text/css">
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


    <form action="table.php" method="POST">
        <label for="Title">イシュータイトル</label>
        <input type="text" name="Title" id="Title" required><br>


        <label for="Label">選択してください</label><br>
        <input type="radio" name="Label" value="bug" required>バグ<br>
        <input type="radio" name="Label" value="feature" required>機能要求<br>

        <label for="Rank">優先順位</label>
        <input type="number" name="Rank" id="Rank" required><br>

        <label for="Status">進捗状況</label><br>
        <input type="radio" name="Status" value="not_started" required>未着手<br>
        <input type="radio" name="Status" value="in_progress" required>着手中<br>
        <input type="radio" name="Status" value="completed" required>完了<br>

        <label for="Commit_ID">イシューコミットID</label>
        <input type="text" name="Commit_ID" id="Commit_ID" required><br>

        <label for="Complete_ID">完了コミット</label>
        <input type="text" name="Complete_ID" id="Complete_ID" required><br>

        <input type="submit" id="submit" name="submit" value="submit">
    </form>

    <?php

    if(isset($_POST['Login'])){
        $username = $_POST['Username'];
        $reponame = $_POST['Reponame'];
        
        $sql = "INSERT INTO repos(username, reponame) VALUES(:reponame, :reponame);";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(';username', $username);
        $stmt -> bindParam(':reponame', $reponame);
        $stmt -> execute();
    }


    $sql = "SELECT MAX(issue_id) AS max_id FROM issues;";
    $stmt = $pdo -> query($sql);
    $row_max_id = $stmt -> fetch(PDO::FETCH_ASSOC);
    $issue_id = $row_max_id['max_id'] + 1;
 
    if(isset($_POST['submit'])){
       
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
    }else{
        for($i = 1; $i <= $row_max_id['max_id']; $i++){ 
            if(isset($_POST[$i])){
                $sql = "UPDATE issues SET priority=:priority, status=:status,  complete_commit=:complete_commit WHERE issue_id=:issue_id;";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':issue_id', $i);
                $stmt -> bindParam(':priority', $_POST['Rank']);
                $stmt -> bindParam(':status', $_POST['Status']);
                $stmt -> bindParam(':complete_commit', $_POST['Complete_ID']);
                
                $stmt -> execute();
            }
        }
    }

    $sql = 'SELECT issue_id, title, label, priority, status, issue_commit, complete_commit FROM issues ORDER BY priority DESC;';
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();

    if ($rows) {
        echo '<table border="1">';
        echo '<tr><th>イシューID</th><th>タイトル</th><th>ラベル</th><th>イシューコミットID</th><th>状態</th><th>優先順位</th><th>完了コミットID</th></tr>';
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['issue_id']) . '<button id="url">(URL)</button></td>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['label']) . '</td>';
            echo '<td>' . htmlspecialchars($row['issue_commit']) . '</td>';
            $not_started = "";
            $in_progress = "";
            $completed = "";
            
            if(strcmp(htmlspecialchars($row['status']), "not_started") == 0){
                $not_started = "selected";
            }elseif(strcmp(htmlspecialchars($row['status']), "in_progress") == 0){
                $in_progress = "selected";
            }elseif(strcmp(htmlspecialchars($row['status']), "completed") == 0){
                $completed = "selected";
            }
            echo '<form action="table.php" method="POST">';
            echo '<td><select name="Status">';
            echo '<option value="not_started" '.$not_started.'>未着手</option>';
            echo '<option value="in_progress" '.$in_progress.'>着手中</option>';
            echo '<option value="completed" '.$completed.'>完了</option>';
            echo '</select></td>';
            echo '<td><input type="number" name="Rank" id="Rank" value='.htmlspecialchars($row['priority']).'><br></td>';
            echo '<td><input type="text" name="Complete_ID" id="Complete_ID" value='.htmlspecialchars($row['complete_commit']).'><br></td>';
            echo '<td><input type="submit" id="'.htmlspecialchars($row['issue_id']).'" name="'.htmlspecialchars($row['issue_id']).'" value="更新"></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No data found.';
    }
    ?>

    <div id="popup" class="popup">
        <a href="https://github.com">https://github.com</a>
        <button id="hide_popup">非表示</button>"
    </div>

    <script src="table.js"></script>

</body>

</html>
