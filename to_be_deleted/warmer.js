$.post("engine.php",{type:'game', name: 'G1', tags:'test', 'attrib[type]':['cost'], 'attrib[value]': ['450SEK']}, function(resp){ 
  var game = resp.stored; 
  console.log("game done!");
  $.post("engine.php",{type:'player', name: 'P1', game:game, tags:'tester', 'attrib[type]':['position'], 'attrib[value]': ['coder']}, function(resp){ 
    var player = resp.stored;
    console.log("player done!");
    $.post("engine.php",{type:'character', name: 'C1', game:game, players:[player], tags:'red', 'attrib[type]':['class'], 'attrib[value]': ['druid']}, function(resp){ 
      var char1 = resp.stored;
      console.log("cahracter 1 done!");
    $.post("engine.php",{type:'character', name: 'C2', game:game, players:[player], tags:'green', 'attrib[type]':['class'], 'attrib[value]': ['knight']}, function(resp){ 
      var char2 = resp.stored;
      console.log("cahracter 2 done!");      
      $.post("engine.php",{type:'characterGroup', name: 'Knights', game:game, characters:[char1,char2], tags:'new', 'attrib[type]':['alignement'], 'attrib[value]': ['good']}, function(resp){ 
        var char_group = resp.stored;
        console.log("charGroup done!");
        $.post("engine.php",{type:'playerGroup', name: 'Noobs', game:game, players:[player], tags:'new', 'attrib[type]':['funkis'], 'attrib[value]': ['dagtid']}, function(resp){ 
          var player_group = resp.stored;
          console.log("playerGroup done!");
          $.post("engine.php",{type:'plot', name: 'P1', game:game, characters:[char1], tags:'single', 'attrib[type]':['type'], 'attrib[value]': ['crawl']}, function(resp){ 
            console.log("singel plot done!");
            $.post("engine.php",{type:'plot', name: 'P2', game:game, group:[char_group], tags:'group', 'attrib[type]':['type'], 'attrib[value]': ['crawl']}, function(resp){ 
              console.log("group plot done!");
              $.post("engine.php",{type:'realation', game:game, 'character[init]':[char1], 'character[recip]':[char2], tags:'public', 'attrib[type]':['type'], 'attrib[value]': ['friendship']}, function(resp){ 
                console.log("relationship done!");
                console.log("all done!");
              });
            });
          });
        });
       });
      });
    });
  });
});