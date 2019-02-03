<?php
header("Content-type: text/css");
$font_family = 'Arial, Helvetica, sans-serif';
?>

body {
  font-family: <?=$font_family?>;
  padding: 0px;
  margin: 0px;
  background-color: #cccccc;
  display: flex;
  justify-content: center;
  z-index: 1;
}

#navbar {
  height: 75px;
  background-color: black;
  display: flex;
  align-items: center;
}

#center-col {
  width: 80%;
  background-color: white;
  z-index: 2;
}

#search {
  margin-right: 25px;
  margin-left: auto;
}
