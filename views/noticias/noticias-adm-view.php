<?php
// Evita acesso direto a este arquivo
if ( ! defined('ABSPATH')) exit;

// Configura as URLs
$adm_uri = HOME_URI . '/noticias/adm/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';


// Carrega o método para obter uma notícia
$modelo->obtem_noticia();

// Carrega o método para inserir uma notícia
$modelo->insere_noticia();

// Carrega o método para apagar a notícia
$modelo->form_confirma = $modelo->apaga_noticia();

// Remove o limite de valores da lista de notícias
$modelo->sem_limite = true;
?>

<div class="wrap">

    <?php
    // Mensagem de configuração caso o usuário tente apagar algo
    echo $modelo->form_confirma;
    ?>

    <!-- Formulário de edição das notícias -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Título: <br>
                    <input type="text" name="noticia_titulo" value="<?php
                    echo htmlentities( chk_array( $modelo->form_data, 'noticia_titulo') );
                    ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="noticia_imagem" value="" />
                </td>
            </tr>
            <tr>
                <td>
                    Data: <br>
                    <input type="text" name="noticia_data" value="<?php
                    $data = chk_array( $modelo->form_data, 'noticia_data');
                    if ( $data && $data != '0000-00-00 00:00:00' )
                        echo date('d-m-Y H:i:s', strtotime( $data ) );
                    ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Autor: <br>
                    <input type="text" name="noticia_autor" value="<?php
                    echo htmlentities( $_SESSION['userdata']['user_name'] );
                    ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Texto da notícia: <br>
					<textarea name="noticia_texto"><?php
                        echo htmlentities( chk_array( $modelo->form_data, 'noticia_texto') );
                        ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    // Mensagem de feedback para o usuário
                    echo $modelo->form_msg;
                    ?>
                    <input type="submit" value="Save" />
                </td>
            </tr>
        </table>

        <input type="hidden" name="insere_noticia" value="1" />
    </form>

    <!-- LISTA AS NOTICIAS -->
    <?php $lista = $modelo->listar_noticias(); ?>

    <table class="list-table">

        <?php foreach( $lista as $noticia ):?>

            <tr>
                <td><?php echo $noticia['noticia_titulo']?></td>
                <td>
                    <a href="<?php echo $edit_uri . $noticia['noticia_id']?>">
                        Editar
                    </a>

                    <a href="<?php echo $delete_uri . $noticia['noticia_id']?>">
                        Apagar
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</div> <!-- .wrap -->

Este view faz todo o sistema de CRUD das notícias utilizando as ações do nosso model.

/views/noticias/noticias-view.php
Veja agora como apresentaremos os dados para o usuário final (este é o view da ação index):

noticias-view.php
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
<?php
// Evita acesso direto a este arquivo
if ( ! defined('ABSPATH')) exit;
?>

<div class="wrap">

    <?php
    // Número de posts por página
    $modelo->posts_por_pagina = 10;

    // Lista notícias
    $lista = $modelo->listar_noticias();
    ?>

    <?php foreach( $lista as $noticia ):?>

        <!-- Título -->
        <h1>
            <a href="<?php echo HOME_URI?>/noticias/index/<?php echo $noticia['noticia_id']?>">
                <?php echo $noticia['noticia_titulo']?>
            </a>
        </h1>

        <?php
        // Verifica se estamos visualizando uma única notícia
        if ( is_numeric( chk_array( $modelo->parametros, 0 ) ) ): // single
            ?>

            <p>
                <?php echo $modelo->inverte_data( $noticia['noticia_data'] );?> |
                <?php echo $noticia['noticia_autor'];?>
            </p>

            <p>
                <img src="<?php
                echo HOME_URI . '/views/_uploads/' . $noticia['noticia_imagem']; ?>">
            </p>

            <?php echo $noticia['noticia_texto'];?>

        <?php endif;  // single ?>

    <?php endforeach; ?>

    <?php $modelo->paginacao();?>

</div> <!-- .wrap -->