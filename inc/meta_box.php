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
                <input type="text" name="A4C_id_SV" id="A4C-id-SV" value="<?php if ( ! empty ( $a4c_stored_meta['A4C_id_SV'] ) ) echo esc_attr( $a4c_stored_meta['A4C_id_SV'][0] ); ?>" readonly/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-categoria-SV" class="a4c-row-title">Categoria</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_categoria_SV" id="A4C-categoria-SV" value="<?php if ( ! empty ( $a4c_stored_meta['A4C_categoria_SV'] ) ) echo esc_attr( $a4c_stored_meta['A4C_categoria_SV'][0] ); ?>" readonly/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-valor_minimo-SV" class="a4c-row-title">Valor Mínimo</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_valor_minimo_SV" id="A4C-valor_minimo-SV" value="<?php if ( ! empty ( $a4c_stored_meta['A4C_valor_minimo_SV'] ) ) echo esc_attr( $a4c_stored_meta['A4C_valor_minimo_SV'][0] ); ?>"/>
            </div>
        </div>

        <div class="meta-row">
            <div class="meta-th">
                <label for="A4C-valor_maximo-SV" class="a4c-row-title">Valor Máximo</label>
            </div>
            <div class="meta-td">
                <input type="text" name="A4C_valor_maximo_SV" id="A4C-valor_maximo-SV" value="<?php if ( ! empty ( $a4c_stored_meta['A4C_valor_maximo_SV'] ) ) echo esc_attr( $a4c_stored_meta['A4C_valor_maximo_SV'][0] ); ?>"/>
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

    if ($post_id === false) { // Se não tiver o Id do post.
        return;
    } else { // Se tiver o Id do post.
        $post_id = get_the_ID(); // Pega o Id do post
        $category = get_the_category($post_id); // Verifica qual é a categoria do post;
    }  

    if(empty($category) || NULL === $category || 0 === $category || '0' === $category) {
        $category = NULL; // Se a categoria estiver vazia, não retorna nada e grava null no db.            
    } else {
        $category = $category[0]->name; // Se a categoria não estiver vazia, retorna a string com o nome da categoria.
    }

    // AO SALVAR/ATUALIZAR O POST, ATUALIZA OS CAMPOS ABAIXO.

    // Insere/atualiza o campo de ID com o ID do post.
    update_post_meta($post_id, 'A4C_id_SV', sanitize_text_field( $post_id ) );

    // Insere/atualiza o campo de categoria com a categoria do custom post type.
    update_post_meta($post_id, 'A4C_categoria_SV', sanitize_text_field( $category ) );

    if (isset( $_POST['A4C_valor_minimo_SV'] )) {
        update_post_meta($post_id, 'A4C_valor_minimo_SV', sanitize_text_field( $_POST['A4C_valor_minimo_SV'] ) );
    }

    if (isset( $_POST['A4C_valor_maximo_SV'] )) {
        update_post_meta($post_id, 'A4C_valor_maximo_SV', sanitize_text_field( $_POST['A4C_valor_maximo_SV'] ) );
    }
    
}

function A4C_create_title($post_id) {
    // Registra o titulo da postagem
    $valor_minimo = floatval($_POST['A4C_valor_minimo_SV']);
    $valor_maximo = floatval($_POST['A4C_valor_maximo_SV']);
    
    //VERIFICAR ARRAY, ESTA SALVANDO MAS DEMORA MUITO E AS VEZES DA ERRO.
    $update_title = array(
        'ID'           => $post_id,
        'post_title'   => wp_strip_all_tags( ' De R$' . $valor_minimo . ' a R$' . $valor_maximo),
        'post_status' => 'publish',
    );
    wp_update_post( $update_title );  
    return;        
}


add_action( 'transition_post_status', 'A4C_transition_post_status', 10, 3 );  

function A4C_transition_post_status( $new_status, $old_status, $post ) {
    if ( $new_status == 'auto-draft' && $old_status == 'new' ) {
        // the post is inserted
        add_action( 'save_post', 'A4C_create_title');
        
        
    } else if ( $new_status == 'publish' && $old_status != 'publish' ) {
        // the post is published
        add_action( 'save_post', 'A4C_meta_save');
        add_action( 'save_post', 'A4C_create_title');


    } else {
        // the post is updated
        add_action( 'save_post', 'A4C_meta_save');
        add_action( 'save_post', 'A4C_create_title');


    }
}

?>