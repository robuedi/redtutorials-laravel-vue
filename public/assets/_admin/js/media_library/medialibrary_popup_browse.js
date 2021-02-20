$(function(){
	// select items 
	$.each(parent.selectedImages, function(index, image) {
        $('.media-library').find('.media-item[data-file="'+image.fileId+'"]').addClass('selected');
    });

	$('.media-item').on('click', function(){
		// get file id
		fileId = $(this).data('file');

		if(fileId === undefined || fileId == 0)
			return;

        // check if current image is selected
        currentItemSelected = $(this).hasClass('selected');

        if(parent.selectMode == 'single') {
            $('.media-item').removeClass('selected');

            parent.selectedImages = {};
        }

		// add or remove this image
		if(currentItemSelected) {
			delete parent.selectedImages['file-' + fileId];

			$(this).removeClass('selected');
		} else {
			parent.selectedImages['file-' + fileId] = mediaLibraryImages['file-' + fileId];

			$(this).addClass('selected');
		}
	});
});