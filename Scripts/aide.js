function aide(onOff) {
  if (onOff==1) {
     window.document.getElementById('aide').setAttribute('class','row')
     window.document.getElementById('BoutonAide').innerHTML="Masquer l'aide"
     window.document.getElementById('BoutonAide').setAttribute('onclick','aide(0)  ; return false')
  } else {
     window.document.getElementById('aide').setAttribute('class','row pasvu')
     window.document.getElementById('BoutonAide').innerHTML="Afficher l'aide"
     window.document.getElementById('BoutonAide').setAttribute('onclick','aide(1) ; return false')
  } // fin si
  return(false)
} // fin de fonction aide
