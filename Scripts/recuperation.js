function GestionImportFichier() {

    document.getElementById('btnOpen').onclick = function() {
        if ('FileReader' in window) {
            document.getElementById('AcceptInput').click();
        } else {
            alert('Your browser does not support the HTML5 FileReader.');
        }
    };

    document.getElementById('AcceptInput').onchange = function(event) {
        var fileToLoad = event.target.files[0];
        var reader = new FileReader();
        var parser = new DOMParser();

        if (getExtension(fileToLoad.name) == "txt" || getExtension(fileToLoad.name) == "sql") {

            reader.onload = function (fileLoadedEvent) {

                var textFromFileLoaded = fileLoadedEvent.target.result;


                jQuery.ajax({
                    type: "POST",
                    url: '../Generateur/SQLversXML.php',
                    data: {sqlTexte: textFromFileLoaded},

                    success: function (data) {


                        data = data.substring(data.indexOf("\n", 5));
                        var envoi = data.substring(0,data.indexOf("\n", 5))+data.substring(data.indexOf("\n", 5)+1);




                        envoi=envoi.trim();
                        xmlDoc = parser.parseFromString(envoi, "text/xml");


                        interpreter(xmlDoc);


                    },
                    error: function (msg) {

                        alert("Error !: " + msg);
                    }
                });



            };

        } else if(getExtension(fileToLoad.name) == "xml"){

            reader.onload = function (fileLoadedEvent) {
                var textFromFileLoaded = fileLoadedEvent.target.result;
                // parser = new DOMParser();

                xmlDoc = parser.parseFromString(textFromFileLoaded, "text/xml");

                interpreter(xmlDoc);
            };

        }

        reader.readAsText(fileToLoad, 'UTF-8');
        //  }
    };
}


function interpreter(xmlDoc){
    var i, j, k, l ;
    tables = xmlDoc.getElementsByTagName("Table");
    document.getElementById("NomFeuilleDeDonnees").value = "NomProjet";


    for(i = 0; i < tables.length ; i++){
        if(document.getElementById("table"+i) == null){
            addTable();
        }
        for(l = 0; l < tables[i].children.length; l++){
            if(tables[i].children[l].tagName == "Champs"){
                tabDonnees = tables[i].children[l].children ;
                for(j=0; j < tabDonnees.length; j++) {
                    if (document.getElementById("tab" + i + "Ligne" + j) == null) {
                        addRow(i);
                    }

                    document.getElementById("tab" + i + "label" + j).value = tabDonnees[j].getAttribute("NomColonne");

                    if (tabDonnees[j].getAttribute("Type") != "IMC") {
                        document.getElementById("tab" + i + "TypeDeDonnees" + j).value = tabDonnees[j].getAttribute("Type");
                        GestionOptionTDD(i, j);
                    }
                    switch(tabDonnees[j].getAttribute("Type")){
                        case "Dictionnaire":
                            document.getElementById("tab"+i+"Dictionnaire"+j).value = tabDonnees[j].getAttribute("NomDictionnaire");
                            champMultiple(i,j);
                            if(tabDonnees[j].getAttribute("GenererDependance") == "True"){
                                document.getElementById("tab"+i+"SelectDependance"+j).value = "True" ;
                            }
                            break;
                        case "Numerique":
                            document.getElementById("tab"+i+"Min"+j).value = tabDonnees[j].getAttribute("Min");
                            document.getElementById("tab"+i+"Max"+j).value = tabDonnees[j].getAttribute("Max");
                            break;
                        case "Reference":
                            document.getElementById("tab"+i+"TableReference"+j).value = tabDonnees[j].getAttribute("TableReference");
                            document.getElementById("tab"+i+"ColonneReference"+j).value = tabDonnees[j].getAttribute("ColonneReference");
                            break;
                        case "Formule":
                            var formule = tabDonnees[j].getAttribute("Formule");
                            formuleSplit = formule.split(" ");
                            document.getElementById("tab"+i+"AFormule"+j).value = formuleSplit[0];
                            document.getElementById("tab"+i+"XFormule"+j).value = formuleSplit[1];
                            document.getElementById("tab"+i+"SelectOp"+j).value = formuleSplit[2];
                            document.getElementById("tab"+i+"BFormule"+j).value = formuleSplit[3];

                            break;

                    }

                    if(tabDonnees[j].getAttribute("Null") != null){
                        document.getElementById("tab"+i+"LesNull"+j).value = tabDonnees[j].getAttribute("Null");
                    }

                }

            }

            if(tables[i].children[l].tagName == "Parametre"){
                tabChildParametres = tables[i].children[l].children ;

                for(k=0; k < tabChildParametres.length; k++){
                    switch(tabChildParametres[k].tagName){
                        case "NomTable":
                            document.getElementById("NomTable"+i).value = tabChildParametres[k].getAttribute("nom");
                            break;
                        case "Nbligne":
                            document.getElementById("NombreDeLigne"+i).value = tabChildParametres[k].getAttribute("valeur");
                            break;
                        case "Sortie":
                            if(tabChildParametres[k].getAttribute("XML") == "True"){
                                document.getElementById("XML"+i).checked="true";
                            }
                            if(tabChildParametres[k].getAttribute("CSV") == "True"){
                                document.getElementById("CSV"+i).checked="true";
                            }
                            if(tabChildParametres[k].getAttribute("SQL") == "True"){
                                document.getElementById("SQL"+i).checked="true";
                            }

                            break;
                        case "Seed":
                            document.getElementById("SEED"+i).value = tabChildParametres[k].getAttribute("valeur");
                            break;

                    }


                }
            }

        }

    }

}

function getExtension(filename)
{
    var parts = filename.split(".");
    return (parts[(parts.length-1)]);
}