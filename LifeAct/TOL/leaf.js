var startTime;
var endTime =1000;
var i=1,number_of_leaves=0;
var leaves = [];
var coordinates_of_leaf=[];
var get_leaf = false;

function setup(){
  var branch_canvas = createCanvas(windowWidth,windowHeight);
  branch_canvas.parent('branch');
  startTime=millis();
}
function draw(){
    draw_line(windowWidth/2,0,windowWidth/2,windowHeight);//Kormos
    draw_line(windowWidth/2,windowHeight/4,windowWidth/4,windowHeight/4);  //first left branch
    get_leaf=true;
    draw_line(windowWidth/4,windowHeight/4,windowWidth/4,windowHeight/5);  //left leaf branch
    draw_leaf();
    draw_line(windowWidth/2,windowHeight/4,3*windowWidth/4,windowHeight/4);  //second right branch
    get_leaf=true;
    draw_line(3*windowWidth/4,windowHeight/4,3*windowWidth/4,windowHeight/5);  //right leaf branch
    draw_leaf();
}
function draw_line(start_width,start_height,end_width,end_height){
  strokeCap(SQUARE);
  var total = (float)(millis()-startTime)/endTime;

  if(total < 1 ){
    strokeWeight(5);
    strokeCap(PROJECT);
    stroke(175, 97, 8);
    var kormos= line(start_width, start_height,
      (int)( (1-total)*start_width + total*end_width ),
      (int)( (1-total)*start_height + total*end_height ) );
  }
  else{
    noLoop();
    startTime = millis();
  }
  if(get_leaf){
    number_of_leaves++;
    console.log(number_of_leaves);
    coordinates_of_leaf=[end_width,end_height];
    get_leaf=false;
  }
}
function draw_leaf(){
  var o;
  if(i<3){                                          // To '3' edw tha einai to input pou tha dwsei o xristis . diladi : i<input
      for(o = 0; o < number_of_leaves; o++ ){
        leaves[o] = createGraphics(141,120);
        console.log(leaves[0],coordinates_of_leaf);
        put_leaf(leaves[o],coordinates_of_leaf);
      }
  }
}
function put_leaf(leaf,coordinates_of_leaf){
  push();
  //leaf.style('transform', 'scale(0.3)');
  leaf.style('display', 'block');
  leaf.class('leaf');
  leaf.position(coordinates_of_leaf[0]-leaf.width/2,coordinates_of_leaf[1]-leaf.height/2);
  leaf.background(0,0,0,0);
  leaf.scale(0.2,0.2);
  leaf.angleMode(RADIANS);
  leaf.translate(0,windowHeight/2);
  leaf.rotate(-0.7);
  leaf.fill(0,255,0);
      leaf.curve(-150,600,     //beginning control poiont
                50,100,         //1st point
                350,350,       //2nd point
                -2000,700);    //ending control point
        leaf.curve(-200,300,     //beginning control poiont
              350,350,           //1st point
              50,100,            //2nd point
              -700,350);         //ending control point
        leaf.curve(1500,600,     //beginning control poiont
              350,350,           //1st point
              50,100,            //2nd point
              -300,-200);        //ending control point
              i++;
              pop();
}
