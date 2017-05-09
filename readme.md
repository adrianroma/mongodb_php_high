# mongodb_php_high

Mongo DB PHP High, es una manera de almacenar datos en la base de datos mongodb , 
en forma de grandes listas, ejemplo:

    "es"   es una coleccion que indica que su base es "es" , dentro de esta se encuentra, a que conjunto pertenece "set", que tipo de datos son, "text", que estado se encuentra "state", y los valores y atributos que uno requiera  
       
        "es":{
            "set":"language",
            "type":"text",
            "state":"true"
            "value:":["es:mx","es:ar","es:ve","es:es"]
         },


    asi que para navegar a sus sub colecciones      

    es:mx
    es:ar
    es:ve
    es:es

    seleccionamos ejemplo "es:mx"

          "es:mx":{
            "set":"language",
            "type":"text",
            "state":"true"
            "value:":["es:mx:dictionary","es:mx:synonym"]
         },
       

    Dentro del leguaje que seleccionamos se encuentra un "diccionario"  que tiene las letras y su correspondiente    significado,    

    es:mx:dictionary:arbol
       
         "es:mx:dictionary:arbol":{
            "set":"language",
            "type":"text",
            "state":"true"
            "value:":"tree"
         }

