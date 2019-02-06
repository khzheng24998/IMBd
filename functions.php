<?php
header("Content-type: text/javascript");
?>

function returnToHome() {
  window.location.href = "home.php";
}

$(document).ready(function()
{
  $("#add-btn").on("click", function() {
    $("#dropdown").toggle();
  });

  $(".dropdown-option").on("click", function(event) {
    window.location.href = event.target.id + ".php";
  });

  $(".dropdown-option").hover(function() {
    $(this).css("background-color", "#0366d6");
    $(this).css("color", "white");
  },
  function() {
    $(this).css("background-color", "white");
    $(this).css("color", "black");
  });
});
