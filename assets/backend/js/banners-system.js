jQuery(function($){
    $('#upload').on('click', function() {
        var file_data = $('#banner-file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $('body').css('cursor', 'wait');
        $.ajax({
            url: $(this).data('url')
                + '?uniqKey='
                + $('#banner-banner_dir').val()
                + '&zoneId='
                + $('#banner-zone_id').val()
                + '&link='
                + $('#banner-link').val(),
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
                $('body').css('cursor', 'default');
                data = jQuery.parseJSON(data);
                if(data.success) {
                    CKEDITOR.instances["banner-html"].setData(data.html);
                } else {
                    alert(data.message)
                }

            }
        });
    });
});