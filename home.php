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
          <button id="add-btn" style="width: 52px; margin-left: 101px;">Add +</button>
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

      <div id="page-body" style="display: flex;">
        <?php fetch(); ?>
      </div>

    </div>
  </body>
</html>

<?php
function printResults($attrs, $tuples, $rel) {
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

function issueQuery($query, $db_connection, &$rows, &$cols) {
  //Issue query to database
  $rs = mysql_query($query, $db_connection);
  if (!$rs) {
    $errmsg = mysql_error($rs);
    print "Query issue failed. $errmsg";
    exit(1);
  }

  //Retrieve query results and store them in $rows
  $rows = [];
  while ($row = mysql_fetch_row($rs))
    array_push($rows, $row);

  //Retrieve column names and store them in $cols
  $cols = [];
  for ($i = 0; $i < mysql_num_fields($rs); $i++) {
    $meta = mysql_fetch_field($rs, $i);
    array_push($cols, $meta->name);
  }
}

function fetch()
{
  //Establish connection to MySQL database
  $db_connection = mysql_connect("localhost", "cs143", "");
  if (!$db_connection) {
    $errmsg = mysql_error($db_connection);
    print "Connection failed. $errmsg";
    exit(1);
  }

  //Select database to query
  $db = "CS143";
  mysql_select_db($db, $db_connection);

  $rows = [];
  $cols = [];
  $query = "SELECT id, title AS Title, year AS Year, rating AS Rating FROM Movie JOIN Sales ON Movie.id = Sales.mid WHERE year > 2002 ORDER BY ticketsSold DESC LIMIT 10;";
  issueQuery($query, $db_connection, $rows, $cols);

  print '<div style="flex: 50%;">';
  print '<h3>Top Box Office</h3>';
  printResults($cols, $rows, "movie");
  print '</div>';

  $rows = [];
  $cols = [];
  $query = "SELECT id, title AS Title, year AS Year, rating AS Rating, rot AS Score FROM Movie JOIN MovieRating ON Movie.id = MovieRating.mid WHERE year > 2002 AND rot > 70 ORDER BY rot DESC LIMIT 10;";
  issueQuery($query, $db_connection, $rows, $cols);

  print '<div style="flex: 50%;">';
  print '<h3>Critically Acclaimed*</h3>';
  printResults($cols, $rows, "movie");
  print "<p>*based on film's Rotten Tomatoes score</p>";
  print '</div>';

  //Close database connection
  mysql_close($db_connection);
}
?>
