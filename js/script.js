var refServFeeder = [];
var servers = [];
$.getJSON( "feeder.json", function( data ) {

  $.each( data, function( key, val ) {
    refServFeeder.push(val[0]);
  });
  console.log(refServFeeder);
});

$.getJSON( "servers.json", function( data ) {
  $.each( data, function( key, val ) {
    servers.push(val);
  });
  var data = generateData();
  var ctx = document.getElementById("userWait").getContext("2d");
  var myNewChart = new Chart(ctx).PolarArea(generateData());
});

function generateData() {
  var data = [];

  var dataraw = dataFeeder();
  for (var info in dataraw) {
    var element = {};
    element['value'] = dataraw[info][1];
    element['color'] = "#F7464A";
    element['highlight'] = "#FF5A5E";
    element['label'] = dataraw[info][2];

    data.push(element);
  }
  return data;
}

function dataFeeder() {
  var liste = count();
  var data = [];
  var info = [];
  for (var serv in liste){
    info.push(serv, liste[serv], findName(serv));
    data.push(info);
    info = [];
  }
  return data;
}

function count() {
  var obj = [];
  for (var i = 0, j = refServFeeder.length; i < j; i++) {
    obj[refServFeeder[i]] = (obj[refServFeeder[i]] || 0) + 1;
  }
  return obj;
}

function findName(ref) {
  var name = "";
  $.each(servers, function(key, value){
    if (ref === value.ref) {
      name = value.name;
    }
  });
  return name;
}
