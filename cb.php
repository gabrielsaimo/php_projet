<?
foreach ($_POST as $nome_campo => $valor_campo) {
    if($nome_campo == ''){
        unset($nome_campo);
        unset($valor_campo);
    }

   if($nome_campo == "sexo" ){
    
   }

}

    //verifica e define em qual foi recebido
    if($_REQUEST['_modulo'] == 'pessoa'){
        $obj = "(nome,sexo,criadoem,alteradoem,idempresa)";
        $value = "('{$_REQUEST["nome"]}','{$_REQUEST["sexo"]}',sysdate(),sysdate(),'{$_REQUEST["empresa"]}')";
        $modulo = 'pessoa';
    }else{
        $obj = "(empresa)";
        $value ="('{$_REQUEST["empresa"]}')";
        $modulo = 'empresas';
    }
        //verifica se recebe modulo
    if(isset($_REQUEST['_modulo'])){

        //define qual finçao sera realizada 
        if( $_REQUEST['_acao']=="u"){
            $acaoss="UPDATE ";
            alterarPessoa($modulo);
        }
        elseif( $_REQUEST['_acao']=="i"){
            $acaoss="INSERT INTO ";
            inserirPessoa($modulo, $_REQUEST['_acao']);
        }
        elseif( $_REQUEST['_acao']=="d"){
            $acaoss="DELETE FROM ";
            excluirPessoa($modulo);
        }

    }
    //funçao que abre o banco de dados MSQLI
    function abrirBanco() {
        $conexao = new mysqli("localhost", "root", "root", "crud");
        return $conexao;
    }

    function inserirPessoa($modulo, $_acao) {
        global $acaoss;
        global $obj;
        global $value;
        $sql = $acaoss. $modulo. $obj. " VALUES " .$value;
        banco($sql);
        voltarIndex(); 
    }

    function alterarPessoa($modulo) {
        global $acaoss;
        if($_REQUEST['_modulo']=="empresas"){
            $sql = $acaoss." $modulo SET empresa='{$_REQUEST["empresa"]}' WHERE idempresa='{$_REQUEST["idempresa"]}'";
        }else{
            $sql = $acaoss." $modulo SET nome='{$_REQUEST["nome"]}',sexo='{$_REQUEST["sexo"]}',alteradoem=now() WHERE id='{$_REQUEST["id"]}'";
    }
        banco($sql);
        voltarIndex();
    }

    function excluirPessoa($modulo) {
        global $acaoss;
        if($_REQUEST['_acao']=='d' && $_REQUEST['_modulo']=="empresas"){
            $sql = $acaoss. $modulo." WHERE idempresa='{$_REQUEST["id"]}'";
        }else{
            $sql = $acaoss. $modulo." WHERE id='{$_REQUEST["id"]}'";
        }
        banco($sql);
        voltarIndex();
    }

    function selectAllPessoa() {
        $banco = abrirBanco();
        $sql = "SELECT p.id,p.nome,DATE_FORMAT(p.criadoem,'%d/%m/%Y %H:%i:%s') as criadoem,DATE_FORMAT(p.alteradoem,'%d/%m/%Y %H:%i:%s') as alteradoem,p.sexo,e.empresa FROM pessoa p JOIN empresas e on (p.idempresa = e.idempresa) ORDER BY p.nome";
        $resultado = $banco->query($sql) or die ('erro no sql :'.mysqli_error($banco));
        $banco->close();
        while($row = mysqli_fetch_array($resultado)) {
            $grupo[] = $row;
        }
        return $grupo;
    }

    function selectIdPessoa($id) {
        $banco = abrirBanco();
        $sql = "SELECT * FROM pessoa WHERE id=".$id;
        $resultado = $banco->query($sql) or die ('erro no sql :'.mysqli_error($banco));
        $banco->close();
        $pessoa = mysqli_fetch_assoc($resultado);
        return $pessoa;
    }

    function voltarIndex(){
        if($_REQUEST['_modulo']=="pessoa"){
            header("Location:index.php?_modulo=pessoa&_colunas[]=nome&_colunas[]=sexo&_colunas[]=criadoem&_colunas[]=alteradoem");
        }else{
            header("Location:index.php?_modulo=empresas&_colunas[]=idempresa&_colunas[]=empresa");
        }

    }
    //funçao para abrir e fechar o banco de dados
    function banco($sql){
        $banco = abrirBanco();
        $banco->query($sql) or die ('erro no sql :'.mysqli_error($banco));
        $banco->close();
        voltarIndex();
    }

?>