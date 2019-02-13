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
          <h3 style="margin: 0px;">Add a movie</h3>
        </div>
        <form action="addMovie.php" method="GET">

          <div style="display: flex;">

            <div style="flex: 25%;">
              <p class="label">Title</p>
              <input name="title" type="text" required>

              <p class="label">Company</p>
              <input name="company" type="text" required>
            </div>

            <div style="flex: 75%;">
              <p class="label">Year</p>
              <input name="year" type="text" size="4" required>

              <p class="label">MPAA Rating</p>
              <select name="rating">
                <option value="G">G</option>
                <option value="PG">PG</option>
                <option value="PG-13">PG-13</option>
                <option value="R">R</option>
              </select>
            </div>

          </div>

          <div>
            <p class="label">Genre(s)</p>

            <input type="radio" name="genre1" value="Action"><p class="genre-option">&nbsp;Action</p>
            <input type="radio" name="genre2" value="Adult"><p class="genre-option">&nbsp;Adult</p>
            <input type="radio" name="genre3" value="Adventure"><p class="genre-option">&nbsp;Adventure</p>
            <input type="radio" name="genre4" value="Animation"><p class="genre-option">&nbsp;Animation</p>
            <input type="radio" name="genre5" value="Comedy"><p class="genre-option">&nbsp;Comedy</p><br>

            <input type="radio" name="genre6" value="Crime"><p class="genre-option">&nbsp;Crime</p>
            <input type="radio" name="genre7" value="Documentary"><p class="genre-option">&nbsp;Documentary</p>
            <input type="radio" name="genre8" value="Drama"><p class="genre-option">&nbsp;Drama</p>
            <input type="radio" name="genre9" value="Family"><p class="genre-option">&nbsp;Family</p>
            <input type="radio" name="genre10" value="Fantasy"><p class="genre-option">&nbsp;Fantasy</p><br>

            <input type="radio" name="genre11" value="Horror"><p class="genre-option">&nbsp;Horror</p>
            <input type="radio" name="genre12" value="Musical"><p class="genre-option">&nbsp;Musical</p>
            <input type="radio" name="genre13" value="Mystery"><p class="genre-option">&nbsp;Mystery</p>
            <input type="radio" name="genre14" value="Romance"><p class="genre-option">&nbsp;Romance</p>
            <input type="radio" name="genre15" value="Sci-Fi"><p class="genre-option">&nbsp;Sci-Fi</p><br>

            <input type="radio" name="genre16" value="Short"><p class="genre-option">&nbsp;Short</p>
            <input type="radio" name="genre17" value="Thriller"><p class="genre-option">&nbsp;Thriller</p>
            <input type="radio" name="genre18" value="War"><p class="genre-option">&nbsp;War</p>
            <input type="radio" name="genre19" value="Western"><p class="genre-option">&nbsp;Western</p>
          </div>

          <br><br><input type="submit" value="Submit">

        </form>
        <?php updateDB(); ?>
      </div>
      <?php printFooter(); ?>
    </div>
  </body>
</html>

<?php
function updateDB()
{
  $db_connection = connect();

  $title = $_GET["title"];
  $year = $_GET["year"];
  $rating = $_GET["rating"];
  $company = $_GET["company"];

  if ($title == "" || $year == "" || $rating == "" || $company == "") {
    mysql_close($db_connection);
    return;
  }

  $tuples = [];
  $attrs = [];

  //Get max movie id
  $query = "SELECT * FROM MaxMovieID;";
  issue($query, $db_connection, $tuples, $attrs);
  $tuple = $tuples[0];
  $id = $tuple[0];

  //Increment max movie id
  $query = "UPDATE MaxMovieID SET id = $id + 1;";
  issue($query, $db_connection, $tuples, $attrs);

  //Wrap string values in quotation marks
  $title = "'" . $title . "'";
  $rating = "'" . $rating . "'";
  $company = "'" . $company . "'";

  //Insert new Movie tuple
  $query = "INSERT INTO Movie VALUES($id, $title, $year, $rating, $company);";
  issue($query, $db_connection, $tuples, $attrs);
  print "<p>Movie added sucessfully!</p>";

  //Retreive all selected genres
  $genres = [];
  for ($i = 1; $i <= 19; $i++) {
    $genre = $_GET["genre" . $i];
    if ($genre != "")
      array_push($genres, $genre);
  }

  //Insert new MovieGenre tuples
  foreach ($genres as $genre) {
    $genre = "'" . $genre . "'";
    $query = "INSERT INTO MovieGenre VALUES($id, $genre);";
    issue($query, $db_connection, $tuples, $attrs);
  }

  //Close database connection
  mysql_close($db_connection);
}
?>
