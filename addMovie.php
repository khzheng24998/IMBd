<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="client.php"></script>
  </head>
  <body>

    <div id="center-col">
      <?php include "server.php"; printNavBar(); ?>
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
        <?php updateDB(); ?>
      </div>
      <?php printFooter(); ?>
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

  if ($title == "" || $year == "" || $rating == "" || $company == "") {
    print "<p style='color: red;'>One or more fields missing!</p>";
    mysql_close($db_connection);
    return;
  }

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

  //Close database connection
  mysql_close($db_connection);
}
?>
