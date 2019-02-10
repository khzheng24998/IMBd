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

#footer {
  height: 75px;
  background-color: black;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

#center-col {
  width: 70%;
  background-color: white;
  z-index: 2;
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
  cursor: pointer;
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

#page-body {
  padding: 5px 30px 15px 30px;
  min-height: 90vh;
}

#dropdown {
  width: 150px;
  background-color: white;
  border: 1px solid black;
  position: absolute;
  z-index: 1;
  padding: 5px 1px 5px 1px;
  display: none;
}

.dropdown-option {
  font-size: 15px;
  margin: 0px;
  padding: 5px 10px 5px 10px;
  cursor: pointer;
}

.label {
  font-weight: 550;
  margin: 12px 0px 8px 0px;
}

#add-btn {
  width: 58px;
  margin-left: 95px;
}

#add-title {
  background-color: #cccccc;
  border: 1px solid black;
  width: 250px;
  margin-top: 15px;
  padding: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}
