
$(document).ready(function() 
{	
	$('.balloon').hide();
	
	$('#produtos li').mouseover(function () 
	{
		$(this).find('.balloon').stop().fadeTo(100, 1);
	});
	
	$('#produtos li').mouseout(function() 
	{
		$(this).find('.balloon').stop().fadeTo(300, 0, function() 
		{
			$(this).find('.balloon').hide();
		});
    });
});

