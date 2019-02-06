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
        <p>Showing results for "<?php print $_GET['keyword'] ?>"</p>
        <?php fetch(); ?>
      </div>
    </div>

  </body>
</html>

<?php
function fetch()
{
  $db_connection = connect();

  //Format query using user input
  $keyword = $_GET["keyword"];
  if ($keyword == "") {
    print "<p style='color: red;'>Please enter a keyword to search.</p>";
    mysql_close($db_connection);
    return;
  }

  $tuples = [];
  $attrs = [];
  $query = "SELECT id, CONCAT(first, ' ', last) AS name, sex, dob AS DOB, dod AS DOD FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$keyword%' OR CONCAT(last, ' ', first) LIKE '%$keyword%';";
  issue($query, $db_connection, $tuples, $attrs);

  print '<h3>Actors/Actresses</h3>';
  printTable($attrs, $tuples, "actor");

  $tuples = [];
  $attrs = [];
  $query = "SELECT id, title, year, rating, company FROM Movie WHERE title LIKE '%$keyword%';";
  issue($query, $db_connection, $tuples, $attrs);

  print '<h3>Movies</h3>';
  printTable($attrs, $tuples, "movie");

  //Close database connection
  mysql_close($db_connection);
}
?>
