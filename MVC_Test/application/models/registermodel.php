<?php

	Class RegisterModel
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

		public function checkUser($cnp)
		{
			$sql = "SELECT COUNT(id) AS counter FROM utilizatori WHERE CNP = :cnp";
			$query = $this->db->prepare($sql);
			$query->execute(array(':cnp' => $cnp));

			$data = $query->fetchAll();
			return $data[0]->counter;
		}

		public function insertUser($data)
		{
			$sql = "INSERT INTO utilizatori (mail, utilizator, CNP, password, telefon, sex, sange, nascut, judet) VALUES (:mail, :utilizator, :cnp, :password, :phone, :sex, :sange,:nascut, :judet)";
			$query = $this->db->prepare($sql);
			$query->execute($data);
		}
	}