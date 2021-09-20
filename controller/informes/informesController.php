<?php

class informesController {
    
    public function paintInformeDisponibilidadUsuario(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeDisponibilidadModelClass();
    }
    public function paintinformeDisponibilidadUsuarioPDF($dato){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeDisponibilidadPDFModelClass($dato);
    }
        public function paintInformeEstadoMuestras(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeEstadoMuestraModelClass();
    }
        public function paintInformeListadePrecios(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeListadePrecios();
    }
    public function paintInformeGenerarStikers(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeGenerarStiker();
    }
        public function paintInformeGenerarHCPlanta(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeGenerarHCPlanta();
    }
        public function paintInformeGenerarInformePlanta(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeGenerarInformePlanta();
    }
    public function paintInformeEstadistico(){
        $regEstCotizacionModel = new informesModelClass();
        $regEstCotizacionModel->paintInformeEstadistico();
    }
    
}
