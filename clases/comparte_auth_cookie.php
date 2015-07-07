<?php
require_once('../compartidos/clases/HMAC.php');

class Comparte_Auth_Cookie
{
	public static function CreaCookies($origen, $app, $usuario, $password, $tabla)
	{
		$username = strtolower($origen->User->Name);
		$address = $origen->Request->UserHostAddress;
		$sql = "SELECT $password FROM $tabla WHERE $usuario = :usuario";
		$command = $origen->dbConexion->createCommand($sql);
		$command->bindValue(":usuario", $username);
		$token = $command->queryScalar();
		$data = array($username, $address, $token);
		$data = serialize($data);
		$data = $origen->Application->SecurityManager->hashData($data);
		$mun_cookie = new THttpCookie("user_$app", $data);
		$origen->Response->Cookies[] = $mun_cookie;
		$hash_cookie = new THttpCookie("hash_$app", $origen->Application->SecurityManager->ValidationKey);
		$origen->Response->Cookies[] = $hash_cookie;
	}

	public static function CreaUsuario($origen, $app, $usuario, $password, $tabla) //$this, "dbmunioax", "login", "password", "gencatusuario"
	{
		if($origen->Request->Cookies["user_$app"] != null)
		{
			$data = $origen->Request->Cookies["user_$app"]->Value;
			$origen->Application->SecurityManager->ValidationKey =
					$origen->Request->Cookies["hash_$app"]->Value;

			if(($data = $origen->Application->SecurityManager->validateData($data)) !== false)
			{
				$data = unserialize($data);
				if(is_array($data) && count($data) === 3)
				{
					list($username, $address, $token) = $data;
					$sql = "SELECT $password FROM $tabla WHERE $usuario = :usuario";
					$command = $origen->dbConexion->createCommand($sql);
					$command->bindValue(":usuario", $username);
					$resultado = $command->query();
					if($row = $resultado->read())
						if($token === $row["$password"] && $token !== false && $address =
								$origen->Request->UserHostAddress)
						{
							$phphmac = new Crypt_HMAC($_SESSION["aleat"]);
							$password_c = $phphmac->hash($row["$password"]);
					        $authManager=$origen->Application->getModule('auth');
							$x = $authManager->login($username, $password_c, 3600);
						}
				}
			}
		}
	}

	public static function BorraCookies($origen, $app)
	{
		if($origen->Request->Cookies["user_$app"] != null)
		{
			$cookie = new THttpCookie("user_$app", "");
			$cookie->Expire = time() - 1;
			$origen->Response->Cookies->Add($cookie);
		}
		if($origen->Request->Cookies["hash_$app"] != null)
		{
			$cookie = new THttpCookie("user_$app", "");
			$cookie->Expire = time() - 1;
			$origen->Response->Cookies->Add($cookie);
		}
	}
}
?>