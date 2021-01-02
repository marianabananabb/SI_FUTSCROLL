<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jornadas</title>
</head>
<body>
<div>
    <?php
    $str= "dbname=Projeto7 user=postgres password=postgres host=localhost port=5432";
    $conn= pg_connect($str) or die ("Erro na ligação");
    $result= pg_query($conn, "select jornada from jogo group by jornada order by jornada asc");
    $numjornadas= pg_affected_rows($result);
    ?>
</div>
<div>
    <form  method="get" action="Jornadas.php">
        <br>
        <label for="jornadas" > Selecione a jornada para observar os respetivos jogos e resultados: </label>
        <select name="jornada_escolhida" required>
            <?php
            for ($j=0; $j<$numjornadas; $j++){
                $temp_jornada= pg_fetch_array($result);
                $variavelID=$j+1;
                $nomedajornada= $temp_jornada['jornada'];
                print "<option value=\"$variavelID\">$nomedajornada º Jornada </option>";
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Submeter">
    </form>
</div>

<div>
    <?php
    if (isset($_GET['jornada_escolhida'])){
        echo "<br>";
        echo "Jornada escolhida:" . "<br><br>";
        $jornada_esc= $_GET['jornada_escolhida'];
        $result2= pg_query($conn, " select jornada, e1.nome as nome1, e2.nome as nome2, data  from jogo, equipa as e1, equipa as e2 where jogo.id_equipa1=e1.id_equipa and jogo.id_equipa2=e2.id_equipa and jornada=$jornada_esc ;") or die;
        $numlinhas= pg_affected_rows($result2);

        for ($j=0; $j< $numlinhas; $j++){
            $linha= pg_fetch_array($result2);
            print "Equipa ". $linha['nome1'] . " VS Equipa "  . $linha['nome2'] . " | " . $linha['data'];
            print "<br>";
        }

    }
    ?>
</div>

</body>
</html>
