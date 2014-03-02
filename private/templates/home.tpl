<!DOCTYPE html>
<html class="{{html_classes}}">
  <head>
    <title>Interactive Budget Canada</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no">

    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
  </head>

  <body>
    <header>
      <div class="logo-cont">
        <span class="canadian-flag"></span>
        <span class="main-title">Interactive Budget</span>
      </div>
      <nav>
        <span class="selected">All Spending</span>
        <span>Spending Types</span>
        <span>Composition</span>
        <span>Changes</span>
        <span>Federal Income</span>

      </nav>
    </header>
    <div class="information-box-cont zoom-mode">
      <h2>$1.18 Billion<span class="change-info">+8.4%</span></h2>
      <h3>Department of Transportation</h3>
    </div>
    <div class="information-box-cont normal-mode">
      <h2>How $260 Billion was spent in 2013</h2>
      <p>Duis rhoncus nibh at quam blandit euismod. Donec ornare dui vitae magna euismod, vitae venenatis nisl pretium. Etiam iaculis fringilla mauris, et tristique tortor gravida eu</p>
      
      <label>Circle size represents spending</label>
      <div class="scale-info-circl-big">
        <label>$10 Billion</label>
        <label>$1 Billion</label>
        <div class="scale-info-circl-small"></div>
      </div>

     <label>Colour shows difference from 2012-2013</label>
      <div class="gradient-info-cont">
        <span>-25%</span>        
        <span>-15%</span>        
        <span>-5%</span>        
        <span>0%</span>        
        <span>+5%</span>        
        <span>+15%</span>        
        <span>+25%</span>        
      </div>

    </div>
    <div class="bubble-chart-cont">
      <div class="tooltip"><span></span>
        <label>Transportation Services<label>
        <div class="value">$1.8 billion</div>
        <div class="percent-change">0.8%</div>
      </div>
    </div>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="/js/main.js" type="text/javascript">
    </script>

    <footer>Interactive budget was created by, <a href="https://bigterminal.com">Adam Rabie</a>, <a href="https://twitter.com/WiseBeard">Brian Pullen</a> and <a href="http://johnbaker.ca/">John Baker</a> for CODE. Special thanks to D3 for charts and The New York Times for insperation.<
    /footer>
  </body>
</html>