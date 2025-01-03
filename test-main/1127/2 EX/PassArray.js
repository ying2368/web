//initial
var d1, d2, d3;
var original_color = ["background:rgb(255,255,255)",
    "background:rgb(255,255,255)",
    "background:rgb(255,255,255)"];


function start()
{
    var button = document.getElementById("Button");
    button.addEventListener("click", set, false);
}
    

function set()
{
    d1 = document.getElementById("d1");
    d2 = document.getElementById("d2");
    d3 = document.getElementById("d3");
    var r = Math.floor( 0+Math.random()*256);
    var g = Math.floor( 0+Math.random()*256);
    var b = Math.floor( 0+Math.random()*256);
    var color = "background:rgb("+r+","+g+","+b+")";
    original_color[2] = original_color[1];
    original_color[1] = original_color[0];
    original_color[0] = color;
    d1.setAttribute("style", original_color[0]);
    d2.setAttribute("style", original_color[1]);
    d3.setAttribute("style", original_color[2]);
    
}


window.addEventListener("load", start, false);
