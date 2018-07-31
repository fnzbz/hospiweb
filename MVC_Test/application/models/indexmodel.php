<?php
	class IndexModel
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

		public function getUserIndexData($id)
		{
			$sql = "SELECT u.utilizator, u.sex, u.isMedic, a.avatarName FROM utilizatori u LEFT JOIN avatars a ON (u.id = a.accountID) WHERE u.id = :id";
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));

			return $query->fetchAll();
		}
	}