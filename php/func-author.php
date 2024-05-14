<?php 

# Get all Author function
function get_all_author($con){
   $sql  = "SELECT * FROM authors";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch all rows into an associative array
       $authors = $result->fetch_all(MYSQLI_ASSOC);
   } else {
      $authors = 0;
   }

   return $authors;
}



# Get Author by ID function
function get_author($con, $id){
   $sql  = "SELECT * FROM authors WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   
   // Fetch the results
   $result = $stmt->get_result();

   // Check if there are any rows returned
   if ($result->num_rows > 0) {
       // Fetch the first row into an associative array
       $author = $result->fetch_assoc();
   } else {
      $author = 0;
   }

   return $author;
}
