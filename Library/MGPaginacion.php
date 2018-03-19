<?php
/**
 * @author Miglio Esaud <mig1098@hotmail.com>
 * @role php web developer
 * @version 1.0.0
 * @copyright 2018
 */
class MGPaginacion{
    /**
     * 
     * */
    public $url = '';
    /**
     * variable a enviar en la url query string
     * */
    public $prefijo = '?p=';
    /**
     * Cantidad total de registros
     * */
    public $totalRegistros;
    /**
     * Cantidad de registros a mostrar por pagina
     * */
    public $porPagina;
    /**
     * Numero de pagina actual
     * */
    public $paginaActual=1;
    /**
     * $totalRegistros/$porPagina
     * */
    private $paginas;
    /**
     * empezar conteo desde un numero especifico
     * */
    private $mostrarDesde;
    /**
     * continua el conteo hasta un numero especifico
     * */
    private $mostrarHasta;
    /**
     * Aumentar +1 a la pagina actual
     * */
    private $paginaSiguiente;
    /**
     * Disminuir -1 a la pagina actual
     * */
    private $paginaAnterior;
    /**
     * Ultima pagina
     * */
    private $paginaUltima;
    /**
     * texto
     * */
    public $anterior='Anterior';
    /**
     * texto
     * */
    public $siguiente='Siguiente';
    /**
     * mostrar todos los links 
     * @boolean
     * */
    public $todolinks = false;
    /**
     * cantidad de links a mostrar
     * */
    public $limitelinks=10;
    /**
     * variables por metodo GET
     * */
    public $querystrings='';
    /**
     * clase contenedora de la lista
     * @css 
     * */
    public $divcontenedor='mg-contenedor';
    /**
     * clase de la lista
     * */
    public $ulclass='mg-pagination';
    /**
     * Atributos adicionales
     * */
    public $ulattrib='';
    /**
     * Estilos css
     * */
    public $estilos = <<<eot
    <style type="text/css">
        .mg-contenedor{position:relative;height:20px;}
        ul.pag-content{list-style-type:none;margin:0;float:right;}
        ul.pag-content li{float:left;padding:2px 4px;}
    </style>
eot;
    public $mostrarTotalPaginas=true;
    public $mostrarTotalRegistros=true;
    /**
     * singleton
     * */
    private static $instancia;
    //construct
    public function __construct(){
    }
    public static function instancia(){
        if(!self::$instancia){
            self::$instancia = new MGPaginacion();
        }
        return self::$instancia;
    }
    public function procesar(){
        $this->estilos = str_replace('pag-content',$this->ulclass,$this->estilos);
        $this->paginas = ceil($this->totalRegistros / $this->porPagina);
        $this->paginaUltima = $this->paginas;
        $this->paginaAnterior  = (($this->paginaActual - 1) < 1) ? 1 : $this->paginaActual - 1;
        $this->paginaSiguiente = (($this->paginaActual + 1) < $this->paginaUltima) ? $this->paginaActual + 1 : $this->paginaUltima;
        $this->mostrarDesde = ($this->paginaActual - ($this->limitelinks/2)) > 0 ? $this->paginaActual - ($this->limitelinks/2) : 1 ;
        $this->mostrarHasta = ($this->paginaActual + ($this->limitelinks/2)) < $this->paginaUltima ? $this->paginaActual + ($this->limitelinks/2) : $this->paginaUltima ;
    }
    private function htmltodo(&$html){
        for($i=1;$i<=$this->paginas;$i++){
            if($this->paginaActual == $i){
                $html .= '<li><span class="active">'.$i.'</span></li>';
            }else{
                $html .= '<li><a class="btn" href="'.$this->url.$this->prefijo.$i.'&'.$this->querystrings.'">'.$i.'</a></li>';
            }
        }
        return $html;
    }
    private function htmlespec(&$html){
        if($this->paginas<=1){
            return false;
        }
        for($i=$this->mostrarDesde;$i<$this->paginaActual;$i++){
            if($this->paginaActual == $i){
                $html .= '<li><span class="active">'.$i.'</span></li>';
            }else{
                $html .= '<li><a class="btn" href="'.$this->url.$this->prefijo.$i.'&'.$this->querystrings.'">'.$i.'</a></li>';
            }
        }
        for($i=$this->paginaActual;$i<=$this->mostrarHasta;$i++){
            if($this->paginaActual == $i){
                $html .= '<li><span class="active">'.$i.'</span></li>';
            }else{
                $html .= '<li><a class="btn" href="'.$this->url.$this->prefijo.$i.'&'.$this->querystrings.'">'.$i.'</a></li>';
            }
        }
        return $html;
    }
    public function html(){
        $html = '<div class="'.$this->divcontenedor.'">';
        $html .= '<div style="">';
        $html .= '<ul class="'.$this->ulclass.'" '.$this->ulattrib.'>';
        if($this->paginaAnterior < $this->paginaActual){
            $html .= '<li><a href="'.$this->url.$this->prefijo.$this->paginaAnterior.'&'.$this->querystrings.'">'.$this->anterior.'</a></li>';
        }
        if($this->todolinks){
            $this->htmltodo($html);
        }else{
            $this->htmlespec($html);
        }
        if($this->paginaSiguiente > $this->paginaActual){
            $html .= '<li><a href="'.$this->url.$this->prefijo.$this->paginaSiguiente.'&'.$this->querystrings.'">'.$this->siguiente.'</a></li>';
        }
        $html .= '</ul>';
        if($this->mostrarTotalPaginas && $this->mostrarTotalRegistros){
            $txtpag = $this->paginas==1?'pagina':'paginas';
            $txtreg = $this->totalRegistros==1?'registro':'registros';
            $html .= '<small><span>'.$this->paginas.' '.$txtpag.'</span> / <span>'.$this->totalRegistros.' '.$txtreg.'</span></small>';
        }
        $html .= '</div>';
        $html .= '<div style="clear:both;"></div></div>';
        return $html;
    }
    public function mostrar(){
        $this->procesar();
        //var_dump($this->mostrarDesde);
        //var_dump($this->paginas);
        echo $this->estilos;
        echo $this->html();
    }
}
?>
