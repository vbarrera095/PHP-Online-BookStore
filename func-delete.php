<?php
// Include the database connection file
include 'db_conn.php';

// Check if the connection to the database was successful
if (!$conn) {
    // If not, display an error message and terminate the script
    echo "Error connecting to the database: " . mysqli_connect_error();
    exit();
}

// Check if a book has been selected for deletion
if (isset($_POST['delete-book'])) {
    // Get the selected book ID
    $book_id = $_POST['delete-book'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("i", $book_id);
        if ($stmt->execute()) {
            // Book deleted successfully
            echo "<script>alert('Book was deleted successfully!');</script>";
            header("Location: admin.php");
            exit();
        } else {
            // Error occurred while deleting the book
            echo "<script>alert('There was an issue trying to delete the book. Try again?');</script>";
            header("Location: admin.php");
            exit();
        }
    } else {
        // Error preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // No book selected for deletion
    echo "<script>alert('No book selected for deletion.');</script>";
    header("Location: admin.php");
    exit();
}

// Close the database connection
$conn->close();
?>
