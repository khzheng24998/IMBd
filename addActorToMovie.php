<html>
  <head>
    <link rel="stylesheet" href="style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="client.php"></script>
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
            <p id="addDirectorToMovie" class="dropdown-option">Add director to movie</p>
          </div>
        </div>

        <div id="search" style="display: inline-block; padding: 0px 0px 0px 10px;">
          <form action="search.php" method="GET" style="margin: 0px;">
            <input name="keyword" type="text"><input type="submit" value="Search">
          </form>
        </div>

      </div>

      <div id="page-body">

        <form action="addActorToMovie.php" method="POST">

        </form>

        <?php include "server.php"; updateDB(); ?>

      </div>

    </div>
  </body>
</html>

<?php

?>
