// "I'm" button - maybe for homepage


(function($){

    $(document).ready(function() {

        $('#accordion').accordion({
     		header: "h5", active: false, collapsible: true, heightStyle: "content"
    	});


    	$("#hide").click(function(){
        	$(".hideme").hide();
    	});

    	$("#show").click(function(){
        	$(".hideme").show();
    	});


	    $(".csuglobal-inside-0").hide();
        $(".csuglobal-inside-1").hide();
        $(".csuglobal-inside-2").hide();

        $(".csuglobal-0").click(function(){
    		$(".csuglobal-inside-0").toggle();
		});

        $(".csuglobal-1").click(function(){
    		$(".csuglobal-inside-1").toggle();
		});

        $(".csuglobal-2").click(function(){
    		$(".csuglobal-inside-2").toggle();
		});


/**!
 * MixItUp v2.1.11
 *
 * @copyright Copyright KunkaLabs Limited.
 * @author    KunkaLabs Limited.
 * @link      https://mixitup.kunkalabs.com
 *
 * @license   Commercial use requires a commercial license.
 *            https://mixitup.kunkalabs.com/licenses/
 *
 *            Non-commercial use permitted under terms of CC-BY-NC license.
 *            http://creativecommons.org/licenses/by-nc/3.0/
 */

  var $filterSelect = $('#FilterSelect'),
      $sortSelect = $('#SortSelect'),
      $container = $('#Container');

  $container.mixItUp();

  $filterSelect.on('change', function(){
    $container.mixItUp('filter', this.value);
  });

  $sortSelect.on('change', function(){
    $container.mixItUp('sort', this.value);
  });

// mixitup search via codepen http://codepen.io/anon/pen/FwkxC

$(function() {

  $(".container").mixItUp();

  var inputText;
  var $matching = $();

  // Delay function
  var delay = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();

  $("#input").keyup(function(){
    // Delay function invoked to make sure user stopped typing
    delay(function(){
      inputText = $("#input").val().toLowerCase();

      // Check to see if input field is empty
      if ((inputText.length) > 0) {
        $( '.mix').each(function() {
          $this = $("this");

           // add item to be filtered out if input text matches items inside the title
           if($(this).children('.title').text().toLowerCase().match(inputText)) {
            $matching = $matching.add(this);
          }
          else {
            // removes any previously matched item
            $matching = $matching.not(this);
          }
        });
        $(".container").mixItUp('filter', $matching);
      }

      else {
        // resets the filter to show all item if input is empty
        $(".container").mixItUp('filter', 'all');
      }
    }, 200 );
  });
})


   });

}(jQuery));
