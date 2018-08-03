(function ($) {

    $(document).ready(function () {
        var frame;

        $('.amad_mfi_box .select-featured').on('click', function (event) {
            event.preventDefault();

            $add_link = $(this); // addlink
            $del_link = $add_link.closest('.amad_mfi_box').find('.delete-featured');
            $img_container = $add_link.closest('.amad_mfi_box').find('.mfi-img-container');
            $id_input = $add_link.closest('.amad_mfi_box').find('.mfi-id-input');
            
            $add_link.attr('href', amad_mfi.upload_link);

            if (frame) {
                frame.open();
                return;
            }

            // Create a new media frame
            frame = wp.media({
                title: amad_mfi.select_message,
                button: {
                    text: amad_mfi.use_image
                },
                multiple: false
            });

            // When an image is selected in the media frame...
            frame.on('select', function () {

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom image input field.
                $.post(amad_mfi.ajax_url,
                    {
                        'action': 'mfi_get_thumbnail',
                        'security': amad_mfi.get_thumbnail_nonce,
                        'id': attachment.id
                    }).done(function (data) {
                        console.log(data);
                        var $elem = $(data);
                        $elem.removeAttr('width').removeAttr('height');
                        $img_container.html($elem);
                    });

                // Send the attachment id to our hidden input
                $id_input.val(attachment.id);

                // Hide the add image link
                $add_link.addClass('hidden');

                // Unhide the remove image link
                $del_link.removeClass('hidden');
            });

            // Finally, open the modal on click
            frame.open();
        });

        $('.amad_mfi_box .delete-featured').on('click', function (event) {

            event.preventDefault();

            $del_link = $(this); // addlink
            $add_link = $del_link.closest('.amad_mfi_box').find('.select-featured');
            $img_container = $del_link.closest('.amad_mfi_box').find('.mfi-img-container');
            $id_input = $del_link.closest('.amad_mfi_box').find('.mfi-id-input');

            // Clear out the preview image
            $img_container.html('');

            // Un-hide the add image link
            $add_link.removeClass('hidden');

            // Hide the delete image link
            $del_link.addClass('hidden');

            // Delete the image id from the hidden input
            $id_input.val('');

        });
    });
    
})(jQuery);