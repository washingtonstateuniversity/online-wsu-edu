// "I'm" button for homepage


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


   });

}(jQuery));
