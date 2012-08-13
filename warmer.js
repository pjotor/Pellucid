$.post("engine.php",{action:'save', type:'game', name: 'G1', tags:'test', 'attrib[type]':['cost'], 'attrib[value]': ['450SEK']}, function(resp){ 
  console.log(resp); 
  console.log("game done!");
  $.post("engine.php",{action:'save', type:'player', name: 'P1', game:1, tags:'tester', 'attrib[type]':['position'], 'attrib[value]': ['coder']}, function(resp){ 
    console.log(resp); 
    console.log("player done!");
    $.post("engine.php",{action:'save', type:'character', name: 'C1', game:1, players:[1], tags:'red', 'attrib[type]':['class'], 'attrib[value]': ['druid']}, function(resp){ 
      console.log(resp);
      console.log("cahracter done!");
      $.post("engine.php",{action:'save', type:'characterGroup', name: 'Knights', game:1, characters:[1], tags:'new', 'attrib[type]':['alignement'], 'attrib[value]': ['good']}, function(resp){ 
        console.log(resp); 
        console.log("charGroup done!");
        $.post("engine.php",{action:'save', type:'playerGroup', name: 'Noobs', game:1, players:[1], tags:'new', 'attrib[type]':['funkis'], 'attrib[value]': ['dagtid']}, function(resp){ 
          console.log(resp);
          console.log("playerGroup done!");
          $.post("engine.php",{action:'save', type:'plot', name: 'P1', game:1, characters:[1], tags:'single', 'attrib[type]':['type'], 'attrib[value]': ['crawl']}, function(resp){ 
            console.log(resp);
            console.log("singel plot done!");
            $.post("engine.php",{action:'save', type:'plot', name: 'P2', game:1, characterGroup:[1], tags:'group', 'attrib[type]':['type'], 'attrib[value]': ['crawl']}, function(resp){ 
              console.log(resp);
              console.log("group plot done!");
              console.log("all done!");
            });
          });
        });
      });
    });
  });
});