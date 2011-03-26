<?
	// Pega a página
	$options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );
	$ch = curl_init("http://www.prefeitura.unicamp.br/busca_cardapio.php?pagina=1");
	curl_setopt_array( $ch, $options );
	$pagina = curl_exec($ch);
	curl_close($ch);
	
	// Mata o html
	$pagina = strip_tags($pagina, "<script><th><br>");
	$pagina = preg_replace("%<th>%", "", $pagina);
	$pagina = preg_replace("%</th>%", "<br />", $pagina);
	$pagina = preg_replace("%\t%", "", $pagina);
	$pagina = preg_replace("%^\n%", "", $pagina);
	$pagina = preg_replace("%<script .*script>%", "", $pagina);
	
	// Mata as linhas em branco
	$pagina = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $pagina);
	
	
	function JSONP($suco, $prato, $sobremesa, $salada, $pts)
	{
		echo("bandeco({" . 
		     "suco: \"" . $suco . "\", " . 
		     "prato: \"" . $prato . "\", " . 
		     "sobremesa: \"" . $sobremesa . "\", " . 
		     "salada: \"" . $salada . "\", " . 
		     "pts: \"" . $pts . "\"" . 
		     "})\n");
	}
	
	function pegavar($string, $pagina)
	{
		preg_match("%" . $string . ".*<%", $pagina, $var);
		$var = explode($string, $var[0]);
		$var = explode("\n", $var[1]);
		$var = explode("<", $var[0]);
		return $var[0];
	}

	// Pega os valores
	$suco = pegavar("SUCO: ", $pagina);
	$prato = pegavar("PRATO PRINCIPAL: ", $pagina);
	$sobremesa = pegavar("SOBREMESA: ", $pagina);
	$salada = pegavar("SALADA: ", $pagina);
	$pts = pegavar("PTS ", $pagina);
	
	
	// imprime o JSONP
	JSONP($suco, $prato, $sobremesa, $salada, $pts);
?>
