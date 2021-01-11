$(document).ready(function () {

    $('.dataTable').dataTable();

});


function ActiveLeftSideMenuOnLoad(menuClass, submenuNumber){
  if(submenuNumber > 0){

  	var ddlMenu = $.trim(menuClass + " .sub_ddl_"+submenuNumber+" a");

    $($.trim(menuClass+", " +ddlMenu )).addClass('active');
    $($.trim(menuClass+" .nav_trigger")).removeClass('collapsed');
    $($.trim(menuClass+" .nav_trigger")).attr('aria-expanded', 'true');
    $($.trim(menuClass+" .sub_nav")).addClass('show');
  }else{

  	$($.trim(menuClass)).addClass('active');
  }

}