<html>
  <body>
    <p>Type a valid MySQL query into the box below and then click the submit button to see the result.</p>

    <form action="query.php" method="GET">
      <textarea name="query" cols="60" rows="8"><?php print "$query" ?></textarea><br />
      <input type="submit" value="Submit" />
    </form>

  </body>
</html>

<?php

  print '<span>Last submitted query: </span>';
  print $_GET["query"];
  print '<h3>Results:</h3>';

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

  //Sanitize user input
  $query = $_GET["query"];
  //$query = str_replace(array("\n", "\r"), ' ', $query);  //Replace newlines with spaces
  //$sanitized_query = mysql_real_escape_string($query, $db_connection);
  $sanitized_query = $query;

  //Issue query to database
  $rs = mysql_query($sanitized_query, $db_connection);
  if (!$rs) {
    $errmsg = mysql_error($rs);
    print "Query issue failed. $errmsg";
    exit(1);
  }

  //Retrieve column names and store them in $cols
  $cols = [];
  for ($i = 0; $i < mysql_num_fields($rs); $i++)
  {
    $meta = mysql_fetch_field($rs, $i);
    array_push($cols, $meta->name);
  }

  //Retrieve query results and store them in $rows
  $rows = [];
  while ($row = mysql_fetch_row($rs))
    array_push($rows, $row);

  $affected = mysql_affected_rows($db_connection);
  print "Total affected rows: $affected";

  //Format query results and display them in HTML table
  print '<table border="1" cellspacing="1" cellpadding="2">';

  print '<tr align="center">';
  foreach ($cols as $col)
    print "<th>$col</th>";
  print "</tr>";

  foreach ($rows as $row) {
    print '<tr align="center">';
    foreach ($row as $val)
      print "<td>$val</td>";
    print "</tr>";
  }

  print "</table>";

  //Close database connection
  mysql_close($db_connection);
?>
