
var VarNumTab = 0;//permet de connaitre la table dans laquelle on travail
//var TabIndex[VarNumTab] = 0;//permet de connaitre la ligne sur laquelle on travail par table
TabIndex = [];
TabIndex[0]=0;
function GestionOptionTDD(NumTab,Numligne){//gère le formulaire en fonction du type de donnée choisi
  var select = document.getElementById('tab'+NumTab+'TypeDeDonnees'+Numligne);
  var choice = select.selectedIndex ;
  var TypeDeDonnees_choisie = select.options[choice].value;
  switch (TypeDeDonnees_choisie)
  {
    case "Numerique" :
      DelReference(NumTab, Numligne);
      MDGDelOption(NumTab,Numligne);
      DelDictionnaire(NumTab,Numligne);
      delChampMultiple(NumTab,Numligne);
      SupFormule(NumTab, Numligne);
      AjoutMinMax(NumTab,Numligne);
      MDGAleatoire(NumTab,Numligne);
      MDGCodage(NumTab,Numligne);
      //MDGLoiNormale(NumTab,Numligne);
      //MDGSequentielle(NumTab,Numligne);
      document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).removeAttribute("disabled");
        break;
    case "Dictionnaire":
      DelReference(NumTab, Numligne);
      MDGDelOption(NumTab,Numligne);
      supMinMax(NumTab,Numligne);
      //supPasSequentielle(NumTab,Numligne);
      SupFormule(NumTab, Numligne);
      MDGAleatoire(NumTab,Numligne);
      MDGDictionnaire(NumTab,Numligne);
      document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).removeAttribute("disabled");
      document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).value = "Aleatoire"
    break;
      case "Formule" :
      DelReference(NumTab, Numligne);
      MDGDelOption(NumTab,Numligne);
      supMinMax(NumTab,Numligne);
      delChampMultiple(NumTab,Numligne);
      DelDictionnaire(NumTab,Numligne);
      AjoutFormule(NumTab,Numligne);
      //supPasSequentielle(NumTab,Numligne);
    break;
      case "Reference" :
          document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).setAttribute("disabled","disabled");
          document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).value = "Aleatoire"
          SupFormule(NumTab, Numligne);
          supMinMax(NumTab,Numligne);
          supPasSequentielle(NumTab,Numligne);
          delChampMultiple(NumTab,Numligne);
          DelDictionnaire(NumTab,Numligne);
          ajoutReference(NumTab, Numligne);
          break;
        console.log("reference");
    break;
      default :
          DelReference(NumTab, Numligne);
          document.getElementById("tab"+NumTab+"ModeDeGeneration"+Numligne).setAttribute("disabled","disabled");
          SupFormule(NumTab, Numligne);
          supMinMax(NumTab,Numligne);
          supPasSequentielle(NumTab,Numligne);

          delChampMultiple(NumTab,Numligne);
          DelDictionnaire(NumTab,Numligne);
          break;
  }
}
function supPasSequentielle(NumTab,Numligne){//Suprime les ajout de la fonction Numérique
    if((document.getElementById('tab'+NumTab+"PasSeq"+Numligne)) && (document.getElementById('tab'+NumTab+'LabelPas'+Numligne))){
        var parentElement = document.getElementById('tab'+NumTab+"PasSeq"+Numligne);
        var Element = document.getElementById("tab"+NumTab+"LabelPas"+Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab"+NumTab+"Pas"+Numligne);
        parentElement.removeChild(Element);

        // var parentElement = document.getElementById('tab'+NumTab+"PasSeq"+Numligne);
        // var Element = document.getElementById("tab"+NumTab+"Min"+Numligne);
        // parentElement.removeChild(Element);
        // Element = document.getElementById("tab"+NumTab+"LabelMin"+Numligne);
        // parentElement.removeChild(Element);
    }
}
function supMinMax(NumTab,Numligne){//Suprime les ajout de la fonction Numérique
    if((document.getElementById('tab'+NumTab+'Min'+Numligne)) && (document.getElementById('tab'+NumTab+'Max'+Numligne)))
    {
        var parentElement = document.getElementById('tab'+NumTab+"Minimum"+Numligne);
        var Element = document.getElementById("tab"+NumTab+"Min"+Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab"+NumTab+"LabelMin"+Numligne);
        parentElement.removeChild(Element);
        parentElement = document.getElementById("tab"+NumTab+"Maximum"+Numligne);
        Element = document.getElementById("tab"+NumTab+"LabelMax"+Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab"+NumTab+"Max"+Numligne);
        parentElement.removeChild(Element);
    }
}
function SupFormule(NumTab, Numligne) {
    if(document.getElementById("tab" + NumTab + "FormuleLabel" + Numligne)) {
        var parentElement = document.getElementById('tab' + NumTab + "Formule" + Numligne);
        var Element = document.getElementById("tab" + NumTab + "FormuleLabel" + Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab" + NumTab + "AFormule" + Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab" + NumTab + "labelFormule" + Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab" + NumTab + "XFormule" + Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab" + NumTab + "SelectOp" + Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab" + NumTab + "BFormule" + Numligne);
        parentElement.removeChild(Element);
    }
}
function AjoutMinMax(NumTab,Numligne){//Ajoute le nécessaire pour les données numérique
  if(!(document.getElementById('tab'+NumTab+'Min'+Numligne)))
  {
    var div = document.getElementById("tab"+NumTab+"Minimum"+Numligne);

    var minlabel=document.createElement('label');
    minlabel.setAttribute('id',"tab"+NumTab+"LabelMin"+Numligne);
    minlabel.setAttribute('for',"tab"+NumTab+"Min"+Numligne);
    minlabel.innerHTML = " Minimum :";

    var min=document.createElement('input');
    min.setAttribute('type','text');
    min.setAttribute('class','form-control required');
    min.setAttribute('id',"tab"+NumTab+"Min"+Numligne);
    min.setAttribute('onchange',"numLigne("+NumTab+","+Numligne+",\"Min\" );");
    min.setAttribute('name',"tab"+NumTab+"Min"+Numligne);
    min.innerHTML = " ";

    div.appendChild(minlabel);
    div.appendChild(min);
  }

  if(!(document.getElementById('tab'+NumTab+'Max'+Numligne)))
  {
    var div2 = document.getElementById("tab"+NumTab+"Maximum"+Numligne);

    var  maxlabel=document.createElement('label');
    maxlabel.setAttribute('for',"tab"+NumTab+"Max"+Numligne);
    maxlabel.setAttribute('id',"tab"+NumTab+"LabelMax"+Numligne);
    maxlabel.innerHTML = " Maximum :";

    var  max=document.createElement('input');
    max.setAttribute('type','text');
    max.setAttribute('class','form-control required');
    max.setAttribute('id',"tab"+NumTab+"Max"+Numligne);
    max.setAttribute('name',"tab"+NumTab+"Max"+Numligne);
    max.setAttribute('onchange',"numLigne("+NumTab+","+Numligne+",\"Max\");");
      max.innerHTML = " ";

    div2.appendChild(maxlabel);
    div2.appendChild(max);
  }
}
function MDGAleatoire(NumTab,Numligne) {//ajoute le mode de génération aléatoire
  var selectMDG = document.getElementById('tab'+NumTab+"ModeDeGeneration"+Numligne);
  var OptionADD=document.createElement('option');
  OptionADD.setAttribute('value','Aleatoire');
  OptionADD.innerHTML = "Aléatoire (uniforme)";
  selectMDG.appendChild(OptionADD);
}
function MDGSequentielle (NumTab,Numligne) {//ajoute la génération séquentielle
  var selectMDG = document.getElementById('tab'+NumTab+"ModeDeGeneration"+Numligne);

  var OptionADD=document.createElement('option');
  OptionADD.setAttribute('value','sequentielle');
  OptionADD.innerHTML = " Séquentielle";
  selectMDG.appendChild(OptionADD);
}
function MDGCodage(NumTab,Numligne) {
    var selectMDG = document.getElementById('tab'+NumTab+"ModeDeGeneration"+Numligne);

    var OptionADD=document.createElement('option');
    OptionADD.setAttribute('value','Codage');
    OptionADD.innerHTML = "Codage";
    selectMDG.appendChild(OptionADD);
}
function MDGLoiNormale (NumTab,Numligne) {//ajoute la génération par la loi normale
  var selectMDG = document.getElementById('tab'+NumTab+"ModeDeGeneration"+Numligne);

  var OptionADD=document.createElement('option');
  OptionADD.setAttribute('value','LoiNormale');
  OptionADD.innerHTML = " Loi Normale";
  selectMDG.appendChild(OptionADD);
}
function AjoutFormule (NumTabl,Numligne) {//ajoute la génération par formule//-----
    var selectMDG = document.getElementById('tab' + NumTabl + "ModeDeGeneration" + Numligne);
    var OptionADD = document.createElement('option');
    OptionADD.setAttribute("value", "formule");
    OptionADD.innerHTML = "Formule";
    selectMDG.appendChild(OptionADD);
    //------
    var div = document.getElementById("tab" + NumTabl + "Formule" + Numligne);

    var FormuleLabel = document.createElement('label');
    FormuleLabel.setAttribute('id', "tab" + NumTabl + "FormuleLabel" + Numligne);
    FormuleLabel.innerHTML = "&nbsp;Formule&nbsp;:&nbsp;";

    var InputA = document.createElement('input');
    InputA.setAttribute('class', "form-control");
    InputA.setAttribute('type', 'text');
    InputA.setAttribute('id', "tab" + NumTabl + "AFormule" + Numligne);
    InputA.setAttribute('name', "tab" + NumTabl + "AFormule" + Numligne);
    InputA.setAttribute('onchange',"ValidationFormule("+NumTabl+","+Numligne+",\"AFormule\" );");

    //Mise en place de l'interface

    var multiplier = document.createElement('label');
    multiplier.setAttribute('id', "tab" + NumTabl + "labelFormule" + Numligne);
    multiplier.innerHTML = "&nbsp;x&nbsp;";

    var InputX = document.createElement('input');
    InputX.setAttribute('class', "form-control");
    InputX.setAttribute('type', 'text');
    InputX.setAttribute('id', "tab" + NumTabl + "XFormule" + Numligne);
    InputX.setAttribute('name', "tab" + NumTabl + "XFormule" + Numligne);
    InputX.setAttribute('onchange',"ValidationFormule("+NumTabl+","+Numligne+",\"XFormule\" );");

    var SelectOp = document.createElement('select');
    SelectOp.setAttribute('class', "form-control");
    SelectOp.setAttribute('id', "tab" + NumTabl + "SelectOp" + Numligne);
    SelectOp.setAttribute('name', "tab" + NumTabl + "SelectOp" + Numligne);

    var Opt0 = document.createElement('option');
    Opt0.setAttribute('class', "Defaultab");
    Opt0.innerHTML = "Choisissez un opérateur";

    var OptOP0 = document.createElement('option');
    OptOP0.setAttribute('value', "-");
    OptOP0.innerHTML = "&nbsp;-&nbsp;";

    var OptOP1 = document.createElement('option');
    OptOP1.setAttribute('value', "%");
    OptOP1.innerHTML = "&nbsp;%&nbsp;";

    var OptOP2 = document.createElement('option');
    OptOP2.setAttribute('value', "+");
    OptOP2.innerHTML = "&nbsp;+&nbsp;";

    var OptOP3 = document.createElement('option');
    OptOP3.setAttribute('value', "/");
    OptOP3.innerHTML = "&nbsp;/&nbsp;";

    var OptOP4 = document.createElement('option');
    OptOP4.setAttribute('value', "*");
    OptOP4.innerHTML = "&nbsp;*&nbsp;";

    var InputB = document.createElement('input');
    InputB.setAttribute('class', "form-control");
    InputX.setAttribute('type', 'text');
    InputB.setAttribute('id', "tab" + NumTabl + "BFormule" + Numligne);
    InputB.setAttribute('name', "tab" + NumTabl + "BFormule" + Numligne);
    InputB.setAttribute('onchange',"ValidationFormule("+NumTabl+","+Numligne+",\"BFormule\" );");

    div.appendChild(FormuleLabel);
    div.appendChild(InputA);
    div.appendChild(multiplier);
    div.appendChild(InputX);
    div.appendChild(SelectOp);
    SelectOp.appendChild(Opt0);
    SelectOp.appendChild(OptOP0);
    SelectOp.appendChild(OptOP1);
    SelectOp.appendChild(OptOP2);
    SelectOp.appendChild(OptOP3);
    SelectOp.appendChild(OptOP4);
    div.appendChild(InputB);
}
function MDGDictionnaire (NumTabl,Numligne) {//ajoute la génération par dictionnaire
    if(!(document.getElementById('tab'+NumTabl+'Dictionnaire'+Numligne)))
    {
        var div = document.getElementById("tab"+NumTabl+"Dico"+Numligne);
        var  DicoLabel=document.createElement('label');
        DicoLabel.setAttribute('for',"tab"+NumTabl+"Dictionnaire"+Numligne);
        DicoLabel.setAttribute('id',"tab"+NumTabl+"LabelDico"+Numligne);
        DicoLabel.innerHTML = "Dictionnaire :";

        var SelectDico=document.createElement('select');
        SelectDico.setAttribute('class',"form-control");
        SelectDico.setAttribute('id',"tab"+NumTabl+"Dictionnaire"+Numligne);
        SelectDico.setAttribute('name',"tab"+NumTabl+"Dictionnaire"+Numligne);
        SelectDico.setAttribute('onChange', "champMultiple("+NumTabl+","+Numligne+");");


        var OptDico0 = document.createElement('option');
        OptDico0.setAttribute('class',"Defaultab");
        OptDico0.innerHTML="Choisissez un Dictionnaire";

        var OptDico1 = document.createElement('option');
        OptDico1.setAttribute('value',"Prenoms");
        OptDico1.innerHTML=" Prénoms";

        var OptDico2 = document.createElement('option');
        OptDico2.setAttribute('value',"noms");
        OptDico2.innerHTML=" Noms";

        var OptDico3 = document.createElement('option');
        OptDico3.setAttribute('value',"villes");
        OptDico3.innerHTML="Villes";

        var OptDico4 = document.createElement('option');
        OptDico4.setAttribute('value',"titre_film");
        OptDico4.innerHTML="Titres de film";

        var OptDico5 = document.createElement('option');
        OptDico5.setAttribute('value',"acteurs");
        OptDico5.innerHTML="Acteurs";

        var OptDico6 = document.createElement('option');
        OptDico6.setAttribute('value',"langage_informatique");
        OptDico6.innerHTML="Langages Informatique";

        var OptDico7 = document.createElement('option');
        OptDico7.setAttribute('value',"departement");
        OptDico7.innerHTML="Département";

        var OptDico8 = document.createElement('option');
        OptDico8.setAttribute('value',"entreprise_pharma");
        OptDico8.innerHTML="Entreprises pharmaceutique";

        var OptDico9 = document.createElement('option');
        OptDico9.setAttribute('value',"evenements_historiques");
        OptDico9.innerHTML="Evenements Historiques";

        var OptDico10 = document.createElement('option');
        OptDico10.setAttribute('value',"medic");
        OptDico10.innerHTML="Medicaments";

        var OptDico11 = document.createElement('option');
        OptDico11.setAttribute('value',"metiers");
        OptDico11.innerHTML="Métiers";

        var OptDico12 = document.createElement('option');
        OptDico12.setAttribute('value',"molecules");
        OptDico12.innerHTML="Molécules";

        var OptDico13 = document.createElement('option');
        OptDico13.setAttribute('value',"nationalite");
        OptDico13.innerHTML="Nationalitées";

        var OptDico14 = document.createElement('option');
        OptDico14.setAttribute('value',"pays");
        OptDico14.innerHTML="Pays";

        var OptDico15 = document.createElement('option');
        OptDico15.setAttribute('value',"personnages_historiques");
        OptDico15.innerHTML="Personnages Historiques";

        var OptDico16 = document.createElement('option');
        OptDico16.setAttribute('value',"producteurs");
        OptDico16.innerHTML="Producteurs de films";

        var OptDico17 = document.createElement('option');
        OptDico17.setAttribute('value',"realisateur");
        OptDico17.innerHTML="Realisateur";

        var OptDico18 = document.createElement('option');
        OptDico18.setAttribute('value',"regions");
        OptDico18.innerHTML="Régions";

        var OptDico19 = document.createElement('option');
        OptDico19.setAttribute('value',"scenariste");
        OptDico19.innerHTML="Scénariste";

        var OptDico20 = document.createElement('option');
        OptDico20.setAttribute('value',"societe_production");
        OptDico20.innerHTML="Dociétés de production";

        var OptDico21 = document.createElement('option');
        OptDico20.setAttribute('value',"typestrains");
        OptDico20.innerHTML="Types Trains";

        div.appendChild(DicoLabel);
        div.appendChild(SelectDico);
        SelectDico.appendChild(OptDico0);
        SelectDico.appendChild(OptDico1);
        SelectDico.appendChild(OptDico2);
        SelectDico.appendChild(OptDico3);
        SelectDico.appendChild(OptDico4);
        SelectDico.appendChild(OptDico5);
        SelectDico.appendChild(OptDico6);
        SelectDico.appendChild(OptDico7);
        SelectDico.appendChild(OptDico8);
        SelectDico.appendChild(OptDico9);
        SelectDico.appendChild(OptDico10);
        SelectDico.appendChild(OptDico11);
        SelectDico.appendChild(OptDico12);
        SelectDico.appendChild(OptDico13);
        SelectDico.appendChild(OptDico14);
        SelectDico.appendChild(OptDico15);
        SelectDico.appendChild(OptDico16);
        SelectDico.appendChild(OptDico17);
        SelectDico.appendChild(OptDico18);
        SelectDico.appendChild(OptDico19);
        SelectDico.appendChild(OptDico20);
        SelectDico.appendChild(OptDico21);

    }
}
function DelDictionnaire(NumTab,Numligne){
    if(document.getElementById('tab'+NumTab+'Dictionnaire'+Numligne)){
        var parentElement = document.getElementById('tab'+NumTab+"Dictionnaire"+Numligne);
        opts = parentElement.getElementsByTagName('option');
        while(opts[0]) {
            parentElement.removeChild(opts[0]);
        }
        var parentElement = document.getElementById('tab'+NumTab+"Dico"+Numligne);
        var Element = document.getElementById("tab"+NumTab+"Dictionnaire"+Numligne);
        parentElement.removeChild(Element);
        Element = document.getElementById("tab"+NumTab+"LabelDico"+Numligne);
        parentElement.removeChild(Element);
    }
}
function addRow(NumTabl){//ajoute une ligne
    var row = document.getElementById("tab"+NumTabl+"Lignes");
    TabIndex[VarNumTab] = TabIndex[VarNumTab]+1;
    var Div_1=document.createElement('div');
    Div_1.setAttribute('id',"tab"+NumTabl+"Ligne"+TabIndex[VarNumTab]);
    Div_1.setAttribute('class',"row col-xs-12 col-sn-12 col-md-12 col-lg-12 form-inline form-group");

    var LabelND=document.createElement('label');
    LabelND.setAttribute('for',"tab"+NumTabl+"label"+TabIndex[VarNumTab]);
    LabelND.innerHTML = "&nbsp;Nom&nbsp;:&nbsp;";

    var InputNom=document.createElement('input');
    InputNom.setAttribute('type',"text");
    InputNom.setAttribute('class',"form-control required");
    InputNom.setAttribute('name',"tab"+NumTabl+"label"+TabIndex[VarNumTab]);
    InputNom.setAttribute('onchange',"nomLigne("+VarNumTab+","+TabIndex[VarNumTab]+");");
    InputNom.setAttribute('id',"tab"+NumTabl+"label"+TabIndex[VarNumTab]);
    InputNom.innerHTML = " ";

    var LabelTDD=document.createElement('label');
    LabelTDD.setAttribute('for',"tab"+NumTabl+"TypeDeDonnees"+TabIndex[VarNumTab]);
    LabelTDD.innerHTML = "&nbsp;Type de Données&nbsp;:&nbsp;";

    var SelectTDD=document.createElement('select');
    SelectTDD.setAttribute('class',"form-control");
    SelectTDD.setAttribute('id',"tab"+NumTabl+"TypeDeDonnees"+TabIndex[VarNumTab]);
    SelectTDD.setAttribute('name',"tab"+NumTabl+"TypeDeDonnees"+TabIndex[VarNumTab]);
    SelectTDD.setAttribute('onchange',"GestionOptionTDD("+NumTabl+","+TabIndex[VarNumTab]+");");

    var OptTDD0 = document.createElement('option');
    OptTDD0.setAttribute('class',"Defaultab");
    OptTDD0.innerHTML="Choisissez un type de données";

    var OptTDD1 = document.createElement('option');
    OptTDD1.setAttribute('value',"Dictionnaire");
    OptTDD1.innerHTML="Dictionnaire";
    var OptTDD2 = document.createElement('option');
    OptTDD2.setAttribute('value',"Numerique");
    OptTDD2.innerHTML="Numerique";
    var OptTDD3 = document.createElement('option');
    OptTDD3.setAttribute('value',"Formule");
    OptTDD3.innerHTML="Formule";
    var OptTDD4 = document.createElement('option');
    OptTDD4.setAttribute('value',"Reference");
    OptTDD4.innerHTML="Reference";

    var LabelMDG=document.createElement('label');
    LabelMDG.setAttribute('for',"tab"+NumTabl+"ModeDeGeneration"+TabIndex[VarNumTab]);
    LabelMDG.innerHTML = "&nbsp;Mode de Génération&nbsp;:&nbsp;";


    var SelectMDG=document.createElement('select');
    SelectMDG.setAttribute('class',"form-control");
    SelectMDG.setAttribute('disabled',"disabled");
    SelectMDG.setAttribute('id',"tab"+NumTabl+"ModeDeGeneration"+TabIndex[VarNumTab]);
    SelectMDG.setAttribute('name',"tab"+NumTabl+"ModeDeGeneration"+TabIndex[VarNumTab]);
    SelectMDG.setAttribute('onchange',"GestionOptionMDG("+NumTabl+","+TabIndex[VarNumTab]+");");

    var OptMDG0 = document.createElement('option');
    OptMDG0.setAttribute('class',"Defaultab");
    OptMDG0.innerHTML="Choisissez un mode";

    var OptMDG1 = document.createElement('option');
    OptMDG1.setAttribute('value',"Aleatoire");
    OptMDG1.innerHTML=" Aléatoire";
    var OptMDG2 = document.createElement('option');
    OptMDG2.setAttribute('value',"LoiNormale");
    OptMDG2.innerHTML=" Loi normale";
    var OptMDG3 = document.createElement('option');
    OptMDG3.setAttribute('value',"Sequentielle");
    OptMDG3.innerHTML=" Séquentielle";
    var OptMDG4 = document.createElement('option');
    OptMDG4.setAttribute('value',"formule");
    OptMDG4.innerHTML=" formule";

    var OptMDG5 = document.createElement('option');
    OptMDG5.setAttribute('value',"Codage");
    OptMDG5.innerHTML="Codage";

    var br = document.createElement("BR");

    var LabelNull=document.createElement('label');
    LabelNull.setAttribute('for',"tab"+NumTabl+"LesNull"+TabIndex[VarNumTab]);
    LabelNull.innerHTML = "&nbsp;Null&nbsp;:&nbsp;";

    var InputNull=document.createElement('input');
    InputNull.setAttribute('type',"text");
    InputNull.setAttribute('class',"form-control");
    InputNull.setAttribute('name',"tab"+NumTabl+"LesNull"+TabIndex[VarNumTab]);
    InputNull.setAttribute('id',"tab"+NumTabl+"LesNull"+TabIndex[VarNumTab]);
    InputNull.setAttribute('onchange',"nullLigne("+NumTabl+","+TabIndex[VarNumTab]+");");

    InputNull.innerHTML = " ";

    var Div_Min=document.createElement('div');
    Div_Min.setAttribute('id',"tab"+NumTabl+"Minimum"+TabIndex[VarNumTab]);
    Div_Min.setAttribute('class',"form-group");

    var Div_Max=document.createElement('div');
    Div_Max.setAttribute('id',"tab"+NumTabl+"Maximum"+TabIndex[VarNumTab]);
    Div_Max.setAttribute('class',"form-group");

    var Div_Seq=document.createElement('div');
    Div_Seq.setAttribute('id',"tab"+NumTabl+"PasSeq"+TabIndex[VarNumTab]);
    Div_Seq.setAttribute('class',"form-group");

    var Div_Dico=document.createElement('div');
    Div_Dico.setAttribute('id',"tab"+NumTabl+"Dico"+TabIndex[VarNumTab]);
    Div_Dico.setAttribute('class',"form-group");

    var Div_Formule =document.createElement('div');
    Div_Formule.setAttribute('id',"tab"+NumTabl+"Formule"+TabIndex[VarNumTab]);
    Div_Formule.setAttribute('class',"form-group");

    var Div_Codage =document.createElement('div');
    Div_Codage.setAttribute('id',"tab"+NumTabl+"Codage"+TabIndex[VarNumTab]);
    Div_Codage.setAttribute('class',"form-group");

    var Div_Reference =document.createElement('div');
    Div_Reference.setAttribute('id',"tab"+NumTabl+"Reference"+TabIndex[VarNumTab]);
    Div_Reference.setAttribute('class',"form-group");

    row.appendChild(Div_1);
    Div_1.appendChild(LabelND);
    Div_1.appendChild(InputNom);
    Div_1.appendChild(LabelTDD);
    Div_1.appendChild(SelectTDD);
    SelectTDD.appendChild(OptTDD0);
    SelectTDD.appendChild(OptTDD1);
    SelectTDD.appendChild(OptTDD2);
    SelectTDD.appendChild(OptTDD3);
    SelectTDD.appendChild(OptTDD4);
    Div_1.appendChild(LabelMDG);
    Div_1.appendChild(SelectMDG);
    SelectMDG.appendChild(OptMDG0)
    SelectMDG.appendChild(OptMDG1);
    SelectMDG.appendChild(OptMDG2);
    SelectMDG.appendChild(OptMDG3);
    SelectMDG.appendChild(OptMDG4);
    SelectMDG.appendChild(OptMDG5);
    Div_1.appendChild(br);
    Div_1.appendChild(LabelNull);
    Div_1.appendChild(InputNull);
    Div_1.appendChild(Div_Min);
    Div_1.appendChild(Div_Max);
    Div_1.appendChild(Div_Seq);
    Div_1.appendChild(Div_Dico);
    Div_1.appendChild(Div_Formule);
    Div_1.appendChild(Div_Codage);
    Div_1.appendChild(Div_Reference);
}
function DelRow(NumTabl){ //Supprime une ligne
  if(TabIndex[VarNumTab]>0)
  {
    var parentElement = document.getElementById("tab"+NumTabl+"Lignes");
    var Element = document.getElementById("tab"+NumTabl+'Ligne'+TabIndex[VarNumTab]);
    parentElement.removeChild(Element);
    TabIndex[VarNumTab]-=1;
  }
}
function MDGDelOption(NumTab,Numligne){ //supprime tout les mode de génération
  var parentElement = document.getElementById('tab'+NumTab+"ModeDeGeneration"+Numligne);
  opts = parentElement.getElementsByTagName('option');
  while(opts[0]) {
    parentElement.removeChild(opts[0]);
  }
}
function GestionOptionMDG(NumTab,Numligne){//gère le formulaire en fonction du mode de génération choisi
  var selectMDGOption = document.getElementById('tab'+NumTab+'ModeDeGeneration'+Numligne);
  var choiceMDG = selectMDGOption.selectedIndex ;
  var MDG_choisie = selectMDGOption.options[choiceMDG].value;
  switch (MDG_choisie)
  {
    case "sequentielle":
      AjoutMinMax(NumTab,Numligne);
      AjoutPasSequentielle(NumTab,Numligne);
    break;
    case "Aleatoire":
        AjoutMinMax(NumTab,Numligne);
        supPasSequentielle(NumTab,Numligne);
        break;
      case "Codage":
          AjoutMinMax(NumTab,Numligne);
          supPasSequentielle(NumTab,Numligne);
          AjoutCodage(NumTab,Numligne);
          break;
  }
}
function AjoutCodage(NumTab,Numligne) {
    if(!(document.getElementById('tab'+NumTab+'CodageForm'+Numligne)))
    {
        var div = document.getElementById('tab'+NumTab+"Codage"+Numligne);

        var Paslabel=document.createElement('label');
        Paslabel.setAttribute('id','tab'+NumTab+'LabelCodage'+Numligne);
        Paslabel.setAttribute('for','tab'+NumTab+'CodageForm'+Numligne);
        Paslabel.innerHTML = "&nbsp;Codage&nbsp;:&nbsp;";

        var PasS=document.createElement('input');
        PasS.setAttribute('type','text');
        PasS.setAttribute('class','form-control');
        PasS.setAttribute('id','tab'+NumTab+'CodageForm'+Numligne);
        PasS.setAttribute('name','tab'+NumTab+'Codage'+Numligne);
        PasS.innerHTML = " ";

        div.appendChild(Paslabel);
        div.appendChild(PasS);
    }
}
function AjoutPasSequentielle(NumTab,Numligne){
  if(!(document.getElementById('tab'+NumTab+'Pas'+Numligne)))
  {
    var div = document.getElementById('tab'+NumTab+"PasSeq"+Numligne);

    var Paslabel=document.createElement('label');
    Paslabel.setAttribute('id','tab'+NumTab+'LabelPas'+Numligne);
    Paslabel.setAttribute('for','tab'+NumTab+'Pas'+Numligne);
    Paslabel.innerHTML = " Pas :";

    var PasS=document.createElement('input');
    PasS.setAttribute('type','text');
    PasS.setAttribute('class','form-control');
    PasS.setAttribute('id','tab'+NumTab+'Pas'+Numligne);
    PasS.setAttribute('onchange',"numLigne("+NumTab+","+Numligne+",\"Pas\");");
    PasS.setAttribute('name','tab'+NumTab+'Pas'+Numligne);
    PasS.innerHTML = " ";

    div.appendChild(Paslabel);
    div.appendChild(PasS);
  }
}
function addTable(){//ajout d'une table
    VarNumTab+= 1;
    TabIndex[VarNumTab]=0;
    var tabl= document.getElementById("tables");


    var Div_Table = document.createElement('div');
    Div_Table.setAttribute('id',"table"+VarNumTab);
    Div_Table.setAttribute('class',"well row table");

    var Div_DG = document.createElement('div');
    Div_DG.setAttribute('class',"row col-xs-12 col-sn-12 col-md-12 col-lg-12 form-horizontal form-group DGT");

    var LabelNT = document.createElement('label');
    LabelNT.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3");
    LabelNT.setAttribute('for',"NomTable"+VarNumTab);
    LabelNT.innerHTML = "&nbsp;Nom de la Table&nbsp;:&nbsp;";

    var Div_NomTable = document.createElement('div');
    Div_NomTable.setAttribute('class',"col-xs-9 col-sn-9 col-md-9 col-lg-9");

    var InputNomTable = document.createElement('input');
    InputNomTable.setAttribute('type',"text");
    InputNomTable.setAttribute('class',"form-control required");
    InputNomTable.setAttribute('name',"NomTable"+VarNumTab);
    InputNomTable.setAttribute('onchange',"ValidationInputParametreTable("+VarNumTab+",'NomTable');");
    InputNomTable.setAttribute('id',"NomTable"+VarNumTab);
    InputNomTable.innerHTML = " ";

    var LabelNL = document.createElement('label');
    LabelNL.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3");
    LabelNL.setAttribute('for',"NombreDeLigne"+VarNumTab);
    LabelNL.innerHTML = "&nbsp;Nombre de ligne&nbsp;:&nbsp;";

    var Div_NombreLigne = document.createElement('div');
    Div_NombreLigne.setAttribute('class',"col-xs-9 col-sn-9 col-md-9 col-lg-9");

    var InputNombreLigne = document.createElement('input');
    InputNombreLigne.setAttribute('type',"text");
    InputNombreLigne.setAttribute('class',"form-control required");
    InputNombreLigne.setAttribute('onchange',"ValidationInputParametreTable("+VarNumTab+",'NombreDeLigne');");
    InputNombreLigne.setAttribute('name',"NombreDeLigne"+VarNumTab);
    InputNombreLigne.setAttribute('id',"NombreDeLigne"+VarNumTab);
    InputNombreLigne.innerHTML = " ";

    var LabelSEED = document.createElement('label');
    LabelSEED.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3");
    LabelSEED.setAttribute('for',"SEED"+VarNumTab);
    LabelSEED.innerHTML = "&nbsp;Graine de génération&nbsp;:&nbsp;";

    var Div_SEED = document.createElement('div');
    Div_SEED.setAttribute('class',"col-xs-9 col-sn-9 col-md-9 col-lg-9");

    var InputSEED = document.createElement('input');
    InputSEED.setAttribute('type',"text");
    InputSEED.setAttribute('class',"form-control");
    InputSEED.setAttribute('name',"SEED"+VarNumTab);
    InputSEED.setAttribute('onchange',"ValidationInputParametreTable("+VarNumTab+",'SEED');");
    InputSEED.setAttribute('id',"SEED"+VarNumTab);
    InputSEED.innerHTML = " ";

    var LabelFormat = document.createElement('label');
    LabelFormat.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3");
    LabelFormat.innerHTML = " Formats de sortie : ";

    var LabelCSV = document.createElement('label');
    LabelCSV.setAttribute('class',"formatSortie checkbox-inline");
    LabelCSV.setAttribute('for',"CSV"+VarNumTab);
    LabelCSV.innerHTML = " CSV&nbsp;";

    var InputCSV = document.createElement('input');
    InputCSV.setAttribute('type',"text");
    InputCSV.setAttribute('value',"CSV"+VarNumTab);
    InputCSV.setAttribute('name',"CSV"+VarNumTab);
    InputCSV.setAttribute('id',"CSV"+VarNumTab);
    InputCSV.setAttribute('type',"checkbox");
    InputCSV.innerHTML = " ";

    var LabelSQL = document.createElement('label');
    LabelSQL.setAttribute('class',"formatSortie checkbox-inline");
    LabelSQL.setAttribute('for',"SQL"+VarNumTab);
    LabelSQL.innerHTML = " SQL&nbsp;";

    var InputSQL = document.createElement('input');
    InputSQL.setAttribute('type',"text");
    InputSQL.setAttribute('value',"SQL"+VarNumTab);
    InputSQL.setAttribute('name',"SQL"+VarNumTab);
    InputSQL.setAttribute('id',"SQL"+VarNumTab);
    InputSQL.setAttribute('type',"checkbox");
    InputSQL.innerHTML = " ";

    var LabelXML = document.createElement('label');
    LabelXML.setAttribute('class',"formatSortie checkbox-inline");
    LabelXML.setAttribute('for',"XML"+VarNumTab);
    LabelXML.innerHTML = " XML&nbsp;";

    var InputXML = document.createElement('input');
    InputXML.setAttribute('type',"text");
    InputXML.setAttribute('value',"XML"+VarNumTab);
    InputXML.setAttribute('name',"XML"+VarNumTab);
    InputXML.setAttribute('id',"XML"+VarNumTab);
    InputXML.setAttribute('type',"checkbox");
    InputXML.innerHTML = " ";

    var Div_0 = document.createElement('div');
    Div_0.setAttribute('id',"tab"+VarNumTab+"Lignes");
    Div_0.setAttribute('class',"row col-xs-12 col-sn-12 col-md-12 col-lg-12 form-inline form-group");

    var Div_1 = document.createElement('div');
    Div_1.setAttribute('id',"tab"+VarNumTab+"Ligne"+TabIndex[VarNumTab]);
    Div_1.setAttribute('class',"row col-xs-12 col-sn-12 col-md-12 col-lg-12 form-inline form-group");

    var LabelND = document.createElement('label');
    LabelND.setAttribute('for',"tab"+VarNumTab+"label"+TabIndex[VarNumTab]);
    LabelND.innerHTML = "&nbsp;Nom&nbsp;:&nbsp;";

    var InputNom = document.createElement('input');
    InputNom.setAttribute('type',"text");
    InputNom.setAttribute('class',"form-control required");
    InputNom.setAttribute('name',"tab"+VarNumTab+"label"+TabIndex[VarNumTab]);
    InputNom.setAttribute('onchange',"nomLigne("+VarNumTab+","+TabIndex[VarNumTab]+");");
    InputNom.setAttribute('id',"tab"+VarNumTab+"label"+TabIndex[VarNumTab]);
    InputNom.innerHTML = " ";

    var LabelTDD = document.createElement('label');
    LabelTDD.setAttribute('for',"tab"+VarNumTab+"TypeDeDonnees"+TabIndex[VarNumTab]);
    LabelTDD.innerHTML = "&nbsp;Type de Données&nbsp;:&nbsp;";

    var SelectTDD = document.createElement('select');
    SelectTDD.setAttribute('class',"form-control");
    SelectTDD.setAttribute('id',"tab"+VarNumTab+"TypeDeDonnees"+TabIndex[VarNumTab]);
    SelectTDD.setAttribute('name',"tab"+VarNumTab+"TypeDeDonnees"+TabIndex[VarNumTab]);
    SelectTDD.setAttribute('onchange',"GestionOptionTDD("+VarNumTab+","+TabIndex[VarNumTab]+");");

    var OptTDD0 = document.createElement('option');
    OptTDD0.setAttribute('class',"Defaultab");
    OptTDD0.innerHTML="Choisissez un type de données";

    var OptTDD1 = document.createElement('option');
    OptTDD1.setAttribute('value',"Dictionnaire");
    OptTDD1.innerHTML="Dictionnaire";

    var OptTDD2 = document.createElement('option');
    OptTDD2.setAttribute('value',"Numerique");
    OptTDD2.innerHTML="Numerique";

    var OptTDD3 = document.createElement('option');
    OptTDD3.setAttribute('value',"Formule");
    OptTDD3.innerHTML="Formule";

    var OptTDD4 = document.createElement('option');
    OptTDD4.setAttribute('value',"Reference");
    OptTDD4.innerHTML="Reference";

    var LabelMDG=document.createElement('label');
    LabelMDG.setAttribute('for',"tab"+VarNumTab+"ModeDeGeneration"+TabIndex[VarNumTab]);
    LabelMDG.innerHTML = "&nbsp;Mode de Génération&nbsp;:&nbsp;";

    var SelectMDG = document.createElement('select');
    SelectMDG.setAttribute('class',"form-control");
    SelectMDG.setAttribute("disabled","disabled");
    SelectMDG.setAttribute('id',"tab"+VarNumTab+"ModeDeGeneration"+TabIndex[VarNumTab]);
    SelectMDG.setAttribute('name',"tab"+VarNumTab+"ModeDeGeneration"+TabIndex[VarNumTab]);
    SelectMDG.setAttribute('onchange',"GestionOptionMDG("+VarNumTab+","+TabIndex[VarNumTab]+");");
    var OptMDG0 = document.createElement('option');
    OptMDG0.setAttribute('class',"Defaultab");
    OptMDG0.innerHTML="Choisissez un mode   ";
    var OptMDG1 = document.createElement('option');
    OptMDG1.setAttribute('value',"Aleatoire");
    OptMDG1.innerHTML=" Aléatoire";
    var OptMDG2 = document.createElement('option');
    OptMDG2.setAttribute('value',"LoiNormale");
    OptMDG2.innerHTML=" Loi normale";
    var OptMDG3 = document.createElement('option');
    OptMDG3.setAttribute('value',"Sequentielle");
    OptMDG3.innerHTML="Séquentielle";
    var OptMDG4 = document.createElement('option');
    OptMDG4.setAttribute('value',"formule");
    OptMDG4.innerHTML="formule";
    var OptMDG5 = document.createElement('option');
    OptMDG5.setAttribute('value',"Codage");
    OptMDG5.innerHTML="Codage";

    var br = document.createElement("BR");

    var LabelNull = document.createElement('label');
    LabelNull.setAttribute('for',"tab"+VarNumTab+"LesNull"+TabIndex[VarNumTab]);
    LabelNull.innerHTML = "&nbsp;Null&nbsp;:&nbsp;";

    var InputNull = document.createElement('input');
    InputNull.setAttribute('type',"text");
    InputNull.setAttribute('class',"form-control");
    InputNull.setAttribute('name',"tab"+VarNumTab+"LesNull"+TabIndex[VarNumTab]);
    InputNull.setAttribute('id',"tab"+VarNumTab+"LesNull"+TabIndex[VarNumTab]);
    InputNull.setAttribute('onchange',"nullLigne("+VarNumTab+","+TabIndex[VarNumTab]+");");
    InputNull.innerHTML = " ";

    var Div_Min = document.createElement('div');
    Div_Min.setAttribute('id',"tab"+VarNumTab+"Minimum"+TabIndex[VarNumTab]);
    Div_Min.setAttribute('class',"form-group");

    var Div_Max = document.createElement('div');
    Div_Max.setAttribute('id',"tab"+VarNumTab+"Maximum"+TabIndex[VarNumTab]);
    Div_Max.setAttribute('class',"form-group");

    var Div_Seq = document.createElement('div');
    Div_Seq.setAttribute('id',"tab"+VarNumTab+"PasSeq"+TabIndex[VarNumTab]);
    Div_Seq.setAttribute('class',"form-group");

    var Div_Dico=document.createElement('div');
    Div_Dico.setAttribute('id',"tab"+VarNumTab+"Dico"+TabIndex[VarNumTab]);
    Div_Dico.setAttribute('class',"form-group");

    var Div_Formule =document.createElement('div');
    Div_Formule.setAttribute('id',"tab"+VarNumTab+"Formule"+TabIndex[VarNumTab]);
    Div_Formule.setAttribute('class',"form-group");

    var Div_Codage =document.createElement('div');
    Div_Codage.setAttribute('id',"tab"+VarNumTab+"Codage"+TabIndex[VarNumTab]);
    Div_Codage.setAttribute('class',"form-group");

    var Div_Reference =document.createElement('div');
    Div_Reference.setAttribute('id',"tab"+VarNumTab+"Reference"+TabIndex[VarNumTab]);
    Div_Reference.setAttribute('class',"form-group");

    var Div_Btn = document.createElement('div');
    Div_Btn.setAttribute('class',"row col-xs-12 col-sn-12 col-md-12 col-lg-12");


    var Btn_Add_Row = document.createElement('button');
    Btn_Add_Row.setAttribute('type',"button");
    Btn_Add_Row.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-success");
    Btn_Add_Row.setAttribute('onclick',"addRow("+VarNumTab+");");
    Btn_Add_Row.innerHTML="&nbsp;Ajouter une colonne&nbsp;";

    var Div_Space = document.createElement('div');
    Div_Space.setAttribute('class',"col-xs-6 col-sn-6 col-md-6 col-lg-6");

    var Btn_Del_Row = document.createElement('button');
    Btn_Del_Row.setAttribute('type',"button");
    Btn_Del_Row.setAttribute('class',"col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-danger");
    Btn_Del_Row.setAttribute('onclick',"DelRow("+VarNumTab+");");
    Btn_Del_Row.innerHTML="&nbsp;Supprimer une colonne&nbsp;";


    tabl.appendChild(Div_Table);
    Div_Table.appendChild(Div_DG);

    Div_DG.appendChild(LabelNT);
    Div_DG.appendChild(Div_NomTable);
    Div_NomTable.appendChild(InputNomTable);

    Div_DG.appendChild(LabelNL);
    Div_DG.appendChild(Div_NombreLigne);
    Div_NombreLigne.appendChild(InputNombreLigne);

    Div_DG.appendChild(LabelSEED);
    Div_DG.appendChild(Div_SEED);
    Div_SEED.appendChild(InputSEED);

    Div_DG.appendChild(LabelFormat);

    Div_DG.appendChild(LabelCSV);
    Div_DG.appendChild(InputCSV);

    Div_DG.appendChild(LabelSQL);
    Div_DG.appendChild(InputSQL);

    Div_DG.appendChild(LabelXML);
    Div_DG.appendChild(InputXML);

    Div_Table.appendChild(Div_0);
    Div_0.appendChild(Div_1);
    Div_1.appendChild(LabelND);
    Div_1.appendChild(InputNom);
    Div_1.appendChild(LabelTDD);
    Div_1.appendChild(SelectTDD);
    SelectTDD.appendChild(OptTDD0);
    SelectTDD.appendChild(OptTDD1);
    SelectTDD.appendChild(OptTDD2);
    SelectTDD.appendChild(OptTDD3);
    SelectTDD.appendChild(OptTDD4);
    Div_1.appendChild(LabelMDG);
    Div_1.appendChild(SelectMDG);
    SelectMDG.appendChild(OptMDG0);
    SelectMDG.appendChild(OptMDG1);
    SelectMDG.appendChild(OptMDG2);
    SelectMDG.appendChild(OptMDG3);
    SelectMDG.appendChild(OptMDG4);
    SelectMDG.appendChild(OptMDG5);
    Div_1.appendChild(br);
    Div_1.appendChild(LabelNull);
    Div_1.appendChild(InputNull);
    Div_1.appendChild(Div_Min);
    Div_1.appendChild(Div_Max);
    Div_1.appendChild(Div_Seq);
    Div_1.appendChild(Div_Dico);
    Div_1.appendChild(Div_Formule);
    Div_1.appendChild(Div_Codage);
    Div_1.appendChild(Div_Reference);
    Div_Table.appendChild(Div_Btn);
    Div_Btn.appendChild(Btn_Add_Row);
    Div_Btn.appendChild(Div_Space);
    Div_Btn.appendChild(Btn_Del_Row);
}
function delTable(){
    if(VarNumTab>0)
    {
        var parentElement = document.getElementById("tables");
        var Element = document.getElementById('table'+VarNumTab);
        parentElement.removeChild(Element);
        VarNumTab -=1;
        TabIndex.pop();

    }

}
function RAZ() {
    location.reload(true);
}

function champMultiple(NumTabl,Numligne){
    if(document.getElementById('tab'+NumTabl+'Dictionnaire'+Numligne)){
        var sel=document.getElementById('tab'+NumTabl+'Dictionnaire'+Numligne);

        if(sel.value == "villes" || sel.value == "Prenoms") {
            var div = document.getElementById("tab" + NumTabl + "Dico" + Numligne);

            var DependanceLabel = document.createElement('label');
            DependanceLabel.setAttribute('for', "tab" + NumTabl + "SelectDependance" + Numligne);
            DependanceLabel.setAttribute('id', "tab" + NumTabl + "LabelDependance" + Numligne);
            DependanceLabel.innerHTML = "&nbsp; Generer Champs multiple ? :";

            var SelectDependance = document.createElement('select');
            SelectDependance.setAttribute('class', "form-control");
            SelectDependance.setAttribute('id', "tab" + NumTabl + "SelectDependance" + Numligne);
            SelectDependance.setAttribute('name', "tab" + NumTabl + "SelectDependance" + Numligne);
            SelectDependance.setAttribute('title', "Permet de générer des données supplémentaire déduite\n" +
                "du dictionnaire si celui ci gère cette option \n" +
                "par exemple pour le dictionnaire des prénoms\n" +
                "l'on générera une donnée Sexe cohérente\n" +
                "Dans le cas du dictionnaire Ville l'on\n" +
                "génere le code postal");

            var OptDep1 = document.createElement('option');
            OptDep1.setAttribute('value', "False");
            OptDep1.innerHTML = "Non";

            var OptDep2 = document.createElement('option');
            OptDep2.setAttribute('value', "True");
            OptDep2.innerHTML = "Oui";

            if(!document.getElementById("tab" +NumTabl + "LabelDependance" + Numligne)) {

                div.appendChild(DependanceLabel);
                div.appendChild(SelectDependance);

                SelectDependance.appendChild(OptDep1);
                SelectDependance.appendChild(OptDep2);
            }
        } else{
            if(document.getElementById("tab" +NumTabl + "LabelDependance" + Numligne)){
                var el = document.getElementById("tab" +NumTabl + "LabelDependance" + Numligne);
                var el2 = document.getElementById("tab" +NumTabl + "SelectDependance" + Numligne);
                el.parentNode.removeChild(el);
                el2.parentNode.removeChild(el2);

            }
        }
    }

}

function delChampMultiple(NumTabl,Numligne) {
    if(document.getElementById("tab" +NumTabl + "LabelDependance" + Numligne)){
        var el = document.getElementById("tab" +NumTabl + "LabelDependance" + Numligne);
        var el2 = document.getElementById("tab" +NumTabl + "SelectDependance" + Numligne);
        el.parentNode.removeChild(el);
        el2.parentNode.removeChild(el2);

    }
}

function ajoutReference(NumTabl, Numligne){

    var div = document.getElementById("tab" + NumTabl + "Reference" + Numligne);

    var TableReferenceLabel = document.createElement('label');
    TableReferenceLabel.setAttribute('id', "tab" + NumTabl + "TableReferenceLabel" + Numligne);
    TableReferenceLabel.innerHTML = "&nbsp;Table de Reference&nbsp;:&nbsp;";

    var InputTableReference = document.createElement('input');
    InputTableReference.setAttribute('class', "form-control");
    InputTableReference.setAttribute('type', 'text');
    InputTableReference.setAttribute('id', "tab" + NumTabl + "TableReference" + Numligne);
    InputTableReference.setAttribute('name', "tab" + NumTabl + "TableReference" + Numligne);
    InputTableReference.setAttribute('onchange',"ValidationTableReference("+NumTabl+","+Numligne+");");

    var ColonneReferenceLabel = document.createElement('label');
    ColonneReferenceLabel.setAttribute('id', "tab" + NumTabl + "ColonneReferenceLabel" + Numligne);
    ColonneReferenceLabel.innerHTML = "&nbsp;Colonne de Reference&nbsp;:&nbsp;";

    var InputColonneReference = document.createElement('input');
    InputColonneReference.setAttribute('class', "form-control");
    InputColonneReference.setAttribute('type', 'text');
    InputColonneReference.setAttribute('id', "tab" + NumTabl + "ColonneReference" + Numligne);
    InputColonneReference.setAttribute('name', "tab" + NumTabl + "ColonneReference" + Numligne);
    InputColonneReference.setAttribute('onchange',"ValidationColonneReference("+NumTabl+","+Numligne+");");

    div.appendChild(TableReferenceLabel);
    div.appendChild(InputTableReference);
    div.appendChild(ColonneReferenceLabel);
    div.appendChild(InputColonneReference);

}

function DelReference(NumTabl,Numligne){
    if(document.getElementById('tab'+NumTabl+'Reference'+Numligne)){
        var containerReference = document.getElementById('tab'+NumTabl+"Reference"+Numligne);
        while (containerReference.hasChildNodes()) {
          containerReference.removeChild(containerReference.lastChild);
        }
    }
}



