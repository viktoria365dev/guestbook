<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $message = htmlspecialchars($_POST["message"]);
    $entry = $name . " | " . $message . " | " . date("Y-m-d H:i:s") . "\n";

    file_put_contents("data.txt", $entry, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Guestbook</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
  <h1>Guestbook</h1>

  <!-- Form -->
  <form method="post" action="">
    <input type="text" name="name" placeholder="Your name" required><br><br>
    <textarea name="message" placeholder="Your message" required></textarea><br><br>
    <button type="submit">Sign Guestbook</button>
  </form>
  <hr>

  <h2>Messages</h2>
<?php
if (file_exists("data.txt")) {
    $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_reverse($lines); // newest first
    foreach ($lines as $line) {
        list($name, $message, $time) = explode(" | ", $line);
        echo "<p><strong>$name</strong> ($time):<br>$message</p><hr>";
    }
}
?>
</body>
</html>

