$(document).ready(function(){
    $("#count_click").click(function()
    {
        count_click_add();
    });
    $("#habilitar").click(function()
    {
        habilitar();
        count_click = 0;
    });
});

var count_click = 0;

function deshabilitar(){
    document.getElementById('count_click').disabled=true;
}
function habilitar(){
    document.getElementById('count_click').disabled=false;
}
function count_click_add(){
   count_click += 1;
   console.log(count_click);
   if(count_click==2){
     deshabilitar();
   }
}
//////////////LLAMADA POR MEDIO DE NAME Y NO ID ////////
  /*$("button[name='count_click']").click(function(){
     count_click_add();
  });*/
////////////////////////////////////////////////////////