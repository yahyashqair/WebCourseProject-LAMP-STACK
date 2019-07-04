function reg() {
    if (typeof reg.state == 'undefined') {
        reg.state = 1;
    }
    if (reg.state == 1) {
        var elems = document.getElementsByClassName('firststep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'block';
        }
        var elems = document.getElementsByClassName('secondstep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        }
        var elems = document.getElementsByClassName('editstep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        }
        if(validstepone()){
        reg.state = 2;}
    }
    if (reg.state == 2) {
        var elems = document.getElementsByClassName('firststep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        }
        var elems = document.getElementsByClassName('secondstep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'block';
        }
        var elems = document.getElementsByClassName('editstep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'none';
        } 
             reg.state = 3;
    }else if (reg.state == 3){
        if(validsteptwo()){
            reg.state = 4;
        }
    } 
    if (reg.state == 4 ) {
        var elems = document.getElementsByClassName('firststep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'block';
        }
        var elems = document.getElementsByClassName('secondstep');
        for (var i = 0; i < elems.length-1; i += 1) {
            elems[i].style.display = 'block';
        }
        var elems = document.getElementsByClassName('editstep');
        for (var i = 0; i < elems.length; i += 1) {
            elems[i].style.display = 'block';
        }
        document.getElementById('password').style.display = 'none';
            reg.state=5;       
    }
    else if(reg.state==5){
        if(validsteptwo()&&validstepone()){
            reg.state = 6 ;
        }
    }
    if(reg.state == 6 ){
        document.getElementById("form").submit();
    }
}



function validstepone() {
    msg = "";
    var email = document.getElementById('email').value;
    var name = document.getElementById('name').value;
    address = document.getElementById('address').value;
    id = document.getElementById('id').value;
    date = document.getElementById('date');
    fax = document.getElementById('fax').value;
    if (!validateEmail(email)) {
        alert("Email is not valid.");
        return false;
    }
    if (name.length < 5) {
        alert("Name is not valid.  Minimum Chars is 5 "); return false;
    }
    if (address.length < 5) {
        alert("Address is not valid. Minimum Chars is 5 "); return false;
    }
    if( validatedate(date) == false ){return false;};

    if (fax.match(/\d/g)==null||!(fax.match(/\d/g).length === 10)||fax.length==0) {
        alert("Telephone / Fax is not valid. 'it should be 10 digit only.'"); return false;
    }
    if (id.match(/\d/g)==null||!(id.match(/\d/g).length === 10)||id.length==0) {
        alert("ID is not valid. 'it should be 10 digit only.'"); return false;
    }

    return true ;
}


function validsteptwo() {
    var password = document.getElementById('password').value;
    var username = document.getElementById('username').value;
    if(!validatepassword(password)){return false;};
    if (username.length < 6) {
        alert("Username is not valid. Should be more than 5 character");
        return false;
    }
    return true ;

}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function validatepassword(password) {
    if (password.length >= 8 && password.length <= 12 && password[0] >= 'A' && password[0] <= 'Z' && password[password.length - 1] <= '9' && password[password.length - 1] >= '0') {
       return true ;
    } else {
        alert("Password is not valid .. Should be between 8 and 12 charachter and the first Chapetal letter and the least character is digit");
        return false;

    }
}

function validatedate(inputText) {
    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression
    if (inputText.value.match(dateformat)) {
        //Test which seperator is used '/' or '-'
        var opera1 = inputText.value.split('/');
        var opera2 = inputText.value.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1 > 1) {
            var pdate = inputText.value.split('/');
        }
        else if (lopera2 > 1) {
            var pdate = inputText.value.split('-');
        }
        var dd = parseInt(pdate[0]);
        var mm = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (mm == 1 || mm > 2) {
            if (dd > ListofDays[mm - 1]) {
                alert('Invalid date format! Should be dd-mm-yyyy');
                return false;
            }
        }
        if (mm == 2) {
            var lyear = false;
            if ((!(yy % 4) && yy % 100) || !(yy % 400)) {
                lyear = true;
            }
            if ((lyear == false) && (dd >= 29)) {
                alert('Invalid date format! Should be dd-mm-yyyy');
                return false;
            }
            if ((lyear == true) && (dd > 29)) {
                alert('Invalid date format! Should be dd-mm-yyyy ');
                return false;
            }
        }
    }
    else {
        alert("Invalid date format! Should be dd-mm-yyyy");
        return false;
    }
    return true ;
}

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
  
  function bookvalid(){
    check=document.getElementById('confirm');
    card=document.getElementById('cardnum').value;
    if(check.checked==false){
        alert("Please Confirm ");
    }else if((card.match(/\d/g).length != 10)){
        alert("Your Card is Not Valid .. Must be just 10 digits ");
    }else{
        document.getElementById("cardform").submit();
    }
}