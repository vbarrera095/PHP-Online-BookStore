<?php  

# Get All books function
function get_all_books($con){
   $sql  = "SELECT * FROM books ORDER BY id DESC";
   $stmt = $con->prepare($sql);
   $stmt->execute();
   
   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch all rows into an associative array
       $books = $result->fetch_all(MYSQLI_ASSOC);
   } else {
      $books = 0;
   }

   return $books;
}

# Get  book by ID function
function get_book($con, $id){
   $sql  = "SELECT * FROM books WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   // Fetch the result
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
   	  $book = $result->fetch_assoc();
   }else {
      $book = 0;
   }

   return $book;
}


# Search books function
function search_books($con, $key){
   # creating simple search algorithm :) 
   $key = "%{$key}%";

   $sql  = "SELECT * FROM books 
            WHERE title LIKE ?
            OR description LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->bind_param("ss", $key, $key);
   $stmt->execute();

   // Fetch the results
   $result = $stmt->get_result();

   // Initialize the variable to count rows
   $count = 0;

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
        // Fetch all rows into an associative array
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
            $count++;
        }
   } else {
      $books = 0;
   }

   // Check the count to determine if any rows were found
   if ($count > 0) {
       return $books;
   } else {
       return 0;
   }
}

# get books by category
function get_books_by_category($con, $id){
   $sql  = "SELECT * FROM books WHERE category_id=?";
   $stmt = $con->prepare($sql);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   
   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch all rows into an associative array
       $books = $result->fetch_all(MYSQLI_ASSOC);
   } else {
      $books = 0;
   }

   return $books;
}

// Function to get books by author ID
function get_books_by_author($conn, $author_id) {
   // Prepare SQL statement
   $sql = "SELECT * FROM books WHERE author_id = $author_id";

   // Execute query
   $result = $conn->query($sql);

   // Check if there are results
   if ($result->num_rows > 0) {
       // Fetch associative array of results
       $books = array();
       while ($row = $result->fetch_assoc()) {
           $books[] = $row;
       }
       return $books;
   } else {
       // Return 0 if no books found
       return 0;
   }
}

# Search books by author's name function
function search_books_by_author($con, $author_name) {
   $key = "%{$author_name}%";

   $sql = "SELECT b.id, b.title, b.author_id, b.description, b.category_id, b.cover, b.file 
           FROM books b 
           INNER JOIN authors a ON b.author_id = a.id 
           WHERE a.name LIKE ?";

   $stmt = $con->prepare($sql);
   $stmt->bind_param("s", $key);
   $stmt->execute();

   // Fetch the results
   $result = $stmt->get_result();

   // Initialize the variable to count rows
   $count = 0;

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
        // Fetch all rows into an associative array
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
            $count++;
        }
   } else {
      $books = 0;
   }

   // Check the count to determine if any rows were found
   if ($count > 0) {
       return $books;
   } else {
       return 0;
   }
}
