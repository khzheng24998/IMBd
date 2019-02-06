<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="functions.php"></script>
  </head>
  <body>

    <div id="center-col">
      <?php include "database.php"; printNavBar(); ?>
      <div id="page-body">
        <?php fetch(); ?>
      </div>
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
  $query = "SELECT title, year, rating, genre, CONCAT(first, ' ', last), company FROM Movie, MovieDirector, MovieGenre, Director WHERE Movie.id = MovieDirector.mid AND Movie.id = MovieGenre.mid AND MovieDirector.did = Director.id AND Movie.id = $id;";
  issue($query, $db_connection, $tuples, $attrs);

  $tuple = $tuples[0];
  print "<h3 style='margin-bottom: 10px;'>$tuple[0] ($tuple[1])</h3>";
  print "<div style='font-size: 13px;'>$tuple[2] | $tuple[3]</div>";
  print "<strong style='display: inline-block;'>Director:&nbsp;</strong><p style='display: inline-block; margin-bottom: 3px;'>$tuple[4]</p><br>";
  print "<strong style='display: inline-block;'>Production Company:&nbsp;</strong><p style='display: inline-block; margin-top: 3px;'>$tuple[5]</p><br>";

  $tuples = [];
  $attrs = [];
  $query = "SELECT aid, CONCAT(first, ' ', last) AS name, role FROM MovieActor JOIN Actor ON MovieActor.aid = Actor.id WHERE mid = $id;";
  issue($query, $db_connection, $tuples, $attrs);

  print '<h3>Cast</h3>';
  printTable($attrs, $tuples, "actor");

  //Close database connection
  mysql_close($db_connection);
}
?>
