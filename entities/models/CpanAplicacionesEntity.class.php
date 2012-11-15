<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanAplicaciones)
 */
class CpanAplicacionesEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="CpanAplicaciones")
	 */
	protected $Id;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanAplicaciones")
	 */
	protected $CodigoApp;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanAplicaciones")
	 */
	protected $NombreApp;
	/**
	 * @var string
	 */
	protected $Descripcion;
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = 'regantes';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'CpanAplicaciones';
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
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanModulos', 'ParentColumn' => 'CodigoApp'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanPerfiles', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanRoles', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanUsuariosTipos', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanEtiquetas', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'GconContenidosEtiquetas', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'GconContenidosRelacionados', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanAplicaciones', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanPermisos', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanUsuarios', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanVariables', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanFuncionalidades', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanModulos', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanUrlAmigables', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'CpanDocs', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'GconContenidos', 'ParentColumn' => 'CodigoAppAsociada'),
			array('SourceColumn' => 'CodigoApp', 'ParentEntity' => 'GconSecciones', 'ParentColumn' => 'CodigoAppAsociada'),
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
	public function setId($Id){
		$this->Id = $Id;
	}
	public function getId(){
		return $this->Id;
	}

	public function setCodigoApp($CodigoApp){
		$this->CodigoApp = trim($CodigoApp);
	}
	public function getCodigoApp(){
		return $this->CodigoApp;
	}

	public function setNombreApp($NombreApp){
		$this->NombreApp = trim($NombreApp);
	}
	public function getNombreApp(){
		return $this->NombreApp;
	}

	public function setDescripcion($Descripcion){
		$this->Descripcion = trim($Descripcion);
	}
	public function getDescripcion(){
		return $this->Descripcion;
	}

} // END class CpanAplicaciones

?>