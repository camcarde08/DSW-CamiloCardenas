/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function calcularFechaCompromiso(fechaLlegadaActual,prioridadActual){
    
    var fechaCompromiso;
    fechaLlegadaActual = new Date(fechaLlegadaActual);
    if(prioridadActual == 'Normal'){
        
        fechaCompromiso = new Date(sumarDias(fechaLlegadaActual,5));
    }
    if(prioridadActual == 'Urgente'){
        
        fechaCompromiso = new Date(sumarDias(fechaLlegadaActual,3));
    }
    return fechaCompromiso;
}

function sumarDias(fechaInicial, sdias){
    
    
    fechaFinal = new Date(fechaInicial);
    for(i = 0; i < sdias; i++){
        fechaFinal.setDate(fechaFinal.getDate()+1);
        if(fechaFinal.getDay() == 6){
            
            fechaFinal.setDate(fechaFinal.getDate()+2);
        }
        if(fechaFinal.getDay() == 0){
            
            fechaFinal.setDate(fechaFinal.getDate()+1);
        }
    }
     
    return fechaFinal;
}

