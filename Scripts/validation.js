var lockgenerer = 0;
function UnLockGenerer(){
    if(lockgenerer>0){
        lockgenerer--;
    }
    if(lockgenerer >= 0){
        document.getElementById("BoutonEnvois").removeAttribute("disabled");
    }
}
function LockGenerer(){
    if(lockgenerer>=0){
        lockgenerer++;
    }
    if(!(document.getElementById("BoutonEnvois").hasAttribute("disabled"))){
        document.getElementById("BoutonEnvois").setAttribute("disabled","disabled");
    }
}
function ValidationInputProjet(id){
    var inputVal = document.getElementById(id).value;
    var reg = new RegExp("^[a-zA-Z0-9]+([\\sA-Za-z0-9]+)*$");
    if(!(reg.test(inputVal))) {
        LockGenerer();
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).setAttribute("class","form-control inputInvalid");
        document.getElementById(id).setAttribute("title","N'utilisez que des caractères alphanumériques (a-z) ou (0-9) sans commencer par un espace");
    }else{
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).removeAttribute("title");
        document.getElementById(id).setAttribute("class","form-control");
        UnLockGenerer();
        document.getElementById("BoutonEnvois").removeAttribute("title");
    }
}
function ValidationInputParametreTable(NumTab, NomId) {
    var id = NomId + NumTab;
    var inputVal = document.getElementById(id).value;
    if(!(inputVal == null)){
        if (NomId == "SEED" || NomId == "NombreDeLigne") {
            var reg = new RegExp("^[0-9]+([0-9]*)+([\\s0-9]+)*$");//récupère les entier entre 0 et 2147483647 (taille max pour un entier
            if (((!(reg.test(inputVal))) || ((parseInt(inputVal) < 0) || (parseInt(inputVal) > 2147483647))) && (NomId == "SEED")) {
                document.getElementById(id).removeAttribute("class");
                document.getElementById(id).setAttribute("class", "form-control inputInvalid");
                document.getElementById(id).setAttribute("title", "La graine de génération doit être un entier compris entre 0 et 2147483647 sans  commencer par un espace");
                LockGenerer();
            } else if (!(reg.test(inputVal))) {
                document.getElementById(id).removeAttribute("class");
                document.getElementById(id).setAttribute("class", "form-control inputInvalid");
                document.getElementById(id).setAttribute("title", "Veuillez entrer un entier sans espace");
                LockGenerer();
            } else {
                document.getElementById(id).removeAttribute("class");
                document.getElementById(id).removeAttribute("title");
                document.getElementById(id).setAttribute("class", "form-control");
                UnLockGenerer();
                document.getElementById("BoutonEnvois").removeAttribute("title");
            }
        } else {
            var inputVal = document.getElementById(id).value;
            var reg = new RegExp("^[a-zA-Z0-9]+([\\sA-Za-z0-9]+)*$");
            if (!(reg.test(inputVal))) {
                document.getElementById(id).removeAttribute("class");
                document.getElementById(id).setAttribute("class", "form-control inputInvalid");
                document.getElementById(id).setAttribute("title", "N'utilisez que des caractères alphanumériques (a-z) ou (0-9) sans  commencer par un espace");
                LockGenerer();
            } else {
                document.getElementById(id).removeAttribute("class");
                document.getElementById(id).removeAttribute("title");
                document.getElementById(id).setAttribute("class", "form-control");
                document.getElementById("BoutonEnvois").removeAttribute("title");
                UnLockGenerer();
            }
        }
    }
}
function nomLigne(NumTab,NumLigne){
    var id = "tab"+NumTab+"label"+NumLigne;
    var inputVal = document.getElementById(id).value;
    var reg = new RegExp("^[a-zA-Z0-9]+([\\sA-Za-z0-9]+)*$");
    if(!(reg.test(inputVal))) {
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).setAttribute("class","form-control inputInvalid");
        document.getElementById(id).setAttribute("title","N'utilisez que des caractères alphanumériques (a-z) ou (0-9) sans commencer par un espace");
        LockGenerer();
    }else{
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).removeAttribute("title");
        document.getElementById(id).setAttribute("class","form-control");
        document.getElementById("BoutonEnvois").removeAttribute("title");
        UnLockGenerer();
    }
}
function numLigne(NumTab,NumLigne,nomid){
    var id = "tab"+NumTab+nomid+NumLigne;
    var inputVal = document.getElementById(id).value;
    var reg = /^[0-9]+([,.][0-9]+)*$/;
    if(!(reg.test(inputVal))) {
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).setAttribute("class","form-control inputInvalid");
        document.getElementById(id).setAttribute("title","N'utilisez que des caractères numériques (0-9) ou \".\"/\",\"  sans espace ");
        LockGenerer();
    }else{
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).removeAttribute("title");
        document.getElementById(id).setAttribute("class","form-control");
        document.getElementById("BoutonEnvois").removeAttribute("title");
        UnLockGenerer();
    }
}

function nullLigne(NumTab,NumLigne){
    var id = "tab"+NumTab+"LesNull"+NumLigne;
    var inputVal = document.getElementById(id).value;
    var re = /^((0|[1-9]\d?)(\.\d{1,2})?|100(\.00?)?)\%$/;
    var reg = /^[0-9]+([,.][0-9]+)*$/;
    if(!((re.test(inputVal))||(reg.test(inputVal)))||(parseInt(document.getElementById("NombreDeLigne"+NumTab).value)+1<=parseInt(inputVal))) {
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).setAttribute("class","form-control inputInvalid");
        document.getElementById(id).setAttribute("title","N'utilisez que des caractères numériques (0-9) ou \".\"/\"%\" exemple 10 ou 100%.\nle nombre de valeur null (hors %) doit être inférieur au nombre de ligne.");
        LockGenerer();
    }else{
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).removeAttribute("title");
        document.getElementById(id).setAttribute("class","form-control");
        document.getElementById("BoutonEnvois").removeAttribute("title");
        UnLockGenerer();
    }
}

function ValidationFormule(numTab,numLigne,nomId){
    var id = "tab"+numTab+nomId+numLigne;
    var inputVal = document.getElementById(id).value;
    var reg = /^[0-9]+([,.][0-9]+)*$/;
    // alert(LabelLigneExist(numTab, inputVal));
    if(!(reg.test(inputVal))&&(!(LabelLigneExist(numTab, inputVal)))){
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).setAttribute("class","form-control inputInvalid");
        document.getElementById(id).setAttribute("title","N'utilisez que des caractères numériques (0-9) ou \".\"/\",\" \nsi vous entrez le nom d'une ligne respectez la casse");
        LockGenerer();
    }else{
        document.getElementById(id).removeAttribute("class");
        document.getElementById(id).removeAttribute("title");
        document.getElementById(id).setAttribute("class","form-control");
        document.getElementById("BoutonEnvois").removeAttribute("title");
            UnLockGenerer();
    }
}
function LabelLigneExist(numTab, inputVal){
    var i =0;
    while(i<=TabIndex[numTab]){
        if(inputVal == document.getElementById("tab"+numTab+"label"+i).value){
            return true;
        }
        i++;
    }
    return false;
}

function validationEnvoi(){
    var mustfilled = document.getElementsByClassName("required");
    var dontSend = true;
    for (var i = 0; i < mustfilled.length; i++) {
        if(mustfilled[i].value ==""){
            dontSend = false;
            var id = mustfilled[i].getAttribute("id");
            document.getElementById(id).removeAttribute("class");
            document.getElementById(id).setAttribute("class", "form-control inputInvalid required");
            document.getElementById(id).setAttribute("title", "Veuillez remplir ce champ");
            LockGenerer();
        }
    }
    if(dontSend){
       return true;
    }
    else
        return false;
}

function ValidationTableReference(NumTabl,Numligne){

    var tableReference = document.getElementById("tab"+NumTabl+"TableReference"+Numligne);
    var valeurTableReference = tableReference.value; // On récupère la valeur du input

    // Puis on va comparer cette valeur avec le nom de toutes les tables voir si ça correspond

    var tableFound = -1; // Par défaut on va considérer que la table nommé "xxxxxxx" existe pas

    for(var i = 0; i < TabIndex.length && tableFound == -1; i++){

        var nomTable = document.getElementById("NomTable"+i).value;
        if(valeurTableReference == nomTable && valeurTableReference != ""){
            tableFound = i;
        }

    }

    if(tableFound == -1){
        tableReference.removeAttribute("class");
        tableReference.setAttribute("class","form-control inputInvalid");
        tableReference.setAttribute("title", "Vous tentez de faire réference à une table qui n'existe pas");
        LockGenerer();
    }else{
        tableReference.removeAttribute("class");
        tableReference.removeAttribute("title");
        tableReference.setAttribute("class","form-control");
        tableReference.removeAttribute("title");
        UnLockGenerer();
    }

    return tableFound;
    
}

function ValidationColonneReference(NumTabl,Numligne){

    var colonneReference = document.getElementById("tab"+NumTabl+"ColonneReference"+Numligne);
    var valeurColonneReference = colonneReference.value; // On récupère la valeur du input
    var colonneFound = false;

    var tableReference = ValidationTableReference(NumTabl, Numligne);

    if(tableReference > -1){

        for(var i = 0; i < TabIndex[tableReference] + 1 && !colonneFound; i++){

            var nomColonne = document.getElementById("tab"+tableReference+"label"+i).value;
            if(valeurColonneReference == nomColonne && valeurColonneReference != ""){
                colonneFound = true;
            }

        }

    }

    if(!colonneFound){
        colonneReference.removeAttribute("class");
        colonneReference.setAttribute("class","form-control inputInvalid");
        colonneReference.setAttribute("title", "Vous tentez de faire réference à une colonne introuvable");
        LockGenerer();
    }else{
        colonneReference.removeAttribute("class");
        colonneReference.removeAttribute("title");
        colonneReference.setAttribute("class","form-control");
        colonneReference.removeAttribute("title");
        UnLockGenerer();
    }

}




