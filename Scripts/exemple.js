function ChampSimple(){
    document.getElementById("formulaire").reset();
    document.getElementById("NomFeuilleDeDonnees").value ="Projet exemple";

    document.getElementById("NomTable0").value ="Table exemple 0";

    document.getElementById("NombreDeLigne0").value ="1000";
    document.getElementById("NombreDeLigne0").onchange();

    document.getElementById("SEED0").value ="0413221995";
    document.getElementById("SEED0").onchange();

    document.getElementById("CSV0").checked="true";

    document.getElementById("tab0label0").value ="Prenom";
    document.getElementById("tab0label0").onchange();

    document.getElementById("tab0TypeDeDonnees0").value = "Dictionnaire";
    GestionOptionTDD(0,0);
    document.getElementById("tab0Dictionnaire0").value = "Prenoms"

    addRow(0);

    document.getElementById("tab0label1").value ="Noms";
    document.getElementById("tab0label1").onchange();

    document.getElementById("tab0TypeDeDonnees1").value = "Dictionnaire";
    GestionOptionTDD(0,1);
    document.getElementById("tab0Dictionnaire1").value = "noms"

    addRow(0);

    document.getElementById("tab0label2").value ="Age";
    document.getElementById("tab0label2").onchange();

    document.getElementById("tab0TypeDeDonnees2").value = "Numerique";
    GestionOptionTDD(0,2);

    document.getElementById("tab0Min2").value = "18";
    document.getElementById("tab0Max2").onchange();

    document.getElementById("tab0Max2").value = "80";
    document.getElementById("tab0Max2").onchange();

    document.getElementById("tab0LesNull2").value = "1%";
    document.getElementById("tab0LesNull2").onchange();
}
function ChampMultiTables(){
    document.getElementById("formulaire").reset();
    document.getElementById("NomFeuilleDeDonnees").value ="Projet exemple";

    document.getElementById("NomTable0").value ="Table exemple 1";

    document.getElementById("NombreDeLigne0").value ="1000";

    document.getElementById("SEED0").value ="0413221995";

    document.getElementById("CSV0").checked="true";

    document.getElementById("tab0label0").value ="Prenom";

    document.getElementById("tab0TypeDeDonnees0").value = "Dictionnaire";
    GestionOptionTDD(0,0);
    document.getElementById("tab0Dictionnaire0").value = "Prenoms"

    addRow(0);

    document.getElementById("tab0label1").value ="Noms";

    document.getElementById("tab0TypeDeDonnees1").value = "Dictionnaire";
    GestionOptionTDD(0,1);
    document.getElementById("tab0Dictionnaire1").value = "noms";

    addRow(0);

    document.getElementById("tab0label2").value ="Age";

    document.getElementById("tab0TypeDeDonnees2").value = "Numerique";
    GestionOptionTDD(0,2);

    document.getElementById("tab0Min2").value = "18";

    document.getElementById("tab0Max2").value = "80";

    document.getElementById("tab0LesNull2").value = "1%";

    addTable();

    document.getElementById("NomTable1").value ="Table exemple 2";

    document.getElementById("NombreDeLigne1").value ="20000";

    document.getElementById("SEED1").value ="959595";

    document.getElementById("SQL1").checked="true";
    document.getElementById("XML1").checked="true";

    document.getElementById("tab1label0").value ="Prenom";

    document.getElementById("tab1TypeDeDonnees0").value = "Dictionnaire";
    GestionOptionTDD(1,0);
    document.getElementById("tab1Dictionnaire0").value = "Prenoms"

    addRow(1);

    document.getElementById("tab1label1").value ="Noms";

    document.getElementById("tab1TypeDeDonnees1").value = "Dictionnaire";
    GestionOptionTDD(1,1);
    document.getElementById("tab1Dictionnaire1").value = "noms"

    addRow(1);

    document.getElementById("tab1label2").value ="notes";

    document.getElementById("tab1TypeDeDonnees2").value = "Numerique";
    GestionOptionTDD(1,2);

    document.getElementById("tab1Min2").value = "0";

    document.getElementById("tab1Max2").value = "20";

}
function ChampFormule(){

    document.getElementById("formulaire").reset();
    document.getElementById("NomFeuilleDeDonnees").value ="Projet exemple";

    document.getElementById("NomTable0").value ="Table exemple 1";

    document.getElementById("NombreDeLigne0").value ="1000";

    document.getElementById("SEED0").value ="0413221995";

    document.getElementById("CSV0").checked="true";

    document.getElementById("tab0label0").value ="Celsius";

    document.getElementById("tab0TypeDeDonnees0").value = "Numerique";
    GestionOptionTDD(0,0);

    document.getElementById("tab0Min0").value = "0";

    document.getElementById("tab0Max0").value = "100";

    addRow(0);

    document.getElementById("tab0label1").value ="Temperatures en Fahrenheit";

    document.getElementById("tab0TypeDeDonnees1").value = "Formule";
    GestionOptionTDD(0,1);

    document.getElementById("tab0AFormule1").value = "Celsius";

    document.getElementById("tab0XFormule1").value = "1.8   ";

    document.getElementById("tab0SelectOp1").value = "+";

    document.getElementById("tab0BFormule1").value = "32";
}
function Codage() {
    document.getElementById("formulaire").reset();
    document.getElementById("NomFeuilleDeDonnees").value ="Projet exemple";

    document.getElementById("NomTable0").value ="Table exemple 0";

    document.getElementById("NombreDeLigne0").value ="1000";
    document.getElementById("NombreDeLigne0").onchange();

    document.getElementById("SEED0").value ="0413221995";
    document.getElementById("SEED0").onchange();

    document.getElementById("CSV0").checked="true";

    document.getElementById("tab0label0").value ="Prenom";
    document.getElementById("tab0label0").onchange();

    document.getElementById("tab0TypeDeDonnees0").value = "Dictionnaire";
    GestionOptionTDD(0,0);
    document.getElementById("tab0Dictionnaire0").value = "Prenoms"

    addRow(0);

    document.getElementById("tab0label1").value ="Noms";
    document.getElementById("tab0label1").onchange();

    document.getElementById("tab0TypeDeDonnees1").value = "Dictionnaire";
    GestionOptionTDD(0,1);
    document.getElementById("tab0Dictionnaire1").value = "noms"

    addRow(0);

    document.getElementById("tab0label2").value ="Main";
    document.getElementById("tab0label2").onchange();

    document.getElementById("tab0TypeDeDonnees2").value = "Numerique";
    GestionOptionTDD(0,2);

    document.getElementById("tab0ModeDeGeneration2").value = "Codage";
    GestionOptionMDG(0,2);

    document.getElementById("tab0Min2").value = "1";
    document.getElementById("tab0Max2").onchange();

    document.getElementById("tab0Max2").value = "2";
    document.getElementById("tab0Max2").onchange();

    document.getElementById("tab0CodageForm2").value = "1;Droitier;2;Gaucher";
}
function DonneeCoherente() {
    document.getElementById("formulaire").reset();
    document.getElementById("NomFeuilleDeDonnees").value ="Projet exemple";

    document.getElementById("NomTable0").value ="Table exemple 0";

    document.getElementById("NombreDeLigne0").value ="1000";
    document.getElementById("NombreDeLigne0").onchange();

    document.getElementById("SEED0").value ="0413221995";
    document.getElementById("SEED0").onchange();

    document.getElementById("CSV0").checked="true";

    document.getElementById("tab0label0").value ="Prenom";
    document.getElementById("tab0label0").onchange();

    document.getElementById("tab0TypeDeDonnees0").value = "Dictionnaire";
    GestionOptionTDD(0,0);
    document.getElementById("tab0Dictionnaire0").value = "Prenoms"
    champMultiple(0,0);
    document.getElementById("tab0SelectDependance0").value = "True";

    addRow(0);

    document.getElementById("tab0label1").value ="Noms";
    document.getElementById("tab0label1").onchange();

    document.getElementById("tab0TypeDeDonnees1").value = "Dictionnaire";
    GestionOptionTDD(0,1);
    document.getElementById("tab0Dictionnaire1").value = "noms";

    addRow(0);

    document.getElementById("tab0label2").value ="Ville actuelle";
    document.getElementById("tab0label2").onchange();

    document.getElementById("tab0TypeDeDonnees2").value = "Dictionnaire";
    GestionOptionTDD(0,2);
    document.getElementById("tab0Dictionnaire2").value = "villes";
    champMultiple(0,2);
    document.getElementById("tab0SelectDependance2").value = "True";

}