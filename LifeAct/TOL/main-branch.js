var startTime;
var endTime =1000;

function setup(){
var branch_canvas = createCanvas(displayWidth,displayHeight);
branch_canvas.parent("branch");
startTime=millis();
}


function draw(){
  draw_line(width/2,0,width/2,displayHeight);//Kormos
  draw_line(displayWidth/2,displayHeight/4,displayWidth/4,displayHeight/4);  //first left branch
  draw_line(displayWidth/2,displayHeight/4,3*displayWidth/4,displayHeight/4);  //second right branch
  draw_line(displayWidth/2,mouseY,3*displayWidth/4,mouseY)

}
function draw_line(start_width,start_height,end_width,end_height){

  var total = (float)(millis()-startTime)/endTime;

  if(total < 1 ){
    strokeWeight(5);
    stroke(175, 97, 8);
    var kormos= line(start_width, start_height,
      (int)( (1-total)*start_width + total*end_width ),
      (int)( (1-total)*start_height + total*end_height ) );
  }
  else{
    startTime = millis();
  }

}
