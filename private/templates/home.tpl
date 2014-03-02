<!DOCTYPE html>
<html class="{{html_classes}}">
  <head>
    <title>Interactive Budget Canada</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

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
        <span title="coming soon">Spending Types<span class="tooltip-header">coming soon<span></span></span></span>
        <span title="coming soon">Composition<span class="tooltip-header">coming soon<span></span></span></span>
        <span title="coming soon">Changes<span class="tooltip-header">coming soon<span></span></span></span>
        <span title="coming soon">Federal Income<span class="tooltip-header">coming soon<span></span></span></span>

      </nav>
      <div class="share-cont">
          <label>Share knowledge</label>
          <div>
              <div class="linkedin"></div>
              <div class="twitter"></div>
              <div class="facebook"></div>
          </div>
      </div>
    </header>
    <div class="information-box-cont zoom-mode">
      <h2>$<span>1.18</span> Billion<span class="change-info">+8.4%</span></h2>
      <h3>Department of Transportation</h3>
      <div class="zoom-out"><span>-</span><span>Zoom out</span></div>
    </div>
    <div class="information-box-cont normal-mode">
      <h2>How $260 Billion was spent in 2013</h2>
      <p>Discover how the Fedearl Government of Canada spends and changes its spending as a part of the annual budget.</p>
      
      <label>Circle size represents spending subtotals</label>
      <div class="scale-info-circl-big">
        <label>$2.5 Billion</label>
        <label>$0.5 Billion</label>
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
        <label><span>Transportation Services</span><label>
        <div class="value">$<span>1.8</span> billion</div>
        <div class="percent-change">0.8%</div>
      </div>
    </div>
    <div class="public-debt-bubble">
        <div>$30 billion in public debt servicing</div>
    </div>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="/js/main.js" type="text/javascript">
    </script>

    <footer>Interactive budget was created by, <a href="https://bigterminal.com">Adam Rabie</a>, <a href="https://twitter.com/WiseBeard">Brian Pullen</a> and <a href="http://johnbaker.ca/">John Baker</a> for CODE. Special thanks to D3 for charts and The New York Times for insperation.</footer>
  </body>
</html>