jQuery(function ($) {
  function responsiveSidebar(){
    if($(window).width() < 769){
      $("body").removeClass("toggled");
    }else{
      if(!$("body").hasClass('toggled')){
        $("body").addClass("toggled");
      }
    }
  }

  responsiveSidebar()
  
  $(window).on("resize", function(){
    responsiveSidebar()
  })

  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("active")
  ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});

$("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
  $(".page-wrapper").addClass("toggled");
});
});

$(function () {
  $('.input-daterange').datepicker({
    autoclose: true,
    format: "mm/dd/yyyy",
    clearBtn: true
  }).on('changeDate', function(e) {
    getRange()
});;
});

const startDate = document.getElementById('start_date');
const endDate = document.getElementById('end_date');

function getRange(){
  var start_date = new Date(startDate.value);
  var end_date = new Date(endDate.value);

  var diff = ((end_date.getTime() - start_date.getTime()) / (1000 * 3600 * 24)) + 1
  if(diff > 0){
    console.log(diff);
    document.getElementById('lama').value = diff;

  }
}
