<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="functions.php"></script>
  </head>
  <body>

    <div id="center-col">
      <div id="navbar">

        <div id="logo" onclick="returnToHome()">
          <p id="logo-text">IMBd</p>
        </div>

        <div id="add" style="display: inline-block; padding: 0px 0px 0px 10px;">
          <button id="add-btn" style="width: 52px; margin-left: 101px;">Add +</button>
          <div id="dropdown">
            <p id="addComment" class="dropdown-option">Add comment</p>
            <p id="addPerson" class="dropdown-option">Add actor/director</p>
            <p id="addMovie" class="dropdown-option">Add movie</p>
            <p id="addActorToMovie" class="dropdown-option">Add actor to movie</p>
            <p class="dropdown-option">Add director to movie</p>
          </div>
        </div>

        <div id="search" style="display: inline-block; padding: 0px 0px 0px 10px;">
          <form action="search.php" method="GET" style="margin: 0px;">
            <input name="keyword" type="text"><input type="submit" value="Search">
          </form>
        </div>

      </div>

      <div id="page-body" style="display: flex;">

        <form action="addComment.php" method="GET">

          <div style="display: inline-block;">
            <p class="label">Name</p>
            <input name="name" type="text"><br>
          </div>

          <div style="display: inline-block; margin-left: 50px;">
            <p class="label">Rating</p>
            <select>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>

          <p class="label">Movie</p>
          <select>
            <?php include "database.php"; fetchMovies(); ?>
          </select>

          <p class="label">Comments</p>
          <textarea name="query" cols="60" rows="8"></textarea><br><br>
          <input type="submit" value="Submit" />
        </form>

      </div>

    </div>
  </body>
</html>

<?php
function fetchMovies()
{
  //Establish connection to MySQL database
  $db_connection = connect();

  $rows = [];
  $cols = [];
  $query = "SELECT id, title FROM Movie;";
  issue($query, $db_connection, $rows, $cols);

  foreach ($rows as $row)
    print "<option value=$row[0]>$row[1]</option>";

  //Close database connection
  mysql_close($db_connection);
}
?>
