<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanPermisos)
 */
class CpanPermisosEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="CpanPermisos")
	 */
	protected $Id;
	/**
	 * @var entities\CpanPerfiles
	 * @assert NotBlank(groups="CpanPermisos")
	 */
	protected $IdPerfil;
	/**
	 * @var entities\CpanModulos
	 * @assert NotBlank(groups="CpanPermisos")
	 */
	protected $NombreModulo;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanPermisos")
	 */
	protected $Funcionalidades;
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = 'regantes';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'CpanPermisos';
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
			'CpanPerfiles',
			'CpanModulos',
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
	public function setId($Id){
		$this->Id = $Id;
	}
	public function getId(){
		return $this->Id;
	}

	public function setIdPerfil($IdPerfil){
		$this->IdPerfil = $IdPerfil;
	}
	public function getIdPerfil(){
		if (!($this->IdPerfil instanceof CpanPerfiles))
			$this->IdPerfil = new CpanPerfiles($this->IdPerfil);
		return $this->IdPerfil;
	}

	public function setNombreModulo($NombreModulo){
		$this->NombreModulo = trim($NombreModulo);
	}
	public function getNombreModulo(){
		if (!($this->NombreModulo instanceof CpanModulos))
			$this->NombreModulo = new CpanModulos($this->NombreModulo);
		return $this->NombreModulo;
	}

	public function setFuncionalidades($Funcionalidades){
		$this->Funcionalidades = trim($Funcionalidades);
	}
	public function getFuncionalidades(){
		return $this->Funcionalidades;
	}

} // END class CpanPermisos

?>