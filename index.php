<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

      // Honeypot spam check
    if (!empty($_POST["website"])) { 
        exit; 
    }

    $name = htmlspecialchars($_POST["name"]);
    $message = htmlspecialchars($_POST["message"]);

    // Enforce 500 character limit on server side too
    $message = substr($message, 0, 500);

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
    <input type="text" name="website" style="display:none">
    <input type="text" name="name" placeholder="Your name" required>
    <textarea id="message" name="message" placeholder="Your message (max 500 chars)" maxlength="500" required></textarea>
    <div id="counter">0 / 500</div>
    <button type="submit">Sign Guestbook</button>
  </form>

  <div class="messages">
    <h2>Messages</h2>
    <?php
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_reverse($lines); // newest first
        echo "<p><em>Total messages: " . count($lines) . "</em></p>";

        foreach ($lines as $line) {
            list($name, $message, $time) = explode(" | ", $line);
            echo "<div class='entry'>";
            echo "<p><strong>$name</strong> <span class='time'>($time)</span></p>";
            echo "<p>$message</p>";
            echo "<p><small>Length: " . strlen($message) . " characters</small></p>";
            echo "</div>";
        }
    }
    ?>
  </div>

  <script>
    const textarea = document.getElementById('message');
    const counter = document.getElementById('counter');
    textarea.addEventListener('input', () => {
      counter.textContent = textarea.value.length + " / 500";
    });
  </script>
</body>
</html>
