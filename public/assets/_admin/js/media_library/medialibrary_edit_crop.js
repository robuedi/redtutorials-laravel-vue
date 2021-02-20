


$(function () {

    'use strict';

    //init
    var console = window.console || { log: function () {} };
    var URL = window.URL || window.webkitURL;
    var $image = $('#image');
    var $download = $('#download');

    var uploadedImageName;
    var uploadedImageType;
    var uploadedImageURL;

    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');

    var options = {
        // preview: '.img-preview',
        crop: function (e) {
            // console.log(e);
            $dataHeight.text(Math.round(e.detail.height));
            $dataWidth.text(Math.round(e.detail.width));
            $dataX.text(Math.round(e.detail.x));
            $dataY.text(Math.round(e.detail.y));
        }
    };

    var uploadedFile = false;
    $('#inputImage').on('change', function () {
        var fileInput = document.getElementById('inputImage');
        var filename = fileInput.files[0].name;

        uploadedImageName = filename.replace(/^.*[\\\/]/, '');
        uploadedImageType = 'image/'+uploadedImageName.split('.').pop();
        uploadedFile = true;
    });

    // Cropper
    $image.on({
        ready: function (e) {

            if(!uploadedFile)
            {
                var originalImageURL = $image.attr('src');
                uploadedImageName = originalImageURL.replace(/^.*[\\\/]/, '');
                uploadedImageType = 'image/'+uploadedImageName.split('.').pop();
            }
            else
            {
                uploadedFile = false;
            }
        },
        cropstart: function (e) {
            // console.log(e.type, e.action);
        },
        cropmove: function (e) {
            // console.log(e.type, e.action);
        },
        cropend: function (e) {
            // console.log(e.type, e.action);
        },
        crop: function (e) {
            // console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
        },
        zoom: function (e) {
            // console.log(e.type, e.ratio);
        }
    }).cropper(options);



    // Methods
    $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this);
        var data = $this.data();
        var cropper = $image.data('cropper');
        var cropped;
        var $target;
        var result;

        if ($this.prop('disabled') || $this.hasClass('disabled')) {
            return;
        }

        if (cropper && data.method) {
            data = $.extend({}, data); // Clone a new one

            if (typeof data.target !== 'undefined') {
                $target = $(data.target);

                if (typeof data.option === 'undefined') {
                    try {
                        data.option = JSON.parse($target.val());
                    } catch (e) {
                        // console.log(e.message);
                    }
                }
            }

            cropped = cropper.cropped;

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('clear');
                    }

                    break;

                case 'getCroppedCanvas':
                    if (uploadedImageType === 'image/jpeg') {
                        if (!data.option) {
                            data.option = {};
                        }

                        data.option.fillColor = '#fff';
                    }

                    break;
            }

            result = $image.cropper(data.method, data.option, data.secondOption);

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        $image.cropper('crop');
                    }

                    break;

                case 'scaleX':
                case 'scaleY':
                    $(this).data('option', -data.option);
                    break;

                case 'getCroppedCanvas':
                    if (result) {
                        // Bootstrap's Modal
                        $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                        if (!$download.hasClass('disabled')) {
                            download.download = uploadedImageName;
                            $download.attr('href', result.toDataURL(uploadedImageType));
                        }
                    }

                    break;

                case 'testBtn':
                    break;

            }

            if ($.isPlainObject(result) && $target) {
                try {
                    $target.val(JSON.stringify(result));
                } catch (e) {
                    // console.log(e.message);
                }
            }

        }
    });

    // Keyboard
    $(document.body).on('keydown', function (e) {

        if (!$image.data('cropper') || this.scrollTop > 300) {
            return;
        }

        switch (e.which) {
            case 37:
                e.preventDefault();
                $image.cropper('move', -1, 0);
                break;

            case 38:
                e.preventDefault();
                $image.cropper('move', 0, -1);
                break;

            case 39:
                e.preventDefault();
                $image.cropper('move', 1, 0);
                break;

            case 40:
                e.preventDefault();
                $image.cropper('move', 0, 1);
                break;
        }

    });

    // Download
    if (typeof $download[0].download === 'undefined') {
        $download.addClass('disabled');
    }


    // Import image
    var $inputImage = $('#inputImage');

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (!$image.data('cropper')) {
                return;
            }

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    //upload image
    $('[data-upload-img]').on('click', function () {
        var cropper = $image.data('cropper');
        cropper.getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData();

            formData.append('croppedImage', blob);
            var file = new File([blob], uploadedImageName);
            uploader.addFile(file);
        });
    });
});


