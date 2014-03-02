var w = 768,
    h = 480,
    r = 432,
    x = d3.scale.linear().range([0, r]),
    y = d3.scale.linear().range([0, r]),
    node,
    root;

var pack = d3.layout.pack()
    .size([r, r])
    .value(function(d) { return d.size; })

var vis = d3.select(".bubble-chart-cont").insert("svg:svg", "h2")
    .attr("width", w)
    .attr("height", h)
    //.attr("viewBox", "0 0 " + w + " " + h)
    //.attr("preserveAspectRatio", "xMidYMid")
    .append("svg:g")
    .attr("transform", "translate(" + (w - r) / 2 + "," + (h - r) / 2 + ")");



$.get("http://hackathon.local/api/budgets").done(function(data){
    debugger;
});


function bubbleFullscreen(){
    $("circle.child").show();
    $(".bubble-chart-cont svg").css({
      "margin-left": 0,
      "height": "100vh",
      "width": "100vw",
      "top": 0,
      "left": 0          
    });
    $("header").css({
      "background": "rgba(205,211,213,0.7)",
    });   
 
   $(".bubble-chart-cont").animate({
      "position": "static",
      "top": "0",
      "margin-top": "0",
      "left": "",
      "margin-left": "0"     
    });
   $(".zoom-mode").show();
   $(".normal-mode").hide();
}

function bubbleFullscreenReverse(){
    $("circle.child").hide();
    $(".bubble-chart-cont svg").animate({
      "margin-left": "",
      "top": "",
      "left": ""          
    });

    $("header").css({
      "background": "",
    });  

    $(".bubble-chart-cont").animate({
      "position": "absolute",
      "top": "50%",
      "margin-top": "-240px",
      "left": "50%",
      "margin-left": "-384px"     
    });

   $(".zoom-mode").hide();
   $(".normal-mode").show();
}


d3.json("js/area.json", function(data) {
  node = root = data;

  var nodes = pack.nodes(root);

  vis.selectAll("circle")
      .data(nodes)      
    .enter().append("svg:circle")
      .attr("class", function(d) { return d.children ? "parent" : "child"; })
      .attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; })
      .attr("r", function(d) { return d.r; })
      .attr("dx", function(d) { 
      /* 
        var dx; 
        if(d.children.lenght !== 0){
          if(d.children[0].children[0].children[0] > 10000){ 
            dx = 10;
          } 
        }
        return dx;
      */
      })
      .on("mouseover", function(d){
          var left = parseInt($(this).position().left);
          var top = parseInt($(this).position().top);
          var radius = parseInt($(this).attr("r"));

          left = left + radius;
          $(".tooltip").css({"display": "block", "top": top, "left": left})
      })
      .on("click", function(d) { 

        if(d.name !== "Area"){
          bubbleFullscreen();
        } else {
          bubbleFullscreenReverse();
        }

        return zoom(node == d ? root : d); 
      });

  vis.selectAll("text")
      .data(nodes)
    .enter().append("svg:text")
      .attr("class", function(d) { return d.children ? "parent" : "child"; })
      .attr("x", function(d) { return d.x; })
      .attr("y", function(d) { return d.y; })
      .attr("dy", ".35em")
      .attr("text-anchor", "middle")
      .style("opacity", function(d) { return d.r > 20 ? 1 : 0; })
      .text(function(d) { return d.name; });

  d3.select(window).on("click", function() { 
    zoom(root);         
    bubbleFullscreenReverse();
  });
});

function zoom(d, i) {
  var k = r / d.r / 2;
  x.domain([d.x - d.r, d.x + d.r]);
  y.domain([d.y - d.r, d.y + d.r]);

  var t = vis.transition()
      .duration(d3.event.altKey ? 7500 : 750);

  t.selectAll("circle")
      .attr("cx", function(d) { return x(d.x); })
      .attr("cy", function(d) { return y(d.y); })
      .attr("r", function(d) { return k * d.r; });

  t.selectAll("text")
      .attr("x", function(d) { return x(d.x); })
      .attr("y", function(d) { return y(d.y); })
      .style("opacity", function(d) { return k * d.r > 20 ? 1 : 0; });

  node = d;
  d3.event.stopPropagation();
}

$(document).ready(function(){
 /* var aspect = w / h,
      chart = $(".bubble-chart-cont svg");
  $(window).on("resize", function() {

      var targetWidth = chart.parent().width();
      chart.attr("width", targetWidth);
      chart.attr("height", targetWidth / aspect);
  });
*/
});