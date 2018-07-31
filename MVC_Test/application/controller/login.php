<?php
	class Login extends Controller
	{
		public function index()
		{
			$errorPage = 0;
			$CSRF = '';
			if(isset($_SESSION['key']))
				$CSRF = hash_hmac('sha256', 'platformahospiwebcastigainfoeducatie', $_SESSION['key']);
			require 'application/views/login.php';
		}

		public function checkLogin()
		{

		}

		public function registerSucess()
		{
			$sucessPage = 1;
			$this->index();
		}
	}