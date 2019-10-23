<?php
#   # (gH)   -_-  index.php  ;  TimeStamp (unix) : 20 Avril 2017 vers 19:49
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html ; charset= utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>G&eacute;n&eacute;rateur de donn&eacute;es</title>
  <link href="Style/css/bootstrap.min.css" rel="stylesheet" type = "text/css"/>
  <link href="Style/css/style.css" rel="stylesheet" type = "text/css"/>
  <script src="Scripts/aide.js" type="text/javascript"></script>
  <script src="Scripts/GestionForm.js" type="text/javascript"></script>
  <script src="Scripts/exemple.js" type="text/javascript"></script>
  <script src="Scripts/validation.js" type="text/javascript"></script>
  <script src="Scripts/recuperation.js" type="text/javascript"></script>
  <script src="Scripts/jQuery.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload = "GestionImportFichier();">

<div class="col-xs-12 col-sn-12 col-md-12 col-lg-12">
  <!-- a href="Aide.xhtml"  onclick="window.open(this.href);return false;" id="BoutonAide" class="btn btn-lg btn-info">Aide</a -->
  <span onclick="aide(1)" id="BoutonAide" class="btn btn-lg btn-info" style="z-index: 9999">Afficher l'Aide</span>
</div>

<div class="jumbotron">
  <div class ="container">
    <div class="row">
      <div class ="col-xs-2 col-sn-2 col-md-2 col-lg-2">
        <img alt="icone du g&eacute;n&eacute;rateur" src="logo-site.png" height="100" width="100"/>
      </div>
      <div class ="col-xs-10 col-sn-10 col-md-10 col-lg-10"><!--le titre prend 10 colonnes -->
        <h1><span class="titreUDG">G&eacute;n&eacute;rateur <span class="ghRouge"><b>Universel</b> </span> de Donn&eacute;es</span></h1>
      </div>
    </div>
  </div>
</div>

<div class="container"><!-- pour l'aide -->
    <div class="row pasvu" id="aide">
<?php
include("aide.html") ;
?>

    </div>
</div>

<div class="container"><!--d&eacute;but formulaire-->
    <div class="row">
      <div class="col-xs-13 col-sn-13 col-md-13 col-lg-13">
        <div class="titleprghp">
          <span class="prg">Formulaire de g&eacute;n&eacute;ration&nbsp;:&nbsp;</span>
          <button onclick="RAZ();" id="RAZ" class="btn btn-default">Remettre &agrave; z&eacute;ro</button>
        </div>
      </div>
    </div>
    <form id="formulaire" method="post" onsubmit="return validationEnvoi();" action = "Generateur/TraitementsForm.php">
    <!-- Nom de la feuille de donnees -->
    <div class="row">
      <div class="col-xs-12 col-sn-12 col-md-12 col-lg-12">
        <div class="form-horizontal">
          <div class="form-group">
            <label class ="col-xs-2 col-sn-2 col-md-2 col-lg-2" for = "NomFeuilleDeDonnees">Nom du projet :</label>
            <div class = "col-xs-10 col-sn-10 col-md-10 col-lg-10">
              <input type="text" class="form-control required" name="NomProjet" onchange="ValidationInputProjet('NomFeuilleDeDonnees');" id = "NomFeuilleDeDonnees" value =""></input>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--d&eacute;but du formulaire dynamique-->
    <div id="tables">
      <div id="table0" class = "well row table bordFin">
        <div class="row">
          <div class="col-xs-12 col-sn-12 col-md-12 col-lg-12">
            <div class="form-horizontal">
              <div class="form-group DGT">
                <label class ="col-xs-3 col-sn-3 col-md-3 col-lg-3" for = "NomTable0">Nom de la Table&nbsp;:&nbsp;</label>
                <div class = "col-xs-9 col-sn-9 col-md-9 col-lg-9">
                  <input type="text" class="form-control required" id = "NomTable0" onchange="ValidationInputParametreTable(0,'NomTable');" name ="NomTable0" value =""></input>
                </div>
                <label  class ="col-xs-3 col-sn-3 col-md-3 col-lg-3" for = "NombreDeLigne0">Nombre de lignes&nbsp;&nbsp;:</label>
                <div class = "col-xs-9 col-sn-9 col-md-9 col-lg-9">
                    <input type="text" class="form-control required" id ="NombreDeLigne0" onchange="ValidationInputParametreTable(0,'NombreDeLigne');" name="NombreDeLigne0" value =""></input>
                </div>
                <label class ="col-xs-3 col-sn-3 col-md-3 col-lg-3"  for = "SEED0">Graine de g&eacute;n&eacute;ration&nbsp;:&nbsp;</label>
                <div class = "col-xs-9 col-sn-9 col-md-9 col-lg-9">
                  <input type="text" class="form-control" id ="SEED0" onchange="ValidationInputParametreTable(0,'SEED');" name="SEED0" value =""></input>
                </div>
                <label class ="col-xs-3 col-sn-3 col-md-3 col-lg-3">Formats de sortie&nbsp;:&nbsp;</label>
                <label class="formatSortie checkbox-inline" for="CSV0">CSV&nbsp;</label><input type="checkbox" name="CSV0" id="CSV0" value="CSV0"></input>
                <label class="checkbox-inline formatSortie" for="SQL0">SQL&nbsp;</label><input type="checkbox" name="SQL0" id="SQL0" value="SQL0"></input>
                <label class="checkbox-inline formatSortie" for="XML0">XML&nbsp;</label><input type="checkbox" name="XML0" id="XML0" value="XML0"></input>
              </div>
            </div>
          </div>
        </div>
        <div id ="tab0Lignes">
          <div id="tab0Ligne0" class="row col-xs-12 col-sn-12 col-md-12 col-lg-12 form-inline form-group">
            <label for = "tab0label0">&nbsp;Nom&nbsp;:&nbsp;</label>
            <input type="text" class="form-control required" name = "tab0label0" onchange="nomLigne(0,0);" id = "tab0label0" value=""></input>

            <label for="tab0TypeDeDonnees0">&nbsp;Type de Donn&eacute;es&nbsp;:&nbsp;</label>
            <select class="form-control" id="tab0TypeDeDonnees0" name="tab0TypeDeDonnees0" onchange="GestionOptionTDD(0,0);">
              <option class="Defaultab" selected="selected" >Choisissez un type de donn&eacute;es</option>
              <option value = "Dictionnaire" >Dictionnaire</option>
              <option value = "Numerique">Numerique</option>
              <option value = "Formule">Formule</option>
              <option value = "Reference">Reference</option>
            </select>
            <label id="tab0LabelModeDeGeneration0" for="tab0ModeDeGeneration0">&nbsp;Mode de G&eacute;n&eacute;ration&nbsp;:&nbsp;</label>
            <select class="form-control" id="tab0ModeDeGeneration0" disabled ="disabled"  name="tab0ModeDeGeneration0" onchange="GestionOptionMDG(0,0)">
              <option class="Defaultab" selected="selected" >Choisissez un mode</option>
              <option value = "Aleatoire">Al&eacute;atoire (uniforme)</option>
              <option value = "Codage">Loi Normale</option>
              <option value = "LoiNormale">Loi Normale</option>
              <option value = "Sequentielle">S&eacute;quentielle</option>
            </select>
            <br/>
            <label for = "tab0LesNull0">Null&nbsp;:&nbsp;</label>
              <input type="text" class="form-control" name="tab0LesNull0" onchange="nullLigne(0,0);" id = "tab0LesNull0"></input>
            <div id="tab0Minimum0" class="form-group">
            </div>
            <div id ="tab0Maximum0" class="form-group">
            </div>
            <div id="tab0PasSeq0" class="form-group">
            </div>
            <div id="tab0Dico0" class="form-group">
            </div>
            <div id="tab0Formule0" class="form-group">
            </div>
            <div id="tab0Codage0" class="form-group">
            </div>
            <div id="tab0Reference0" class="form-group">
            </div>

          </div>
        </div>

        <div class = "row col-xs-12 col-sn-12 col-md-12 col-lg-12">
          <button type="button" class="col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-success" onclick="addRow(0);">Ajouter une colonne</button>
          <div class="col-xs-6 col-sn-6 col-md-6 col-lg-6"><!--sert a l'espace entre les boutons-->
          </div>
          <button type="button" class="col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-danger" onclick="DelRow(0);">Supprimer une colonne</button>

        </div>
      </div>
    </div>
    <div id="boutons_table" class = "row col-xs-12 col-sn-12 col-md-12 col-lg-12">
      <button type="button" class="col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-success noir orange" onclick="addTable();"><b>Ajouter une Table</b></button>
      <div class="col-xs-6 col-sn-6 col-md-6 col-lg-6"><!--sert a l'espace entre les boutons-->
      </div>
      <button type="button" class="col-xs-3 col-sn-3 col-md-3 col-lg-3 btn btn-lg btn-danger noir orange" onclick="delTable();"><b>Supprimer une Table</b></button>

    </div>
    <div id = "FormatSortie" class = "row col-xs-12 col-sn-12 col-md-12 col-lg-12">
      <div class="panel panel-primary " >
        <div class = "panel-heading">
          <h3 class="panel-title">Entr&eacute;es/Sorties :</h3>
        </div>
        <div class = "panel-body" id="chargementDeFichier">
          <button type="button" class = "btn btn-lg btn-default gris" id="btnOpen"><b>Importer un fichier XML ou SQL</b></button>
          <input type="file" id="AcceptInput" accept=".sql,.xml,.txt"/>
          <a href="Fichiers/Parametre.xml" class = "btn btn-lg btn-default bleu_pastel" id="btnOpen2"><b>exemple de fichier XML</b></a>
          <a href="Fichiers/titanic_mysql_cr.txt" class = "btn btn-lg btn-default bleu_pastel" id="btnOpen3"><b>exemple de fichier SQL</b></a>
          <button type="submit" id="BoutonEnvois" class="btn btn-lg btn-default jaune">G&eacute;n&eacute;rer</button>
        </div>
      </div>
    </div>
    </form>
</div>

<div class="container">
   <div id = "Exemples" class = "col-xs-12 col-sn-12 col-md-12 col-lg-12">
      <div class="panel panel-primary " >
        <div class = "panel-heading">
          <h3 class="panel-title">Exemples :</h3>
        </div>
        <div class = "panel-body">
          <button type="submit" id="ChampsSimpleBtn"   class="btn btn-lg btn-default gris"        onclick="ChampSimple();">Champ simple</button>
          <button type="submit" id="ChampsFormuleBtn"  class="btn btn-lg btn-default btn-ex gris" onclick="ChampFormule();">Formule</button>
          <button type="submit" id="ChampsMultiTabBtn" class="btn btn-lg btn-default btn-ex gris" onclick="ChampMultiTables();">Champs Muti Tables</button>
          <button type="submit" id="CodageBtn"         class="btn btn-lg btn-default btn-ex gris" onclick="Codage();">Codage</button>
          <button type="submit" id="ChampsCoherentBtn" class="btn btn-lg btn-default btn-ex gris" onclick="DonneeCoherente();">Champs Coh&eacute;rents</button>
        </div>
      </div>
    </div>
</div>

<p id="credit">
<em>Created by: Brice HARISMENDY, Corentin COUVRY, Antoine LEGOUBE, Alban BAUMARD, Geoffroy BERRY </em>
<br />
<em>Conceived and maintained by : <a href="../">Gilles HUNAULT</a> University of Angers, 2017.</em>
<br />
&nbsp;
</p>

<blockquote>
<p>
<a href="http://validator.w3.org/check/referer" class="text_decoration_none">Valid XHTML 1.1</a>
</p>
</blockquote>

</body>
</html>
