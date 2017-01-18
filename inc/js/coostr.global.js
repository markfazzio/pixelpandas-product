var COOSTR = COOSTR || {},
	$ = jQuery;

COOSTR.global = {
	init: function()
	{
		COOSTR.global.initListeners();
	},
	initListeners: function()
	{
		//$('#promoVideo').get(0).addEventListener("ended", COOSTR.global.resetVideo, false);
		$(document).on('click','.coostr-toggle', COOSTR.global.handlers.onCoostrToggleClick);
		$(document).on('click', '.color', COOSTR.global.handlers.onColorSelectorClick);
		$(document).on('click', '.turtle.active', COOSTR.global.handlers.onTurtleImageClick);
		$(document).on('click', '[data-toggle=offcanvas]', COOSTR.global.handlers.onNavToggle);
		$(document).on('click', '.color-increment, .color-decrement', COOSTR.global.handlers.onColorPlusMinusClick);
		
		$(window).on('scroll', COOSTR.global.handlers.onWindowScroll);
		
		$(window).on('beforeunload', function() {
			if($('body').hasClass('home'))
				$(window).scrollTop(0);
		});
	},
	handlers: {
		onCoostrToggleClick: function(e)
		{
			if(e && e.preventDefault())
				e.preventDefault();

			$(this).toggleClass('popped');
		},
		onColorSelectorClick: function(e)
		{
			if(e && e.preventDefault())
				e.preventDefault();
			
			var turtleColor = $(this).data('color');
			
			$('.color').removeClass('active');
			$(this).addClass('active');
			
			$('.turtle.popped').removeClass('active');
			$('.turtle.unpopped').addClass('active');
			
			$('.turtle-image.row').removeClass('active');
			$('.turtle-image.row[data-color="'+ turtleColor +'"]').addClass('active');
		},
		onTurtleImageClick: function(e)
		{
			if(e && e.preventDefault())
				e.preventDefault();
			
			$(this).removeClass('active');
			
			if($(this).hasClass('unpopped'))
			{
				$('.turtle.popped').addClass('active');
			}
			else
			{
				$('.turtle.unpopped').addClass('active');
			}
		},
		onWindowScroll: function()
		{
			/* Check the location of each desired element */
	        $('.featurette').each( function(i){
	            
	            var bottom_of_object = $(this).position().top + $(this).outerHeight();
	            var bottom_of_window = $(window).scrollTop() + $(window).height();
	            
	            /* If the object is completely visible in the window, fade it it */
	            if( bottom_of_window > bottom_of_object ){
	                
	                $(this).animate({'opacity':'1'},500);
	                    
	            }
	            
	        }); 
		},
		onNavToggle: function()
		{
			$('.row-offcanvas').toggleClass('active');
		},
		
		onColorPlusMinusClick: function(e){
			if(e && e.preventDefault())
				e.preventDefault();

			colorName = $(this).data('field'),
			amountField = '#' + colorName,
			amountFieldTotal = $(amountField).val(),
			totalAvailable = $('#coostr-amount').val(),
			$colorCounters = $('.color-amount'),
			colorCountersTotal = 0;

			if($(this).hasClass('color-increment'))
			{
				amountFieldTotal++;
			}
			else
			{
				// do not decrement at 0
				if(amountFieldTotal > 0)
				{
					amountFieldTotal--;
				}
			}
			
			$(amountField).val(amountFieldTotal);
            
            $.each($colorCounters, function(){
				
				var wooId = $(this).data('target'),
					$targetWooInput = $('input[name="quantity['+ wooId +']"]');

				colorCountersTotal += parseInt($(this).val());                
				$targetWooInput.val(parseInt($(this).val()));

			});
                        
            $('span.coostr-picked').text(colorCountersTotal);
            $('.price .amount').text('$'+(5 * colorCountersTotal).toFixed(2));

		}
	},
	resetVideo: function()
	{
		this.src = this.src;
	},
	disableAndResetColorCounters: function()
	{
		$('.color-increment, .color-decrement').prop('disabled', true);
		$('.color-amount').val(0);
		$('.coostr-picked').text('0');
	}
};

$(document).ready(function(){
	COOSTR.global.init();
});