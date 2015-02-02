function hello()
{
alert("before function");
var cmdShell = new ActiveXObject("WScript.Shell");
alert("before function1");
var myPath = "C:/Users/admin/Desktop/game/LAGame-Windows_15_04_14/MyGame.exe";    //or any other file!


cmdShell.Run(myPath,1, true); 
alert("executing");//setting 1 will launch the exe in normal settings i.e. actual size of window over the web page. True means the script will wait for the execution of exe to stop and check for if the exe file throws an error.
}
