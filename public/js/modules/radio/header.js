$(document).ready(function(){

	// scroller da playlist
	$(window).load(function(){
		$('.jp-playlist').mCustomScrollbar();
	});

	jsonMusicas = JSON.parse(jsonMusicas);
	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer",
		cssSelectorAncestor: "#radioPlayer"
	}, jsonMusicas,
	{
		swfPath: "js",
		supplied: "oga, mp3",
		wmode: "window"
	});


});