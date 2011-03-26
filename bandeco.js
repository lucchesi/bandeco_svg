	// Inicializando o svgDocument
	function init(evt) {
		if ( window.svgDocument == null )
			svgDocument = evt.target.ownerDocument;
	}
	
	// Variaveis do JSONP(global)
	var JSONP;
	
	// Pegar a entrada do JSONP
	function bandeco(dados)
	{
		JSONP = dados;
	}
	
	function mudatexto(text, evt)
	{
		svgDocument.getElementById("texto").firstChild.data = text;
	}
	
	
	
	function suco(evt)
	{
		mudatexto(JSONP.suco);
		//svgDocument.getElementById("suco").setAttributeNS(null,"fill","99ccff");
	}
	
	function prato(evt)
	{
		mudatexto(JSONP.prato);
	}
