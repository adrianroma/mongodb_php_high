/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



document.observe("dom:loaded", function() {
 
  request = window.location.pathname;

  new Ajax.Request('/rest'+request, {
  method:'get',
  onSuccess: function(transport) {
  
    var response = transport.responseText || "no response text";
     
     var obj = JSON.parse(response);
     console.log(obj);
  },
  onFailure: function() { alert('Something went wrong...'); }
   }); 

});
      
     
      
      
      
      