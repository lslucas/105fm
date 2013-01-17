
$(document).ready(function() 
{	
	var easeType = 'easeInOutQuad';
	
	$('.one').click(function () 
	{
		$('#nf_img').animate({ left: 0 }, 
		{
			duration: 700,
			easing: easeType
		});
	})
	
	$('.two').click(function () 
	{
		$('#nf_img').animate({ left: -275 }, 
		{
			duration: 700,
			easing: easeType
		});
	})
	
	$('.three').click(function () 
	{
		$('#nf_img').animate({ left: -550 }, 
		{
			duration: 700,
			easing: easeType
		});
	});
	
	
	
	$('#cpf_balloon').hide();
	
	$('#btn_cpf').mouseover(function()
	{
		$('#cpf_balloon').fadeIn();
	});
	
	$('#btn_cpf').mouseout(function()
	{
		$('#cpf_balloon').fadeOut();
	});
});

