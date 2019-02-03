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

    <div id="results" style="padding: 15px 0px 15px 15px;">
      <p>Showing results for "<?php print $_GET['keyword'] ?>"</p>
      <?php fetch(); ?>
    </div>

  </body>
</html>

<?php

  /* Helper functions */

  function printResults($attrs, $tuples) {
    //Query returned no tuples
    if (count($tuples) == 0) {
      print "<p>No results found.</p>";
      return;
    }

    //Format query results and display them in HTML table
    print '<table border="1" cellspacing="1" cellpadding="2">';
    print '<tr align="center">';
    foreach ($attrs as $attr)
      print "<th>$attr</th>";
    print "</tr>";
    foreach ($tuples as $tuple) {
      print '<tr align="center">';
      foreach ($tuple as $val)
        print "<td>$val</td>";
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
    $keyword = $_GET["keyword"];
    if ($keyword == "") {
      print "<p style='color: red;'>Please enter a keyword to search.</p>";
      return;
    }

    $rows = [];
    $cols = [];
    $query = "SELECT * FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$keyword%' OR CONCAT(last, ' ', first) LIKE '%$keyword%';";
    issueQuery($query, $db_connection, $rows, $cols);

    print '<h3>Actors/Actresses</h3>';
    printResults($cols, $rows);

    $rows = [];
    $cols = [];
    $query = "SELECT * FROM Movie WHERE title LIKE '%$keyword%';";
    issueQuery($query, $db_connection, $rows, $cols);

    print '<h3>Movies</h3>';
    printResults($cols, $rows);

    //Close database connection
    mysql_close($db_connection);
  }
?>
