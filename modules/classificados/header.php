<?php

$incjQuery .= "
$(document)
	.on('dragover', function (e) {
		e = e.originalEvent;
		e.preventDefault();
		e.dataTransfer.dropEffect = 'copy';
	})
.on('drop', load);
$('#file-input').on('change', load);";