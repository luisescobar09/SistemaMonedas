<?php 

	class RolesModel extends PostgreSQL
	{
		public $intIdRol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}
        
        public function selectRoles()
        {
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

		public function selectRol(int $id_rol)
		{
			$this->intIdRol = $id_rol;
			$sql = "SELECT * FROM rol WHERE id_rol = $this->intIdRol";
			$request = $this->select($sql);
			return $request;
		}

		public function insertRol(string $rol, string $descripcion, int $status)
		{
			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strRol}' ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$query_insert  = "INSERT INTO rol(nombre_rol,descripcion,status) VALUES(?,?,?)";
				$arrData = array($this->strRol,
								 $this->strDescripcion,
								 $this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
		}

		public function updateRol(int $id_rol, string $rol, string $descripcion, int $status)
		{
			$this->intIdRol = $id_rol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strRol}' AND id_rol != $this->intIdRol";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE rol SET nombre_rol = ?, descripcion = ?, status = ? WHERE id_rol = $this->intIdRol ";
				$arrData = array($this->strRol,
								 $this->strDescripcion,
								 $this->intStatus);
				$request = $this->update($sql,$arrData);
			} else {
				$request = "exist";
			}
			return $request;
		}

		public function deleteRol(int $id_rol)
		{
			$this->intIdRol = $id_rol;
			$sql = "SELECT * FROM usuario WHERE id_rol = $this->intIdRol";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE rol SET status = ? WHERE id_rol = $this->intIdRol ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';
				} else {
					$request = 'error';
				}
			} else {
				$request = 'exist';
			}
			return $request;
		}

	}
 ?>