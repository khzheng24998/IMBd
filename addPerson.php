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
        <form action="addPerson.php" method="POST">

          <p class="label" style="display: inline-block; padding-top: 10px;">Type:</p>
          <input name="type" type="radio" value="Actor" checked> Actor
          <input name="type" type="radio" value="Director"> Director

          <br><p class="label" style="display: inline-block;">First Name:&nbsp;</p>
          <input name="first" type="text">

          <br><p class="label" style="display: inline-block;">Last Name:&nbsp;</p>
          <input name="last" type="text">

          <br><p class="label" style="display: inline-block;">Sex:</p>
          <input name="sex" type="radio" value="Male" checked> Male
          <input name="sex" type="radio" value="Female"> Female

          <br><p class="label" style="display: inline-block;">Date of Birth:&nbsp;</p>
          <input name="dob" type="date">

          <br><p class="label" style="display: inline-block;">Date of Death*:&nbsp;</p>
          <input name="dod" type="date">

          <p>*If person is still alive, leave this field unchanged.</p>
          <br><input type="submit" value="Submit">

        </form>
        <?php updateDB(); ?>
      </div>
    </div>
  </body>
</html>

<?php
function updateDB()
{
  $db_connection = connect();

  $type = $_POST["type"];
  $first = $_POST["first"];
  $last = $_POST["last"];
  $sex = $_POST["sex"];
  $dob = $_POST["dob"];
  $dod = $_POST["dod"];

  if ($first == "" || $last == "" || $dob == "") {
    print "<p style='color: red;'>One or more fields missing!</p>";
    mysql_close($db_connection);
    return;
  }

  $tuples = [];
  $attrs = [];

  ///Get max person id
  $query = "SELECT * FROM MaxPersonID;";
  issue($query, $db_connection, $tuples, $attrs);
  $tuple = $tuples[0];
  $id = $tuple[0];

  //Increment max person id
  $query = "UPDATE MaxPersonID SET id = $id + 1;";
  issue($query, $db_connection, $tuples, $attrs);

  //Wrap string values in quotation marks
  $last = "'" . $last . "'";
  $first = "'" . $first . "'";
  $sex = "'" . $sex . "'";

  //Format date in MySQL format
  $dob = strtotime($dob);

  //Insert new tuple
  if ($type == "Actor") {
    if ($dod == "")
      $query = "INSERT INTO Actor VALUES($id, $last, $first, $sex, FROM_UNIXTIME(0) + INTERVAL $dob SECOND, NULL);";
    else {
      $dod = strtotime($dod);
      $query = "INSERT INTO Actor VALUES($id, $last, $first, $sex, FROM_UNIXTIME(0) + INTERVAL $dob SECOND, FROM_UNIXTIME(0) + INTERVAL $dod SECOND);";
    }
  }
  else {
    if ($dod == "")
      $query = "INSERT INTO Director VALUES($id, $last, $first, FROM_UNIXTIME(0) + INTERVAL $dob SECOND, NULL);";
    else {
      $dod = strtotime($dod);
      $query = "INSERT INTO Director VALUES($id, $last, $first, FROM_UNIXTIME(0) + INTERVAL $dob SECOND, FROM_UNIXTIME(0) + INTERVAL $dod SECOND);";
    }
  }

  issue($query, $db_connection, $tuples, $attrs);
  print "<p>Actor/Director added sucessfully!</p>";

  //Close database connection
  mysql_close($db_connection);
}
?>
