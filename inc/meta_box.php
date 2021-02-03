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
                <input type="text" name="A4C_id_SV" id="A4C-id-SV" value=""/>
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
?>