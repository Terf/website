<?php
error_reporting(-1);
ini_set('display_errors', 'On');
if (isset($_POST['submit'])) {
  $to = 'tim.terf@gmail.com';
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $headers = 'From: trobertf@oberlin.edu' . "\r\n" .
      'Reply-To: trobertf@oberlin.edu' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);
  $form_submitted = true;
}
else {
  $form_submitted = false;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Tim Robert-Fitzgerald is a computer science major at Oberlin College">
    <meta name="author" content="Tim Robert-Fitzgerald">
    <title>Tim Robert-Fitzgerald</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">
    <!-- Open Graph data -->
    <meta property="og:title" content="Tim Robert-Fitzgerald" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Tim Robert-Fitzgerald"/>
    <meta property="og:description" content="Tim Robert-Fitzgerald is a computer science major at Oberlin College" />
  </head>
  <body>
    <svg id="svg" xmlns="http://www.w3.org/2000/svg"></svg>
    <!-- See http://jsfiddle.net/rsadwick/zwWHY/ for card source -->
    <?php
    if ($form_submitted) {
      echo "<div class='alert'><b>Success!</b> Your message has been sent</div>";
    }
    ?>
    <div class="flip"> 
      <div class="card" id="card">
        <div class="face front">
          <img src="images/pic.jpg" alt="">
          <h1>Tim Robert-Fitzgerald</h1>
          <p style="padding: 10px">I'm a computer science major at Oberlin College. I work as a fellow for <a href="https://github.com/EnvironmentalDashboard">Environmental Dashboard</a>, mostly building web/iOS applications for visualizing resource consumption. You can find my work on <a href="https://github.com/Terf">GitHub</a> and <a href="http://codepen.io/terf/">CodePen</a>. The background of this website is <a href="https://en.wikipedia.org/wiki/Conway's_Game_of_Life">Conway's game of life</a>.</p>
          <div class="spacer"></div>
          <p style="text-align: center;"><a href="#" onclick="flip()" class="btn">Contact me</a></p>
        </div> 
        <div class="face back">
          <h1>Contact me</h1>
          <form action="" method="POST">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject">
            <label for="message">Message</label>
            <textarea name="message" id="message"></textarea>
            <div class="spacer"></div>
            <div class="spacer"></div>
            <p style="text-align: center"><a href="#" onclick="unflip()" class="btn">Back</a> <input style="height: 40px;" type="submit" name="submit" value="Send message" class="btn"></p>
          </form>
        </div> 
      </div> 
    </div>
    <script>
      function flip() { document.getElementById('card').className = 'card flipped'; }
      function unflip() { document.getElementById('card').className = 'card'; }
      function makeSVG(tag, attrs) { // http://stackoverflow.com/a/3642265
        var el = document.createElementNS('http://www.w3.org/2000/svg', tag);
        for (var k in attrs) {
          el.setAttribute(k, attrs[k]);
        }
        return el;
      }
      var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
      var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
      var svg = document.getElementById('svg');
      svg.setAttribute('width', w + 'px');
      svg.setAttribute('height', h + 'px');
      var x = 0, y = 0, i = 0;
      var num_columns = Math.ceil(w/10);
      var num_rows = Math.ceil(h/10)*10;
      var alive = '#c0392b';//'#16a085';
      var dead = '#e74c3c';//'#1abc9c';
      while (true) {
        var fill = (Math.random() > 0.5) ? alive : dead;
        var rect = makeSVG('rect', {x: x, y: y, width: '10px', height: '10px', fill: fill, id: 'row'+(y/10)+'col'+(x/10), border: 'none'});
        document.getElementById('svg').appendChild(rect);
        x += 10;
        i++;
        if (i === num_columns) { // next row
          y += 10;
          x = 0, i = 0;
        }
        if (y === num_rows) {
          break;
        }
      }
      setInterval(function(){
        var to_kill = [];
        var to_revive = [];
        for (var row = 0; row < num_rows/10; row++) {
          for (var col = 0; col < num_columns; col++) {
            var alive_neighbours = 0;
            var c1 = document.getElementById('row'+(row-1)+'col'+(col-1));
            var c2 = document.getElementById('row'+(row-1)+'col'+(col));
            var c3 = document.getElementById('row'+(row-1)+'col'+(col+1));
            var c4 = document.getElementById('row'+(row)+'col'+(col-1));
            var c5 = document.getElementById('row'+(row)+'col'+(col+1));
            var c6 = document.getElementById('row'+(row+1)+'col'+(col-1));
            var c7 = document.getElementById('row'+(row+1)+'col'+(col));
            var c8 = document.getElementById('row'+(row+1)+'col'+(col+1));
            if (c1 != null && c1.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c2 != null && c2.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c3 != null && c3.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c4 != null && c4.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c5 != null && c5.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c6 != null && c6.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c7 != null && c7.getAttribute('fill') === alive) {alive_neighbours++;}
            if (c8 != null && c8.getAttribute('fill') === alive) {alive_neighbours++;}
            // console.log(document.getElementById('row'+(row)+'col'+(col)), alive_neighbours);
            var curr_cell = document.getElementById('row'+(row)+'col'+(col));
            if (curr_cell.getAttribute('fill') === alive) {
              if (alive_neighbours < 2 || alive_neighbours > 3) {
                to_kill.push(curr_cell);
              }
            }
            else {
              if (alive_neighbours === 3) {
                to_revive.push(curr_cell);
              }
            }
            alive_neighbours = 0;
          }
        }
        while (to_kill.length > 0) {
          var pop = to_kill.pop();
          pop.setAttribute('fill', dead);
        }
        while (to_revive.length > 0) {
          var pop = to_revive.pop();
          pop.setAttribute('fill', alive);
        }
      }, 500);
    </script>
  </body>
</html>