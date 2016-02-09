jQuery(document).ready(function() {
    var orig_send_to_editor = window.send_to_editor;

    jQuery('.upload_image_button').on('click', function(e) {
        e.preventDefault();
        var self = jQuery(this);

        tb_show('', 'media-upload.php?type=file&TB_iframe=true', false);

        window.send_to_editor = function(html) {
            var img = jQuery(html);

            if(typeof(img) != 'undefined') {
                self.prev('input').val(img.attr('src'));
            }

            window.send_to_editor = orig_send_to_editor;
            tb_remove();
        };
        return false;
    });
});
