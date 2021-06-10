class ErrorsManager {
  static createEl(type, message) {
    let el = document.createElement("div");
    el.classList.add("errors_el");

    let close = document.createElement("div");
    close.classList.add("errors_close");
    let content = document.createElement("div");
    content.classList.add("errors_content");

    el.appendChild(close);
    el.appendChild(content);

    close.innerHTML = "X";
    close.setAttribute("onclick", "ErrorsManager.deleteEl(this)");
    if (type == "error") {
      content.innerHTML = message;
      el.classList.add("errors_bad");
    } else if (type == "success") {
      content.innerHTML = message;
      el.classList.add("errors_good");
    }

    document.getElementsByClassName("errors")[0].appendChild(el);
    setTimeout(function (close) {
      ErrorsManager.deleteEl(close);
    }, 10000);

    let exers = document.querySelectorAll('.errors_close');
    if(exers.length > 2) {
      this.deleteEl(exers[0]);
    } else if(window.innerWidth < 1651 && exers.length > 1) {
      this.deleteEl(exers[0]);
    }
  }

  static deleteEl(el) {
    if (typeof el != "undefined" && el != null) el.parentNode.remove();
  }
}
