<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="client.php"></script>
  </head>
  <body>

    <div id="center-col">
      <?php include "server.php"; printNavBar(); ?>
      <div id="page-body">
        <?php fetch(); ?>
      </div>
      <?php printFooter(); ?>
    </div>

  </body>
</html>

<?php
function fetch()
{
  $db_connection = connect();

  $id = $_GET["id"];
  $tuples = [];
  $attrs = [];
  $query = "SELECT CONCAT(first, ' ', last) AS name, sex, dob AS DOB, dod AS DOD FROM Actor WHERE id = $id;";
  issue($query, $db_connection, $tuples, $attrs);
  $tuple = $tuples[0];

  print "<h3 style='margin-bottom: 10px;'>$tuple[0]</h3>";
  print "<strong>Sex: </strong><p style='display: inline-block; margin: 2;'>$tuple[1]</p><br>";
  print "<strong>Born: </strong><p style='display: inline-block; margin: 2;'>$tuple[2]</p><br>";
  if ($tuple[3])
    print "<strong>Died: </strong><p style='display: inline-block; margin: 2;'>$tuple[3]</p><br>";

  $tuples = [];
  $attrs = [];
  $query = "SELECT mid, title, year, role FROM MovieActor JOIN Movie ON MovieActor.mid = Movie.id WHERE aid = $id;";
  issue($query, $db_connection, $tuples, $attrs);

  print '<h3>Filmography</h3>';
  printTable($attrs, $tuples, "movie");

  //Close database connection
  mysql_close($db_connection);
}
?>
