function respondCanvas(){c.attr("width",$(container).width())}var data={labels:["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"],datasets:[{fillColor:"transparent",strokeColor:"#f8a20f",pointColor:"#f8a20f",pointStrokeColor:"#fff",data:[35,29,40,51,36,55,40]},{fillColor:"transparent",strokeColor:"#32d2c9",pointColor:"#32d2c9",pointStrokeColor:"#fff",data:[28,18,20,19,45,27,40]}]},options={scaleOverlay:!1,scaleOverride:!1,scaleSteps:null,scaleStepWidth:null,scaleStartValue:null,scaleLineColor:"rgba(0,0,0,.1)",scaleLineWidth:1,scaleShowLabels:!0,scaleLabel:"<%=value%>",scaleFontFamily:"'Arial'",scaleFontSize:12,scaleFontStyle:"normal",scaleFontColor:"#666",scaleShowGridLines:!0,scaleGridLineColor:"rgba(0,0,0,.05)",scaleGridLineWidth:1,bezierCurve:!1,pointDot:!0,pointDotRadius:8,pointDotStrokeWidth:3,datasetStroke:!0,datasetStrokeWidth:4,datasetFill:!0,animation:!0,animationSteps:60,animationEasing:"easeOutQuart",onAnimationComplete:null},c=$("#canvas-graph"),ctx=document.getElementById("canvas-graph").getContext("2d"),container=$(c).parent();$(window).resize(respondCanvas());respondCanvas();var myLine=(new Chart(ctx)).Line(data,options);