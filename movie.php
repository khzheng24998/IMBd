<html>
  <head>
    <link rel="stylesheet" href="style.php">
  </head>
  <body style="padding: 0; margin: 0;">
    <div id="navbar">

      <!--<div id="title" style="display: inline-block; background-color: #f3ce00; height: 50px; width: 75px;">
        <p>IMBd</p>
      </div>-->

      <div id="search" style="display: inline-block; padding: 0px 0px 0px 10px;">
        <form action="search.php" method="GET" style="margin: 0px;">
          <input name="keyword" type="text"><input type="submit" value="Submit">
        </form>
      </div>

    </div>

    <div id="page-body" style="padding: 5px 0px 15px 15px;">
      <?php fetch(); ?>
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

  print '<tr align="center">';
  for ($i = 0; $i < count($attrs); $i++) {
    if ($i == 0)
      continue;
    print "<th>$attrs[$i]</th>";
  }
  print "</tr>";

  foreach ($tuples as $tuple) {
    print '<tr align="center">';
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

  //Format query using user input
  $id = $_GET["id"];

  $rows = [];
  $cols = [];
  $query = "SELECT title, year, rating, genre, CONCAT(first, ' ', last), company FROM Movie, MovieDirector, MovieGenre, Director WHERE Movie.id = MovieDirector.mid AND Movie.id = MovieGenre.mid AND MovieDirector.did = Director.id AND Movie.id = $id;";
  issueQuery($query, $db_connection, $rows, $cols);

  $tuple = $rows[0];
  print "<h3 style='margin-bottom: 10px;'>$tuple[0] ($tuple[1])</h3>";
  print "<div style='font-size: 13px;'>$tuple[2] | $tuple[3]</div>";
  print "<strong style='display: inline-block;'>Director:&nbsp;</strong><p style='display: inline-block; margin-bottom: 3px;'>$tuple[4]</p><br>";
  print "<strong style='display: inline-block;'>Production Company:&nbsp;</strong><p style='display: inline-block; margin-top: 3px;'>$tuple[5]</p><br>";

  $rows = [];
  $cols = [];
  $query = "SELECT aid, CONCAT(first, ' ', last) AS Name, role AS Role FROM MovieActor JOIN Actor ON MovieActor.aid = Actor.id WHERE mid = $id;";
  issueQuery($query, $db_connection, $rows, $cols);

  print '<h3>Cast</h3>';
  printResults($cols, $rows, "actor");

  //Close database connection
  mysql_close($db_connection);
}
?>
