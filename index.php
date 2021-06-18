<? 
    include("cb.php");
    $grupo = selectAllPessoa();
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <title>CRUD PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
        <div class="container">
            <div class="posicionarCabecalho">
                <h1>Crud-PHP-Difícil </h1>
            </div>
            <div class="centro">
                <a class="btn1 fundo-azulc espaco" href="?_modulo=pessoa&_acao=r">Inserir Pessoa</a><br>
                <a class="btn1 fundo-azulc espaco" href="?_modulo=pessoa&_colunas[]=nome&_colunas[]=sexo&_colunas[]=criadoem&_colunas[]=alteradoem&_pk=idpessoa">Pesquisar Pessoa</a><br>
                <a class="btn1 fundo-azulc espaco" href="?_modulo=empresa&_acao=r">Inserir Empresa</a><br>
                <a class="btn1 fundo-azulc " href="?_modulo=empresas&_colunas[]=idempresa&_colunas[]=empresa&_pk=idempresa">Pesquisar Empresa</a><br> 
            </div>
                    <br>
            <div class="row">

                <?      
                    if(isset($_GET['_acao']) and isset($_GET['_modulo'])){ 
                        
                        /*if($_GET['acao'] == 'u'){     
                        $sql = "SELECT * FROM ".$_GET['_modulo']." WHERE ".$_GET['pk']." = ".$_GET[$_GET['pk']].";";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_array($result);    
                        }*/
                        
                            include_once ("form/".$_GET['_modulo'].".php");
                            
                    }else{
                        include_once ("pesquisa.php");
                    }
                    
                ?>

            </div>

        </div>
            
        </body>

</html>
