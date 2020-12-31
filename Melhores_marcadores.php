<?php
$str= "dbname=Projeto7 user=postgres password=postgres host=localhost port=5432";
$conn= pg_connect($str) or die ("Erro na ligação");
$result= pg_query($conn, "select j1.nome_jogador, e1.nome as nome_equipa,  count (g1.id_jogador) as numero_de_golos_jogador from golo as g1, jogador as j1 , equipa as e1
where g1.id_jogador = j1.id_jogador and j1.equipa_id_equipa = e1.id_equipa 
group by g1.id_equipa_marc , j1.nome_jogador, e1.nome
order  by numero_de_golos_jogador DESC");
$numjogadores= pg_affected_rows($result);

print "<h1> Melhores 10 Marcadores: </h1>";
for($j=0; $j<10; $j++) {
    $linha = pg_fetch_array($result);
    print "Jogador: " .  $linha['nome_jogador'] . " - Golos Marcados: " . $linha['numero_de_golos_jogador'] . " - Equipa: " . $linha['nome_equipa'] . "<br/>";

}
pg_close($conn);
?>
