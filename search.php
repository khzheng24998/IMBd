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
          <button style="width: 52px; margin-left: 101px;">Add +</button>
          <div id="dropdown">
            <p class="dropdown-option">Add comment</p>
            <p class="dropdown-option">Add actor/director</p>
            <p class="dropdown-option">Add movie</p>
            <p class="dropdown-option">Add actor to movie</p>
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
        <p>Showing results for "<?php print $_GET['keyword'] ?>"</p>
        <?php fetch(); ?>
      </div>
    </div>

  </body>
</html>

<?php
include "database.php";
function printSearchResults($attrs, $tuples, $rel) {
  //Query returned no tuples
  if (count($tuples) == 0) {
    print "<p>No results found.</p>";
    return;
  }

  //Format query results and display them in HTML table
  print '<table border="1" cellspacing="1" cellpadding="2">';

  print '<tr align="left">';
  for ($i = 0; $i < count($attrs); $i++) {
    if ($i == 0)
      continue;
    print "<th>$attrs[$i]</th>";
  }
  print "</tr>";

  foreach ($tuples as $tuple) {
    print '<tr align="left">';
    for ($i = 0; $i < count($tuple); $i++) {
      if ($i == 0)
        continue;
      if ($i == 1)
        print "<td><a href='$rel.php?id=$tuple[0]'>$tuple[$i]<a></td>";
      else
        print "<td>$tuple[$i]</td>";
    }
    print "</tr>";
  }
  print "</table>";
}

function fetch()
{
  $db_connection = connect();

  //Format query using user input
  $keyword = $_GET["keyword"];
  if ($keyword == "") {
    print "<p style='color: red;'>Please enter a keyword to search.</p>";
    return;
  }

  $rows = [];
  $cols = [];
  $query = "SELECT id, CONCAT(first, ' ', last) AS Name, sex AS Sex, dob AS DOB, dod AS DOD FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$keyword%' OR CONCAT(last, ' ', first) LIKE '%$keyword%';";
  issue($query, $db_connection, $rows, $cols);

  print '<h3>Actors/Actresses</h3>';
  printSearchResults($cols, $rows, "actor");

  $rows = [];
  $cols = [];
  $query = "SELECT id, title AS Title, year AS Year, rating AS Rating, company AS Company FROM Movie WHERE title LIKE '%$keyword%';";
  issue($query, $db_connection, $rows, $cols);

  print '<h3>Movies</h3>';
  printSearchResults($cols, $rows, "movie");

  //Close database connection
  mysql_close($db_connection);
}
?>
