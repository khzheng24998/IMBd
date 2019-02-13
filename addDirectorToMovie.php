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
        <div id="add-title">
          <h3 style="margin: 0px;">Add a director to a movie</h3>
        </div>
        <form action="addDirectorToMovie.php" method="POST">

          <p class="label">Director</p>
          <select name="did">
            <?php fetchDirectors(); ?>
          </select>

          <p class="label">Movie</p>
          <select name="mid">
            <?php fetchMovies(); ?>
          </select>

          <br><br><input type="submit" value="Submit">

        </form>
        <?php updateDB(); ?>
      </div>
      <?php printFooter(); ?>
    </div>
  </body>
</html>

<?php
function fetchDirectors()
{
  $db_connection = connect();
  $tuples = [];
  $attrs = [];
  $query = "SELECT id, CONCAT(first, ' ', last) AS name FROM Director ORDER BY name;";
  issue($query, $db_connection, $tuples, $attrs);

  foreach ($tuples as $tuple) {
      print "<option value=$tuple[0]>$tuple[1]</option>";
  }

  //Close database connection
  mysql_close($db_connection);
}

function fetchMovies()
{
  $db_connection = connect();
  $tuples = [];
  $attrs = [];
  $query = "SELECT id, title FROM Movie ORDER BY title;";
  issue($query, $db_connection, $tuples, $attrs);

  foreach ($tuples as $tuple) {
      print "<option value=$tuple[0]>$tuple[1]</option>";
  }

  //Close database connection
  mysql_close($db_connection);
}

function updateDB()
{
  $db_connection = connect();
  $did = $_POST["did"];
  $mid = $_POST["mid"];

  $tuples = [];
  $attrs = [];

  //Insert new MovieDirector tuple
  $query = "INSERT INTO MovieDirector VALUES($mid, $did);";
  issue($query, $db_connection, $tuples, $attrs);
  print "<p>Movie-Director relation added sucessfully!</p>";

  //Close database connection
  mysql_close($db_connection);
}
?>
