        function isName(name) {
        var reDate = /\b([A-Z]{1}[a-z]{1,30}[- ]{0,1}|[A-Z]{1}[- \']{1}[A-Z]{0,1}[a-z]{1,30}[- ]{0,1}|[a-z]{1,2}[ -\']{1}[A-Z]{1}[a-z]{1,30}){2,5}/;
        return reDate.test(name);
    }
        function isPhone(phone) {
        var reTime = /^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/;
        return reTime.test(phone);
    }
    
        function isMail(mail) {
        var reMail = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return reMail.test(mail);
                
    }
    
        function isNumeric(numeric) {
        var reNumeric = /^[0-9]+$/;
        return reNumeric.test(numeric);
                
    }
    
        function isPassword(password) {    
        var rePassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/ ;
        return rePassword.test(password);
    }
    
        function searchDoctorByName() {
          var input, filter, listaDoctori, doctor, numeDoctor, i;
          input = document.getElementById("searchDoctorByName");
          filter = input.value.toUpperCase();
          listaDoctori = document.getElementById("listaDoctori");
          doctor = listaDoctori.getElementsByClassName("doctor");
          for (i = 0; i < doctor.length; i++) {
            numeDoctor = doctor[i].getElementsByClassName("numeDoctor")[0];
            if (numeDoctor) {
              if (numeDoctor.innerHTML.toUpperCase().indexOf(filter) > -1) {
                doctor[i].style.display = "";
              } else {
                doctor[i].style.display = "none";
              }
            }       
          }
        }
        
        function searchDoctorByTelephone() {
          var input, filter, listaDoctori, doctor, telDoctor, i;
          input = document.getElementById("searchDoctorByTelephone");
          filter = input.value.toUpperCase();
          listaDoctori = document.getElementById("listaDoctori");
          doctor = listaDoctori.getElementsByClassName("doctor");
          for (i = 0; i < doctor.length; i++) {
            telDoctor = doctor[i].getElementsByClassName("telDoctor")[0];
            if (telDoctor) {
              if (telDoctor.innerHTML.toUpperCase().indexOf(filter) > -1) {
                doctor[i].style.display = "";
              } else {
                doctor[i].style.display = "none";
              }
            }       
          }
        }

        function searchTransplantByName() {
          var input, filter, table, tr, td, i;
          input = document.getElementById("searchTransplantByName");
          filter = input.value.toUpperCase();
          table = document.getElementById("Transplanturi");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("NameTrans")[0];
            if (td) {
              if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }       
          }
        }
        
        function searchTransplantByGS() {
          var input, filter, table, tr, td, i;
          input = document.getElementById("searchTransplantByGS");
          filter = input.value.toUpperCase();
          table = document.getElementById("Transplanturi");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByClassName("GSTrans")[0];
            if (td) {
              if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }       
          }
        }
        
        function searchPacientByName() {
          var input, filter, table, tr, td, i;
          input = document.getElementById("searchPacientByName");
          filter = input.value.toUpperCase();
          table = document.getElementById("Pacienti");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
              if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }       
          }
        }