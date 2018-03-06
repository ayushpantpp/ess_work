function getDates( d1, d2 ){
  var oneDay = 24*3600*1000;
  for (var d=[],ms=d1*1,last=d2*1;ms<=last;ms+=oneDay){
    d.push( new Date(ms) );
  }
  return d;
}