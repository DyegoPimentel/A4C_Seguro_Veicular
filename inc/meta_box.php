<?php

add_action( 'admin_init', 'A4C_add_meta_box' );

function A4C_add_meta_box() {
    add_meta_box( 
        'precos_meta_box', // ID
        'Informações desta faixa de preço', // Descrição
        'A4C_display_meta_box', // Função
        'seguro_veicular', // Registro do CPT
        'normal', // Local em que vai aparecer
        'high' // Posição em que vai aparecer
    );
}


function A4C_display_meta_box($post) {
    wp_nonce_field( basename( __FILE__ ), 'A4C_sv_nonce');
    $a4c_stored_meta = get_post_meta( $post->ID);
    ?>

    <div>
        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-id-SV" class="a4c-row-title">ID</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_id_SV" id="A4C-id-SV" value="<?php if ( ! empty ( $a4c_stored_meta['A4C_id_SV'] ) ) echo esc_attr( $a4c_stored_meta['A4C_id_SV'][0] ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-categoria-SV" class="a4c-row-title">Categoria</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_categoria_SV" id="A4C-categoria-SV" value=""/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-valor_minimo-SV" class="a4c-row-title">Valor Mínimo</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_valor_minimo_SV" id="A4C-valor_minimo-SV" value=""/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-valor_maximo-SV" class="a4c-row-title">Valor Máximo</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_valor_maximo_SV" id="A4C-valor_maximo-SV" value=""/>
            </div>
        </div>

    </div>
    
 <?php
}

function A4C_meta_save( $post_id ) {
    // checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['A4C_sv_nonce'] ) && wp_verify_nonce( $_POST['A4C_sv_nonce'], basename( __FILE__ ))) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if (isset( $_POST['A4C_id_SV'] )) {

        update_post_meta($post_id, 'A4C_id_SV', sanitize_text_field( $_POST['A4C_id_SV'] ) );

    }
}
add_action( 'save_post', 'A4C_meta_save');

?>