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
          <h3 style="margin: 0px;">Add an actor to a movie</h3>
        </div>
        <form action="addActorToMovie.php" method="POST">

          <p class="label">Actor</p>
          <select name="aid">
            <?php fetchActors(); ?>
          </select>

          <p class="label">Movie</p>
          <select name="mid">
            <?php fetchMovies(); ?>
          </select>

          <p class="label">Role</p>
          <input type="text" name="role" required>

          <br><br><input type="submit" value="Submit">

        </form>
        <?php updateDB(); ?>
      </div>
      <?php printFooter(); ?>
    </div>
  </body>
</html>

<?php
function fetchActors()
{
  $db_connection = connect();
  $tuples = [];
  $attrs = [];
  $query = "SELECT id, CONCAT(first, ' ', last) AS name FROM Actor ORDER BY name;";
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

  $aid = $_POST["aid"];
  $mid = $_POST["mid"];
  $role = $_POST["role"];

  if ($role == "") {
    mysql_close($db_connection);
    return;
  }

  $tuples = [];
  $attrs = [];

  //Wrap string values in quotation marks
  $role = "'" . $role . "'";

  //Insert new MovieActor tuple
  $query = "INSERT INTO MovieActor VALUES($mid, $aid, $role);";
  issue($query, $db_connection, $tuples, $attrs);
  print "<p>Movie-Actor relation added sucessfully!</p>";

  //Close database connection
  mysql_close($db_connection);
}
?>
