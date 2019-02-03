<html>
  <head>
    <link rel="stylesheet" href="style.php">
  </head>
  <body>

    <div id="center-col">
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
    </div>

  </body>
</html>

<?php
function printBio($tuple) {

  print "<h3 style='margin-bottom: 10px;'>$tuple[0]</h3>";
  print "<strong>Sex: </strong><p style='display: inline-block; margin: 2;'>$tuple[1]</p><br>";
  print "<strong>Born: </strong><p style='display: inline-block; margin: 2;'>$tuple[2]</p><br>";

  if ($tuple[3])
    print "<strong>Died: </strong><p style='display: inline-block; margin: 2;'>$tuple[3]</p><br>";
}

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
  $query = "SELECT CONCAT(first, ' ', last) AS Name, sex AS Sex, dob AS DOB, dod AS DOD FROM Actor WHERE id = $id;";
  issueQuery($query, $db_connection, $rows, $cols);
  printBio($rows[0]);

  $rows = [];
  $cols = [];
  $query = "SELECT mid, title AS Title, year AS Year, role AS Role FROM MovieActor JOIN Movie ON MovieActor.mid = Movie.id WHERE aid = $id;";
  issueQuery($query, $db_connection, $rows, $cols);

  print '<h3>Filmography</h3>';
  printResults($cols, $rows, "movie");

  //Close database connection
  mysql_close($db_connection);
}
?>
