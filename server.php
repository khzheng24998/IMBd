<?php
function connect()
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
  return $db_connection;
}

function issue($query, $db_connection, &$tuples, &$attrs)
{
  //Issue query to database
  $rs = mysql_query($query, $db_connection);
  if (!$rs) {
    $errmsg = mysql_error($db_connection);
    print "Query issue failed. $errmsg";
    exit(1);
  }

  //Retrieve query results and store them in $tuples
  $tuples = [];
  while ($tuple = mysql_fetch_row($rs))
    array_push($tuples, $tuple);

  //Retrieve column names and store them in $attrs
  $attrs = [];
  for ($i = 0; $i < mysql_num_fields($rs); $i++) {
    $meta = mysql_fetch_field($rs, $i);
    array_push($attrs, $meta->name);
  }
}

function printTable($attrs, $tuples, $rel)
{
  //Query returned no tuples
  if (count($tuples) == 0) {
    print "<p>No results found.</p>";
    return;
  }

  //Format query results and display them in HTML table
  print '<table border="1" cellspacing="1" cellpadding="2">';

  print '<tr align="left">';
  for ($i = 0; $i < count($attrs); $i++) {
    if ($i == 0) //Ignore first attribute (this should be the id, which we don't want to show the user)
      continue;
    $attr = ucfirst($attrs[$i]);  //Capitalize first character of attribute name
    print "<th>$attr</th>";
  }
  print "</tr>";

  foreach ($tuples as $tuple) {
    print '<tr align="left">';
    for ($i = 0; $i < count($tuple); $i++) {
      if ($i == 0) //Ignore first attribute (this should be the id, which we don't want to show the user)
        continue;
      if ($i == 1) //The second attribute is a link
        print "<td><a href='$rel.php?id=$tuple[0]'>$tuple[$i]<a></td>";
      else
        print "<td>$tuple[$i]</td>";
    }
    print "</tr>";
  }
  print "</table>";
}

function printNavBar()
{
  print '<div id="navbar">

    <div id="logo" onclick="returnToHome()">
      <p id="logo-text">IMBd</p>
    </div>

    <div id="add" style="display: inline-block; padding: 0px 0px 0px 10px;">
      <button id="add-btn">Add +</button>
      <div id="dropdown">
        <p id="addComment" class="dropdown-option">Add comment</p>
        <p id="addPerson" class="dropdown-option">Add actor/director</p>
        <p id="addMovie" class="dropdown-option">Add movie</p>
        <p id="addActorToMovie" class="dropdown-option">Add actor to movie</p>
        <p id="addDirectorToMovie" class="dropdown-option">Add director to movie</p>
      </div>
    </div>

    <div id="search" style="display: inline-block; padding: 0px 0px 0px 10px;">
      <form action="search.php" method="GET" style="margin: 0px;">
        <input name="keyword" type="text"><input type="submit" value="Search">
      </form>
    </div>

  </div>';
}

function printFooter()
{
  print '<div id="footer">
    <p>Site designed by Kenny Zheng</p>
  </div>';
}
?>
