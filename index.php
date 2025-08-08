<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notes_db";

// Create connection between xampp notes_db and this php
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection fail or not
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission from users to create a new note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO notes (title, content) VALUES ('$title', '$content')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect to prevent re-submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Getting all the notes from the notes_db
$notes = [];
$sql = "SELECT id, title, content, created_at FROM notes ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}

$conn->close();
?>
<!-- Designing Front End -->
<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Note-Taking App</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1, h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"], textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; resize: vertical; }
        button { background-color: #5cb85c; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #4cae4c; }
        .note-list { margin-top: 20px; }
        .note { background: #e9e9e9; padding: 15px; border-radius: 4px; margin-bottom: 10px; }
        .note-title { font-weight: bold; margin-top: 0; }
        .note-content { color: #555; }
        .note-date { font-size: 0.8em; color: #888; text-align: right; }
    </style>
</head>
<body>

<div class="container">
    <h1>Simple Note-Taking App (PHP + MySQL)</h1>
    <h2>Create a New Note</h2>
    <form action="index.php" method="POST">
        <input type="text" name="title" placeholder="Note Title" required>
        <textarea name="content" placeholder="Note Content" required></textarea>
        <button type="submit">Save Note</button>
    </form>

    <h2>Your Notes</h2>
    <div class="note-list">
        <?php if (empty($notes)): ?> <!-- a reminder to user if no new notes are created yet -->
            <p>There are no notes yet. Create one!</p>
        <?php else: ?>
            <?php foreach ($notes as $note): ?> <!-- for respective user / privacy -->
                <div class="note">
                    <h3 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h3>
                    <p class="note-content"><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                    <p class="note-date">Created: <?php echo $note['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
