var dibujo = document.getElementById('rectas_tangentes');
var lienzo = dibujo.getContext("2d");
var long = dibujo.width;
var lineas = 170;
var recorridoEje = long/lineas;

lienzo.strokeStyle = "gray";
lienzo.strokeRect(0,0,long,long);


for (let i = 0; i < lineas; i++) {
    ys = recorridoEje*i;
    xf = recorridoEje*(i+1);
    y4s = long-ys;
    x2f = long-xf;
    dibujarLinea(0,ys,xf,long,"red");  
    dibujarLinea(500,x2f,ys,500,"blue");
    dibujarLinea(ys,0,long,xf,"green");
    dibujarLinea(0,y4s,xf,0,"yellow");
    console.log("i: "+i,"| ys: "+ys,"| xf: "+xf,"| y4s: "+y4s,"| x2f: "+x2f);
}

lienzo.beginPath();
lienzo.strokeStyle = "violet";
lienzo.lineWidth = 10;
lienzo.arc(250, 250, 170, 0, 2 * Math.PI);
lienzo.stroke();
lienzo.closePath();

function dibujarLinea(xstart,ystart,xfinal,yfinal,color){
    lienzo.beginPath();
    lienzo.strokeStyle = color;
    lienzo.moveTo(xstart,ystart);
    lienzo.lineTo(xfinal,yfinal);
    lienzo.stroke();
    lienzo.closePath();
}
