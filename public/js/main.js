var w = $(window).width(),
    h = $(window).height(),
    r = parseInt($(window).height())-50,
    x = d3.scale.linear().range([0, r]),
    y = d3.scale.linear().range([0, r]),
    node,
    root;

var clicked = false;

var pack = d3.layout.pack()
    .size([r, r])
    .value(function(d) { 
      if (typeof d.size === 'undefined') {
        return;
      } else {
        return d.size;
      }
    })

var vis = d3.select(".bubble-chart-cont").insert("svg:svg", "h2")
    .attr("width", w)
    .attr("height", h)
    //.attr("viewBox", "0 0 " + w + " " + h)
    //.attr("preserveAspectRatio", "xMidYMid")
    .append("svg:g")
    .attr("transform", "translate(" + (w - r) / 2 + "," + (h - r) / 2 + ")");





function bubbleFullscreen(){
  //$("text").show();/*
  $("circle.child").show();
  $(".zoom-mode").show();
  $(".normal-mode").hide();

/*    
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
*/
}

function bubbleFullscreenReverse(){
  $("text").hide();
  $("circle.child").hide();

  $("circle.parent").attr("opacity","1");
  $(".zoom-mode").hide();
  $(".normal-mode").show();
  /*
    
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

   */
}


d3.json("/api/budgets/d3", function(data) {
  //console.log(data);
  budget = data.response.contents[0].budget;
  console.log(budget);
  node = root = budget;

  var nodes = pack.nodes(root);


  vis.selectAll("circle")
      .data(nodes)      
    .enter().append("svg:circle")
      .attr("class", function(d) { return d.children ? "parent" : "child"; })
      .attr("cx", function(d) { return d.x})
      .attr("cy", function(d) { return d.y})
      .attr("r", function(d) { return d.r})
      .attr("fill", function(d) {
        var delta = d.delta;
        var radius = $("this").attr("r");
        var windowHeight = $(window).height() / 2.25;
          if(delta > 0 && delta <= 5){
            $(this).css({"fill":"#46b29a", "stroke":"#308270"});
            $(this).attr("cy", windowHeight - d.y*0.35);
            $(this).attr("cx", d.x*0.35);
          } else if(delta > 5 && delta <= 15){
            $(this).css({"fill":"#3a9d88", "stroke":"#236456"});
            $(this).attr("cy", windowHeight - d.y*0.55);
            $(this).attr("cx", windowHeight + d.x*0.55);
          } else if(delta > 15){
            $(this).css({"fill":"#1b7e69", "stroke":"#257160"});
            $(this).attr("cy", windowHeight - d.y*0.25);
            $(this).attr("cx", windowHeight + d.x*0.25);
          } else if(delta < 0 && delta >= -5){
            $(this).css({"fill":"#eb6759", "stroke":"#dc594b"});
            $(this).attr("cy", windowHeight + d.y*0.65);
            $(this).attr("cx", windowHeight - d.x/2.05);
          } else if(delta < 5 && delta >= -15){
            $(this).css({"fill":"#e74c33", "stroke":"#ca422c"});
            $(this).attr("cy", windowHeight + d.y*0.75);
            $(this).attr("cx", windowHeight + d.x/10.55);
          } else if(delta < 15){
            $(this).css({"fill":"#c53b26", "stroke":"#ad301d"});
            $(this).attr("cy", windowHeight + d.y*0.95);
            $(this).attr("cx", windowHeight + d.x/2.75); 
          } else if(delta === 0){
            $(this).css({"fill":"#9cb3c2", "stroke":"#849cab"});            
          } 
          if(d.name === "Public Debt"){
            //  debugger;
            $(this).attr("class","child special-show");
          }
          return 

        }
      )
      .on("mouseover", function(d){
          var left = parseInt($(this).position().left);
          var top = parseInt($(this).position().top);
          var radius = parseInt($(this).attr("r"));
          var colour = $(this).css("fill");
          var bottomOffset = $(window).height() - (radius * 2);
          var value = d.value / 100000;

          left = left + radius;
          $(".tooltip > label > span").text(d.name);
          $(".value > span:first-child").text(value.toFixed(2));
          $(".tooltip .percent-change").text(parseFloat(d.delta.toFixed(2)) + "%");
          $(".tooltip .percent-change").css("color",colour);



          if(top < 100){
            if(bottomOffset < 100) {
             $(".tooltip").removeClass("overflow-top");                       
            } else {
             $(".tooltip").addClass("overflow-top");           
            }
             $(".tooltip").css({"display": "block", "top": top + (radius*2), "left": left});              
          } else {
             $(".tooltip").removeClass("overflow-top");                       
             $(".tooltip").css({"display": "block", "top": top, "left": left});
          }


      })
      .on("click", function(d) { 
        if(d.name !== "Budget" || clicked != true){
          $(this).attr("opacity","0.5");
          var value = d.value/10000;
          var change = d.delta;
          var dchar;

          if (change >= 0) {
            dchar = "+";
          } else {
            dchar = "";
          }

          $(".zoom-mode h3").text(d.name);
          $(".zoom-mode h2 span").text(value.toFixed(3));
          $(".zoom-mode .change-info").text(dchar + change.toFixed(3));


          bubbleFullscreen();
          clicked = true;
        } else {
          bubbleFullscreenReverse();
          $(this).attr("opacity","1");
          clicked = false;
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