function populate_meta_fields() {
  console.log('populate');
  if (typeof populatemeta == "undefined") return;

    var dboptions = populatemeta.array;
    console.log(populatemeta.array);
    for (var i in dboptions) {
      if (dboptions.hasOwnProperty(i) && typeof i !== "function") {
        try {
          var hasOption = document
            .getElementById(i)
            .children[1].querySelector('option[value="' + dboptions[i] + '"]');
          if (
            hasOption ||
            document.getElementById(i).children[1].tagName == "INPUT"
          )
            document.getElementById(i).children[1].value = dboptions[i];
        } catch (e) {
          console.log(e);
        }
      }
    }
  
}
populate_meta_fields();

var x, i, j, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");

  var jj = 1;
  if (typeof populatemeta == "undefined") jj = 0;

  for (j = jj; j < selElmnt.length; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function (e) {
      /* When an item is clicked, update the original select box,
        and the selected item: */
      var y, i, k, s, h;
      s = this.parentNode.parentNode.getElementsByTagName("select")[0];
      h = this.parentNode.parentNode.getElementsByClassName("select-selected")[0];
      for (i = 0; i < s.length; i++) {
        if (s.options[i].innerHTML == this.innerHTML) {
          s.selectedIndex = i;
          h.innerHTML = this.innerHTML;
          y = this.parentNode.getElementsByClassName("same-as-selected");
          for (k = 0; k < y.length; k++) {
            y[k].removeAttribute("class");
          }
          this.setAttribute("class", "same-as-selected");
          break;
        }
      }
      h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function (e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");

    if(['querycity','addlocality-name','locality-name'].includes(this.parentElement.id)) {

      var sels = this.parentElement.getElementsByClassName('select-selected');
      if(sels.length == 1) {
        var inp = document.createElement('input');
        inp.setAttribute('class', 'select-selected');
        inp.setAttribute('autocomplete','chrome-off');
        $(sels[0]).after(inp);
      }
      sels = this.parentElement.getElementsByClassName('select-selected');

      sels[0].style.display = 'none';
      sels[1].style.display = 'block';
      sels[1].focus();
      sels[1].addEventListener('input',function(ee){

          ee.stopPropagation();
          var txt = this.value;
          $(sels[1].nextSibling.childNodes).show();
          $(sels[1].nextSibling.childNodes).each(function() {
            if(!this.innerHTML.includes(txt)) $(this).hide();

            if(this.innerHTML == txt) sels[0].innerHTML = txt;
          });
      })
    }
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x,
    y,
    i,
    arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i);
    } else {
      y[i].classList.remove("select-arrow-active");
      y[i].style.display = 'block';
      $(".select-items div").show();
      if(y[i].nextSibling.classList.contains('select-selected')) {     
      y[i].nextSibling.remove();
      }
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
