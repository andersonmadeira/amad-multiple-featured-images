<!-- Your image container, which can be manipulated with js -->
<div class="mfi-img-container">
    <?php if ( $mfi_has_thumb_image ) echo $mfi_thumb_image; ?> 
</div>

<!-- Your add & remove image links -->
<p class="hide-if-no-js">
    <a class="select-featured <?php if ($mfi_has_thumb_image) echo 'hidden';?>" href="#">
        <?php _e('Definir miniatura') ?>
    </a>
    <a class="delete-featured <?php if (!$mfi_has_thumb_image) echo 'hidden';?>" href="#">
        <?php _e('Remover miniatura') ?>
    </a>
</p>

<input class="mfi-id-input" name="mfi_id" type="hidden" value="<?php echo esc_attr( $mfi_id ); ?>" />