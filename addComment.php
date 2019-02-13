<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="client.php"></script>
  </head>
  <body>

    <div id="center-col">
      <?php include "server.php"; printNavBar(); ?>
      <div id="page-body">
        <div id="add-title">
          <h3 style="margin: 0px;">Add a comment</h3>
        </div>
        <form action="addComment.php" method="GET">

          <div style="display: inline-block;">
            <p class="label">Name</p>
            <input name="name" type="text" required>
          </div>

          <div style="display: inline-block; margin-left: 50px;">
            <p class="label">Rating</p>
            <select name="rating">
              <option value=1>1</option>
              <option value=2>2</option>
              <option value=3>3</option>
              <option value=4>4</option>
              <option value=5>5</option>
            </select>
          </div>

          <p class="label">Movie</p>
          <select name="mid">
            <?php fetchMovies(); ?>
          </select>

          <p class="label">Comment</p>
          <textarea name="comment" cols="66" rows="8"></textarea><br><br>
          <input type="submit" value="Submit">
        </form>
        <?php updateDB(); ?>
      </div>
      <?php printFooter(); ?>
    </div>
  </body>
</html>

<?php
function fetchMovies()
{
  $db_connection = connect();
  $tuples = [];
  $attrs = [];
  $query = "SELECT id, title FROM Movie ORDER BY title;";
  issue($query, $db_connection, $tuples, $attrs);

  $mid = $_GET["mid"];
  foreach ($tuples as $tuple) {
    if ($mid != "" && $mid == $tuple[0])
      print "<option value=$tuple[0] selected>$tuple[1]</option>";
    else
      print "<option value=$tuple[0]>$tuple[1]</option>";
  }

  //Close database connection
  mysql_close($db_connection);
}

function updateDB()
{
  $db_connection = connect();
  $name = $_GET["name"];
  $rating = $_GET["rating"];
  $mid = $_GET["mid"];
  $comment = $_GET["comment"];
  $time = time();

  if ($name == "" || $rating == "" || $mid == "") {
    mysql_close($db_connection);
    return;
  }

  $tuples = [];
  $attrs = [];

  //Wrap string values in quotation marks
  $name = "'" . $name . "'";
  $comment = "'" . $comment . "'";

  //Insert new Review tuple
  $query = "INSERT INTO Review VALUES($name, FROM_UNIXTIME($time), $mid, $rating, $comment);";
  issue($query, $db_connection, $tuples, $attrs);
  print "<p>Comment added sucessfully!</p>";

  //Close database connection
  mysql_close($db_connection);
}
?>
