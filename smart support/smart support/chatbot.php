
<?php
$host = 'localhost';
$dbname = 'chatbot_db';
$username = 'root'; // Change if using a different user
$password = ''; // Set your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Save message to database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = $_POST['message'];
    $bot_response = $_POST['response'];
    
    $stmt = $pdo->prepare("INSERT INTO messages (user_message, bot_response) VALUES (?, ?)");
    $stmt->execute([$user_message, $bot_response]);
    
    echo json_encode(["status" => "success"]);
    exit;
}

// Fetch chat history
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT user_message, bot_response, timestamp FROM messages ORDER BY timestamp ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
?>