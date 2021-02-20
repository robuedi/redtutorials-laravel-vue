Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

$(function(){
    // display media library popup
    $('.browse-media-library').click(function(){
        // by default display browse tab
        $('#media-library-iframe').attr('src', site_url + '/backend/medialibrary/popup_browse');

        $('#modal-media-library').modal('show');
    });

    // when we click on tabs, refresh iframe content
    $("#modal-media-library .nav-tabs a").on('click', function(event){
        event.preventDefault();

        // activate tabs
        if($(this).attr('href').indexOf('popup_browse') > -1) {
            $("#modal-media-library .nav-tabs li.browse").addClass('active');
            $("#modal-media-library .nav-tabs li.upload").removeClass('active');
        } else if ($(this).attr('href').indexOf('popup_upload') > -1) {
            $("#modal-media-library .nav-tabs li.browse").removeClass('active');
            $("#modal-media-library .nav-tabs li.upload").addClass('active');
        };

        // add a class hidden until the iframe finish loading
        // and change the src
        $("#modal-media-library .preloader").removeClass('hidden');
        $('#media-library-iframe').addClass('hidden').attr('src', $(this).attr('href'));
    });

    // reset things when popop is closed
    $('#modal-media-library').on('hidden', function () {
        $('#media-library-iframe').attr('src', '');
        selectedImages = {};
    });

    // when the iframe finish loading remove class hidden
    $('#media-library-iframe').load(function(){
        $(this).removeClass('hidden');
        $("#modal-media-library .preloader").addClass('hidden');

        resizeIframe(this);
    });

    // when the user press on Select Images, refresh input hidden values, and trigger function displaySelectedImages
    $('.btn-select-images').on('click', function(){
        refreshSelectedImages();

        // ascunde modalul
        $('#modal-media-library').modal('hide');
    });
});

refreshSelectedImages = function(){

    if(Object.size(selectedImages) > 0){
        images = new Array();

        $.each(selectedImages, function(index, value) {
            images.push(value.fileId);
        });

        // adauga valorile selectate in inputul hidden
        $('body').find('input.selected-images').val(images.join(','));
    } else {
        // adauga valorile selectate in inputul hidden
        $('body').find('input.selected-images').val('');
    }

    // apeleaza functia care va afisa fisierele selectate
    // customizabila pentru fiecare actiune
    if(typeof(displaySelectedImages) === "function")
        displaySelectedImages(selectedImages);
};

removeSelectedImages = function(ids) {
    if(!ids.length)
        return false;

    for (i = 0; i < ids.length; i++) {
        delete parent.selectedImages['file-' + ids[i]];
    }

    refreshSelectedImages();
};