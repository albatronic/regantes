<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 02.01.2013 17:48:05
 */

/**
 * @orm:Entity(EtiqRelaciones)
 */
class EtiqRelacionesEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="EtiqRelaciones")
     */
    protected $Id;

    /**
     * @var entities\CpanModulos
     * @assert NotBlank(groups="EtiqRelaciones")
     */
    protected $IdModulo;

    /**
     * @var integer
     * @assert NotBlank(groups="EtiqRelaciones")
     */
    protected $IdEntidad = '0';

    /**
     * @var entities\EtiqEtiquetas
     * @assert NotBlank(groups="EtiqRelaciones")
     */
    protected $IdEtiqueta;

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'EtiqRelaciones';

    /**
     * Nombre de la PrimaryKey
     * @var string
     */
    protected $_primaryKeyName = 'Id';

    /**
     * Relacion de entidades que dependen de esta
     * @var string
     */
    protected $_parentEntities = array(
    );

    /**
     * Relacion de entidades de las que esta depende
     * @var string
     */
    protected $_childEntities = array(
        'CpanModulos',
        'EtiqEtiquetas',
        'ValoresSN',
        'ValoresPrivacy',
        'ValoresDchaIzq',
        'ValoresChangeFreq',
        'RequestMethods',
        'RequestOrigins',
        'CpanAplicaciones',
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getId() {
        return $this->Id;
    }

    public function setIdModulo($IdModulo) {
        $this->IdModulo = $IdModulo;
    }

    public function getIdModulo() {
        if (!($this->IdModulo instanceof CpanModulos))
            $this->IdModulo = new CpanModulos($this->IdModulo);
        return $this->IdModulo;
    }

    public function setIdEntidad($IdEntidad) {
        $this->IdEntidad = $IdEntidad;
    }

    public function getIdEntidad() {
        return $this->IdEntidad;
    }

    public function setIdEtiqueta($IdEtiqueta) {
        $this->IdEtiqueta = $IdEtiqueta;
    }

    public function getIdEtiqueta() {
        if (!($this->IdEtiqueta instanceof EtiqEtiquetas))
            $this->IdEtiqueta = new EtiqEtiquetas($this->IdEtiqueta);
        return $this->IdEtiqueta;
    }

}

// END class EtiqRelaciones
?>