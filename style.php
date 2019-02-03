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
  min-height: 100vh;
}

#logo {
  display: flex;
  background-color: #f3ce00;
  height: 40px;
  width: 75px;
  margin-left: 25px;
  border-radius: 3px;
  align-items: center;
  justify-content: center;
}

#logo-text {
  font-weight: 1000;
  font-size: 22px;
}

#search {
  margin-right: 25px;
}

#add {
  margin-right: 10px;
  margin-left: auto;
}
