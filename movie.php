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
        <?php fetch(); ?>
      </div>
      <?php printFooter(); ?>
    </div>

  </body>
</html>

<?php
function printReviews($tuples, $attrs)
{
  print '<table border="1" cellspacing="1" cellpadding="2">';

  print '<tr align="left">';
  for ($i = 0; $i < count($attrs); $i++) {
    $attr = ucfirst($attrs[$i]);  //Capitalize first character of attribute name
    print "<th>$attr</th>";
  }
  print "</tr>";

  foreach ($tuples as $tuple) {
    print '<tr align="left">';
    for ($i = 0; $i < count($tuple); $i++)
        print "<td>$tuple[$i]</td>";
    print "</tr>";
  }
  print "</table>";
}

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

  $query = "SELECT AVG(rating), COUNT(*) FROM Review WHERE mid = $id;";
  issue($query, $db_connection, $tuples, $attr);
  $tuple = $tuples[0];
  $avg = $tuple[0];
  $count = $tuple[1];

  print '<br><div style="border-top: 1px solid black;">';
  print '<h3>User Reviews</h3>';
  if ($count > 0) {
    print "<p>Average score for this movie is $avg based on reviews from $count user(s).</p>";
    $query = "SELECT name, time, rating, comment FROM Review WHERE mid = $id;";
    issue($query, $db_connection, $tuples, $attr);
    printReviews($tuples, $attr);
  }
  else
    print "<p>No reviews to show.</p>";
  print "<p><a href='addComment.php?mid=$id'>Add your own review!</a></p>";
  print '</div>';

  //Close database connection
  mysql_close($db_connection);
}
?>
