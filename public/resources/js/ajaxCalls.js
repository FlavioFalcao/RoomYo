$(document).ready(function() {

  $('#veranstaltung_form').submit(function()
  {
    // return true um ajax gerade mal zu deaktivieren
     return true;

    var raumid = $('input[name=raumid]').val();
    var vname = $('input[name=name]').val();
    var cct = $("input[name=ci_csrf_token]").val();
    var startdatum = $("input[name=startdatum]").val();
    var enddatum = $("input[name=enddatum]").val();
    var teilnehmer = $("input[name=teilnehmer]").val();
    
    //$('div.errors').animate({"opacity" : "0.0", "left" : "0px"},500);

    $.post('/veranstaltung/buchen/'+raumid, 
        {   "name" : vname, 
            "ci_csrf_token" : cct,
            "startdatum" : startdatum,
            "enddatum" : enddatum,
            "teilnehmer" : teilnehmer
        },
        function(data){
            var jQobj = $(data);
            jQobj.find('div.errors').addClass('hidden_error');
            var resultObj = jQobj.filter('#veranstaltung_form').html();
            
            $('#veranstaltung_form').before(jQobj);
            //$('div.errors').animate({"opacity" : "1.0", "left" : "5px"},1000);
        }
    );
  
    return false;
       
  });


});