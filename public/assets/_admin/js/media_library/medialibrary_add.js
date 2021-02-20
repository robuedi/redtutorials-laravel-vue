/**
 * Created by marian on 24/07/14.
 */
 $(function(){
    $('.fileslist').html('');

     var itemLink = $('[data-upload-item]').attr('data-upload-item');

     var uploader = new plupload.Uploader({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         runtimes : 'html5,flash,silverlight,html4',
         browse_button : 'pickfiles',
         drop_element: 'drag-drop-area',
         container: document.getElementById('upload-container'),
         max_file_size : '30mb',

         url : site_url + '/'+ admin_url +'/media-library/upload' + itemLink,

         flash_swf_url : admin_url+'/js/libs/plugin/plupload/Moxie.swf',
         silverlight_xap_url : admin_url+'/js/libs/plugin/plupload/Moxie.xap',
         filters : [
             {title : "Image files", extensions : "jpg,gif,png"},
             {title : "Documents", extensions : "pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,txt,rtf"}
         ],

         init: {
             PostInit: function() {
                 $('#uploadfiles').on('click',function() {
                     console.log('upload btn');
                     uploader.start();
                     return false;
                 });
             },

             FilesAdded: function(up, files) {
                 $('.error-console').html('').addClass('hidden');
                 $('.uploaded-files').removeClass('hidden');

                 plupload.each(files, function(file) {
                     $('.fileslist').append('<div class="panel panel-default" id="' + file.id + '">' +
                        '<div class="panel-body">' +
                            '<div class="row">' +
                                '<div class="col-xs-7">' + file.name + ' (' + plupload.formatSize(file.size) + ')</div>' +
                                '<div class="col-xs-5">' +
                                     '<div class="progress">' +
                                         '<div class="progress-bar bg-color-blue" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>' +
                                     '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                     '</div>');
                 });

                 up.start();
                 up.refresh(); // Reposition Flash/Silverlight
             },

             UploadProgress: function(up, file) {
                 $('#'+file.id).find('.progress-bar')
                     .attr('aria-valuenow',file.percent)
                     .html(file.percent + '%')
                     .width(file.percent + "%");
             },

             FileUploaded: function(up, file, res) {
                 uploadResponse = $.parseJSON(res.response);

                 infoContainer = $('#'+file.id).find('.progress').parent();

                 $('#'+file.id).closest('.panel').removeClass('panel-default').addClass('panel-success');
                 $('#'+file.id).find('.progress').remove();
                 infoContainer.addClass("text-right")
                 infoContainer.html('<span class="text-muted">' + uploadResponse.file_url + '</span>');
             },

             Error: function(up, err) {
                 $('.error-console').removeClass('hidden').html("\nError #" + err.code + ": " + err.message);
             }
         }
     });

     uploader.init();
 });