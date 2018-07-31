<?php
	class UserModel
	{
		function __construct($db)
		{
			try
			{
				$this->db = $db;
			}
			catch(PDOException $e) 
			{
            	exit('Database connection could not be established.');
			}
		}

		public function getUserData($data, $table, $field, $id)
		{
			$sql = "SELECT ". $data ." FROM ". $table ." WHERE ". $field ." = :id";
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));

			return $query->fetchAll();
		}
	}