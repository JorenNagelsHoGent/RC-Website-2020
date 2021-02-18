function reveal(cl) {
  let menuContent = document.querySelector('.' + cl);

  if (menuContent.style.display === "") {
    menuContent.style.display = "block";
  } else {
    menuContent.style.display = "";
  }


}

function navbar(id, classname) {
  var x = document.getElementById(id);
  if (x.className === classname) {
    x.className += " responsive";
    if (window.innerWidth < 900 && id === "teams-menu") {
      document.getElementById("contact").style.marginTop = "10rem";
    }
  } else {
    x.className = classname;
    if (window.innerWidth < 900 && id === "teams-menu") {
      document.getElementById("contact").style.marginTop = "2rem";
    }
  }

}