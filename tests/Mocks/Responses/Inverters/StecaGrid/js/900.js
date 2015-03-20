var chartData =
{
"labels":
[
"00:00", "", "", "", "", "",
"01:00", "", "", "", "", "",
"02:00", "", "", "", "", "",
"03:00", "", "", "", "", "",
"04:00", "", "", "", "", "",
"05:00", "", "", "", "", "",
"06:00", "", "", "", "", "",
"07:00", "", "", "", "", "",
"08:00", "", "", "", "", "",
"09:00", "", "", "", "", "",
"10:00", "", "", "", "", "",
"11:00", "", "", "", "", "",
"12:00", "", "", "", "", "",
"13:00", "", "", "", "", "",
"14:00", "", "", "", "", "",
"15:00", "", "", "", "", "",
"16:00", "", "", "", "", "",
"17:00", "", "", "", "", "",
"18:00", "", "", "", "", "",
"19:00", "", "", "", "", "",
"20:00", "", "", "", "", "",
"21:00", "", "", "", "", "",
"22:00", "", "", "", "", "",
"23:00", "", "", "", "", ""
],
"datasets":
[
{
"strokeColor":" rgba(64,178,83,1.0)",
"data": [
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,6,36,84,144,228,192,186,198,126,
306,726,600,900,882,576,774,216,42,66,168,318,102,30,72,
162,108,138,444,498,720,762,552,1110,696,564,666,624,1290,1170,
1242,1836,1482,1020,1032,174,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
0,0,0,0,0,0,0,0,0]
}
]
}
var max = 3250;
var steps = 13;
var input = document.getElementById("inputId");
input.setAttribute("min",   "2015-01-22");
input.setAttribute("max",   "2015-02-21");
input.setAttribute("value", "2015-02-21");
document.getElementById("labelValueId").innerHTML = "   900kWh 21.02.2015";
document.getElementById("buttonPrevId").disabled  = false;
document.getElementById("buttonNextId").disabled  = true;
var myLine = new Chart(document.getElementById("canvasId")
.getContext("2d"))
.Line(chartData,
{
"pointDot": false,
"datasetFill": false,
"scaleOverride": true,
"scaleLabel": "<%=value%> W",
"scaleSteps": steps,
"scaleStartValue": 0,
"scaleStepWidth": Math.ceil(max / steps),
"scaleLineColor":" rgba(170,170,170,1.0)",
"scaleFontColor":" rgba(170,170,170,1.0)",
"scaleGridLineColor":" rgba(68,68,68,1.0)"});

