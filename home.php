<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="client.php"></script>
  </head>
  <body>

    <div id="center-col">
      <?php include "server.php"; printNavBar(); ?>
      <div id="page-body" style="display: flex;">
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

  $tuples = [];
  $attrs = [];
  $query = "SELECT id, title, year, rating FROM Movie JOIN Sales ON Movie.id = Sales.mid WHERE year > 2002 ORDER BY ticketsSold DESC LIMIT 10;";
  issue($query, $db_connection, $tuples, $attrs);

  print '<div style="flex: 50%;">';
  print '<h3>Top Box Office</h3>';
  printTable($attrs, $tuples, "movie");
  print '</div>';

  $tuples = [];
  $attrs = [];
  $query = "SELECT id, title, year, rating, rot AS score FROM Movie JOIN MovieRating ON Movie.id = MovieRating.mid WHERE year > 2002 AND rot > 70 ORDER BY rot DESC LIMIT 10;";
  issue($query, $db_connection, $tuples, $attrs);

  print '<div style="flex: 50%;">';
  print '<h3>Critically Acclaimed*</h3>';
  printTable($attrs, $tuples, "movie");
  print "<p>*based on film's Rotten Tomatoes score</p>";
  print '</div>';

  //Close database connection
  mysql_close($db_connection);
}
?>
