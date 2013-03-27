<?php if($fract) : ?> 
<style>
* {
    box-sizing: border-box;
}
html, body {
    height: 100%;
    }
html {
    background-color: #F8F8F1;
    }
article {
    margin: 0 1em 1em;
    padding: 1em;
    background-color: #FBFBFB;
    box-shadow: 0 .5em .5em rgba(0,0,0,.05);
    z-index: 2;    
    text-align: center;
    }
.bar {
    background-color: #C2CEA5;
    padding: .5em 1em;
    color: #F8F8F1;
    text-shadow: 0 .1em .75em rgba(0,0,0,.25);
    font-size: 120%;
    z-index: 1;
    box-shadow: 0 0 .5em rgba(0,0,0,.25) inset;
    }
.bar:after{
    float: right;
    position: relative;
    content: '\2716';
    top: .1em;  
    right: 0;
    color: #C2CEA5;
    text-shadow: 0 -.1em rgba(0,0,0,.25);    
    }
.flash {
    text-align: center;
}
.box {
    margin: 0 .5em .5em;
    border-radius: .25em;
    box-shadow: 0 .15em .25em rgba(0,0,0,.5);
    color: #FBFBFB;
    text-shadow: 0 .1em rgba(0,0,0,.5);
    font-size: 110%;
    border: .5em solid rgba(0,0,0,.05);
    }
.box p, .box form {
    padding: .5em;
    border-radius: .125em;
    height: 100%;
    box-shadow: 0 .15em 0 rgba(255,255,255,.25) inset,
                0 -.15em 0 rgba(0,0,0,.1) inset;
    }
.box:before{
    float: right;
    position: relative;
    content: '\2716';
    top: .1em;  
    right: .25em;            
    text-shadow: 0 .1em rgba(255,255,255,.45);
    color: rgba(0,0,0,.1);
    }

.alert p {
    background-color: #F78C62;
    }
.info p {
    background-color: #4C87A3;
    }

.box.input {
    background-color: #efefef;
}

.box.input button {
    border: none;
    padding: .5em;
    border-radius: .25em;
    height: 100%;
    box-shadow: 0 .15em 0 rgba(255,255,255,.25) inset,
                0 -.15em 0 rgba(0,0,0,.1) inset;
    background-color: #4C87A3;
    width: 10%;
    color: #F8F8F1;
    text-shadow: 0 .1em .75em rgba(0,0,0,.25);
    }  
.box.input .rem button {
    background-color: #F78C62;
    }
.box.input label {
    display: inline-block;
    text-transform: uppercase;
    font-family: helvetica, arial;
    font-size: 60%;
    text-shadow: none;
    letter-spacing: .2em;
    padding: 0 .5em .25em;
    width: 90%;
    color: rgba(0,0,0,.5);
    }
.box.input.expanded input[type='text']{
     display: block;
   font-family: helvetica, arial;
    font-size: 90%;
    width: 96%;
    color: #4C87A3;
    border: none; 
    outline: 0;
    padding: .5em;
    margin: 0 0 .25em 0;
    background: #fff;
    box-shadow: inset 0px .2em .3em rgba( 0,0,0,.1 ), 
                0 0 .1em 0 rgba(0,0,0,.25);
    }
.box.input.expanded fieldset {
    margin: .25em 0;
} 
.box.input.expanded.attributes input[type='text']{
    display: inline-block;
    width: 42%;
    }

.box.input.expanded textarea {
    display: block;
    font-family: helvetica, arial;
    font-size: 90%;
    width: 96%;
    color: #4C87A3;
    border: none; 
    outline: 0;
    padding: .5em;
    margin: 0 0 .25em 0;
    background: #fff;
    box-shadow: inset 0px .2em .3em rgba( 0,0,0,.1 ), 
                0 0 .1em 0 rgba(0,0,0,.25);
    }

.box.input.colapsed input, .box.input.colapsed textarea, .box.input.colapsed button {
    display: none;
    }
.box.input.colapsed {
    display: inline-block;
    text-align: center;
    margin: .5em;
    width: 90px;
    height: 90px;
    font-size: 80%;
    } 
.box.input.colapsed:before{ 
    content: none;
    }
.box.files input {
    color: #000;
    width: 90%;
    margin-bottom: .5em;
}
</style>

<header class="bar">
    &#x229f; 
    &#x229e;
</header>

<article>
    <div class="flash info box">
        <p>info</p>
    </div>
    
    <div class="flash alert box">
        <p>alert</p>
    </div>

    
    <div class="box input colapsed oneline">
        <p>
            <label for="headline">headline</label>
            <input type="text" name="headline" class="attribute"/>
        </p>
    </div>

    <div class="box input colapsed textbox">
        <p>
            <label for="headline">pitch</label>
            <textarea name="pitch" rows="10" placeholder="introduction.." class="attribute"></textarea>
        </p>
    </div>
    

    <div class="box input colapsed textbox">
        <p>
            <label for="headline">description</label>
            <textarea name="description" rows="10" placeholder="main text.." class="attribute"></textarea>
        </p>
    </div>
    

    <div class="box input colapsed attributes">
        <form id="attributes">
          <label for="attributes">Attributes</label>            
            <fieldset class="attr add">
              <input type="text" class="type" name="attrib[type][]" value="" placeholder="type"/>
              <input type="text" class="val" name="attrib[value][]" value="" placeholder="value"/>
              <button>+</button>
            </fieldset>
        </form>
    </div>

    <div class="box input colapsed oneline">
        <p>
            <label for="tags">tags</label>
            <input type="text" name="tags" placeholder="comma separated.." />
        </p>
    </div>    
    
    <div class="box input colapsed file">
        <p>
            <label for="bgimg">poster</label>
            <input type="file" name="images" style="color: #000;" class="attribute"/>
        </p>
    </div>     
    
    <div class="box input colapsed files">
        <p>
            <label for="images">images</label>
            <input type="file" name="images[]"/>
        </p>
    </div>     
</article>

<script>
	$(document).ready(function(){
		$("div.box").click(function(e){ 
			if($(this).is(".expanded") && !$(e.target).is(".expanded")) return;
			$(this).toggleClass("expanded colapsed", 200); 
		});

		$(".flash").click(function(){ $(this).slideUp(100); });

		$(".files p").on("change", "input:not(.changed)", function(){
			if( $(this).val().length ) {
				$(this).clone().val(null).appendTo($(this).parent());        
				$(this).addClass("changed");        
			}
		});

		$("#attributes").on("click", "button", function(e){ 
			e.preventDefault();
			if($(this).parent().is(".rem")) {
				$(this).parent().remove();
			} else {
				var newAttr = $(this).parent().clone();
				newAttr.children("input").each(function(){ $(this).val(null); });
				newAttr.appendTo("#attributes");
				$(this).parent().toggleClass("add rem").end().text("-");
			}
			refreshAttr();
		});
			
		function refreshAttr() {
			$("#attributes > div").each(function(i,n){
			  $(this).children(".type").attr("name", "attrib[type][" + i + "]");
			  $(this).children(".val").attr("name", "attrib[value][" + i + "]");
			});
		}
	});
</script>
<?php endif; ?>	