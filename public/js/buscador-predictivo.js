var articulos = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: '/buscador-predictivo'
    
  });
  
  $('#buscador-predictivo').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'articulos',
    source: articulos
  });
  