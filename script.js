/* Insert your javascript here */

function toggleView(x) {
  var element = document.querySelector("#" + x);
  (element.style.display == "none" || element.style.display == "") ? element.style.display = "block" : element.style.display = "none";
}

function toggleMenu() {
  if (document.querySelectorAll(".menu-bar a")[1].style.display == "none" || document.querySelectorAll(".menu-bar a")[1].style.display == "") {
    document.querySelectorAll(".menu-bar a")[1].style.display = "inline-block";
    document.querySelectorAll(".menu-bar a")[2].style.display = "inline-block";
    document.querySelectorAll(".menu-bar a")[3].style.display = "inline-block";
    document.querySelectorAll(".menu-bar a")[4].style.display = "inline-block";
    document.querySelectorAll(".menu-bar a")[5].style.display = "inline-block";
    document.querySelectorAll(".menu-bar a")[0].style.float = "none";
  } else if (document.querySelectorAll(".menu-bar a")[1].style.display == "inline-block") {
    document.querySelectorAll(".menu-bar a")[1].style.display = "none";
    document.querySelectorAll(".menu-bar a")[2].style.display = "none";
    document.querySelectorAll(".menu-bar a")[3].style.display = "none";
    document.querySelectorAll(".menu-bar a")[4].style.display = "none";
    document.querySelectorAll(".menu-bar a")[0].style.float = "left";
  }
}

function storageIsSet(x) {
  if (localStorage.getItem(x) !== null) {
    document.querySelector("#" + x).value = localStorage.getItem(x);
  } else {
    document.querySelector("#" + x).value = "";
  }
}

function toggleStorage() {
  if (localStorage.getItem("name") !== null) {
    localStorage.clear();
    document.querySelector("#name").value = '';
    document.querySelector("#email").value = '';
    document.querySelector("#mobile").value = '';
  }
}

function rememberCheck() {
  if (localStorage.getItem("name") !== null) {
    document.querySelector("#rememberMe").checked = true;
  }
}

function toggleFlip(element) {
  element.classList.toggle('flip');
}