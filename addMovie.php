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
          <button id="add-btn">Add +</button>
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

      <div id="page-body">

        <form action="addMovie.php" method="POST">

          <div style="display: flex;">
            <div style="flex: 25%;">
              <p class="label">Title</p>
              <input name="title" type="text">

              <p class="label">MPAA Rating</p>
              <select name="rating">
                <option value="G">G</option>
                <option value="PG">PG</option>
                <option value="PG-13">PG-13</option>
                <option value="R">R</option>
              </select>
            </div>

            <div style="flex: 75%;">
              <p class="label">Year</p>
              <input name="year" type="text">

              <p class="label">Company</p>
              <input name="company" type="text">
            </div>
          </div>

          <br><br><input type="submit" value="Submit">

        </form>

        <?php include "database.php"; updateDB(); ?>

      </div>

    </div>
  </body>
</html>

<?php
function updateDB()
{
  $db_connection = connect();

  $title = $_POST["title"];
  $year = $_POST["year"];
  $rating = $_POST["rating"];
  $company = $_POST["company"];

  if ($title == "" || $year == "" || $rating == "" || $company == "")
    print "<p style='color: red;'>One or more fields missing!</p>";
  else
  {
    $tuples = [];
    $attrs = [];

    //Get max movie id
    $query = "SELECT * FROM MaxMovieID;";
    issue($query, $db_connection, $tuples, $attrs);
    $tuple = $tuples[0];
    $id = $tuple[0];

    //Increment max movie id
    $query = "UPDATE MaxMovieID SET id = $id + 1;";
    issue($query, $db_connection, $tuples, $attrs);

    //Wrap string values in quotation marks
    $title = "'" . $title . "'";
    $rating = "'" . $rating . "'";
    $company = "'" . $company . "'";

    //Insert new Movie tuple
    $query = "INSERT INTO Movie VALUES($id, $title, $year, $rating, $company);";
    issue($query, $db_connection, $tuples, $attrs);
    print "<p>Movie added sucessfully!</p>";
  }

  //Close database connection
  mysql_close($db_connection);
}
?>
