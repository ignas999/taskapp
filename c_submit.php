<?php
header('Content-Type: application/json');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once "db_conn.php";

    $email = $_POST["email"];
    $name = $_POST["name"];
    $content = $_POST["content"];
    $date = date("Y-m-d");
    $parent_id = isset($_POST["parent_id"]) ? $_POST["parent_id"] : null;

    // Validate input and return any errors
    $errors = validateInput($name, $email, $content);

    if (!empty($errors)) {
        returnJsonResponse('error', $errors);
    } else {
        try {
            saveComment($pdo, $email, $name, $content, $date, $parent_id);
        } catch (PDOException $e) {
            returnJsonResponse('error', ['Database error: ' . $e->getMessage()]);
        }
    }
} else {
    header("Location: ./index.php");
}

// Function to validate form input
function validateInput($name, $email, $content) {
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate content
    if (empty($content)) {
        $errors[] = "Content is required.";
    }

    return $errors;
}

// Function to save comment to the database
function saveComment($pdo, $email, $name, $content, $date, $parent_id) {
    $query = "INSERT INTO comments (email, name, content, date, parent_id) VALUES (?, ?, ?, ?, ?);";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $name, $content, $date, $parent_id]);
}

// Function to return JSON responses
function returnJsonResponse($status, $messages) {
    echo json_encode(['status' => $status, 'messages' => (array)$messages]);
    exit();
}
?>
