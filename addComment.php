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
          <button id="add-btn">Add +</button>
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

      <div id="page-body">

        <form action="addComment.php" method="POST">

          <div style="display: inline-block;">
            <p class="label">Name</p>
            <input name="name" type="text">
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
            <?php include "database.php"; fetchMovies(); ?>
          </select>

          <p class="label">Comment</p>
          <textarea name="comment" cols="66" rows="8"></textarea><br><br>
          <input type="submit" value="Submit">
        </form>

        <?php updateDB(); ?>

      </div>

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

  foreach ($tuples as $tuple)
    print "<option value=$tuple[0]>$tuple[1]</option>";

  //Close database connection
  mysql_close($db_connection);
}

function updateDB()
{
  $db_connection = connect();

  $name = $_POST["name"];
  $rating = $_POST["rating"];
  $mid = $_POST["mid"];
  $comment = $_POST["comment"];
  $time = time();

  if ($name == "")
    print "<p style='color: red;'>Must enter a name!</p>";
  else
  {
    $tuples = [];
    $attrs = [];

    //Wrap string values in quotation marks
    $name = "'" . $name . "'";
    $comment = "'" . $comment . "'";

    //Insert new Review tuple
    $query = "INSERT INTO Review VALUES($name, FROM_UNIXTIME($time), $mid, $rating, $comment);";
    issue($query, $db_connection, $tuples, $attrs);
    print "<p>Comment added sucessfully!</p>";
  }

  //Close database connection
  mysql_close($db_connection);
}
?>
