function splitButtonPressed()
{
   var inputString = document.getElementById( "inputField" ).value;
   var tokens = inputString.split( " " );
 
   var results = document.getElementById( "results" );
   results.innerHTML = "<p>The sentence split into words is: </p>" +
      "<p class = 'indent'>" +
      tokens.join( "</p><p class = 'indent'>" ) + "</p>" +
      "<p>The first 10 characters of the input string are: </p>" +
      "<p class = 'indent'>'" + inputString.substring( 0, 10 ) + "'</p>";
}
function start()
{
   var splitButton = document.getElementById( "splitButton" );
   splitButton.addEventListener( "click", splitButtonPressed, false );
}
window.addEventListener( "load", start, false );
