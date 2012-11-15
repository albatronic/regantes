<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanEtiquetas)
 */
class CpanEtiquetasEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="CpanEtiquetas")
	 */
	protected $Id;
	/**
	 * @var entities\CpanModulos
	 * @assert NotBlank(groups="CpanEtiquetas")
	 */
	protected $IdModulo;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanEtiquetas")
	 */
	protected $Etiqueta;
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = 'regantes';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'CpanEtiquetas';
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

	public function setIdModulo($IdModulo){
		$this->IdModulo = $IdModulo;
	}
	public function getIdModulo(){
		if (!($this->IdModulo instanceof CpanModulos))
			$this->IdModulo = new CpanModulos($this->IdModulo);
		return $this->IdModulo;
	}

	public function setEtiqueta($Etiqueta){
		$this->Etiqueta = trim($Etiqueta);
	}
	public function getEtiqueta(){
		return $this->Etiqueta;
	}

} // END class CpanEtiquetas

?>