<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 16.01.2013 19:04:53
 */

/**
 * @orm:Entity(Networking)
 */
class NetworkingEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="Networking")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="Networking")
     */
    protected $Titulo;

    /**
     * @var string
     * @assert NotBlank(groups="Networking")
     */
    protected $IdUsuario;

    /**
     * @var string
     * @assert NotBlank(groups="Networking")
     */
    protected $Url;

    /**
     * @var integer
     * @assert NotBlank(groups="Networking")
     */
    protected $NumeroTweets = '0';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="Networking")
     */
    protected $ConAvatar = '0';

    /**
     * @var string
     */
    protected $Mensaje;

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'Networking';

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

    public function setTitulo($Titulo) {
        $this->Titulo = trim($Titulo);
    }

    public function getTitulo() {
        return $this->Titulo;
    }

    public function setIdUsuario($IdUsuario) {
        $this->IdUsuario = trim($IdUsuario);
    }

    public function getIdUsuario() {
        return $this->IdUsuario;
    }

    public function setUrl($Url) {
        $this->Url = trim($Url);
    }

    public function getUrl() {
        return $this->Url;
    }

    public function setNumeroTweets($NumeroTweets) {
        $this->NumeroTweets = $NumeroTweets;
    }

    public function getNumeroTweets() {
        return $this->NumeroTweets;
    }

    public function setConAvatar($ConAvatar) {
        $this->ConAvatar = $ConAvatar;
    }

    public function getConAvatar() {
        if (!($this->ConAvatar instanceof ValoresSN))
            $this->ConAvatar = new ValoresSN($this->ConAvatar);
        return $this->ConAvatar;
    }

    public function setMensaje($Mensaje) {
        $this->Mensaje = trim($Mensaje);
    }

    public function getMensaje() {
        return $this->Mensaje;
    }

}

// END class Networking
?>