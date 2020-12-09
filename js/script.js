
function reveal(cl) { 
    let menuContent = document.querySelector('.' + cl);

    if(menuContent.style.display===""){
        menuContent.style.display="block";
     } else {
        menuContent.style.display="";
     }


}

window.onclick = function(e) {
    if (!e.target.matches('.teams')) {
      let dropdown = document.getElementsByClassName("teams-menu");
      dropdown.style.display="";
    }
  }