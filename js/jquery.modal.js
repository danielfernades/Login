$(function()
{
	$('.modal-opener').on('click', function()
	{
		if( !$('#form-modal-overlay').length )
		{
			$('body').append('<div id="form-modal-overlay" class="form-modal-overlay"></div>');
		}		
	
		$('#form-modal-overlay').on('click', function()
		{
			$('#form-modal-overlay').fadeOut();
			$('.form-modal').fadeOut();
		});
		
		form = $($(this).attr('href'));
		$('#form-modal-overlay').fadeIn();
		form.css('top', '50%').css('left', '50%').css('margin-top', -form.outerHeight()/2).css('margin-left', -form.outerWidth()/2).fadeIn();
		
		return false;
	});
	
	$('.modal-closer').on('click', function()
	{
		$('#form-modal-overlay').fadeOut();
		$('.form-modal').fadeOut();
		
		return false;
	});
});