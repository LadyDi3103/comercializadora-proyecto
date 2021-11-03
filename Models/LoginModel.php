<?php

// este archivo se comunica con mysql.php para obtener los metodos


class LoginModel extends Mysql
{

    // Propiedades
    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;
    private $strToken;

    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

    public function loginUsuario(string $usuario, string $password)
    {
        $this->strUsuario = $usuario;
        $this->strPassword = $password;

        $sql = "SELECT id_persona, status_persona FROM persona WHERE
        email_persona = '$this->strUsuario' and
        password_persona = '$this->strPassword' and
        status_persona != 0";

        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $idUsuario)
    {
        $this->intIdUsuario = $idUsuario;
        $sql = "SELECT p.id_persona,
                  p.identificacion_persona,
                  p.nombres,
                  p.apellidos,
                  p.telefono_persona,
                  p.email_persona,
                  p.rfc_persona,
                  p.direccion_fiscal,
                  r.id_rol,
                  r.nombre_rol,
                  p.status_persona
          FROM persona p
          INNER JOIN rol r
          ON p.rol_id = r.id_rol
          WHERE p.id_persona = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['usuarioData']= $request;
        return $request;
    }

    public function getUsuarioEmail(string $email)
    {
        $this->strUsuario = $email;
        $sql = "SELECT id_persona, nombres, apellidos, status_persona FROM persona WHERE
                 email_persona = '$this->strUsuario' and
                 status_persona = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function setTokenUsuario(int $idPersona, string $token)
    {
        $this->intIdUsuario = $idPersona;
        $this->strToken = $token;
        $sql = "UPDATE persona SET token = ? WHERE id_persona = $this->intIdUsuario";
        $arrData = array($this->strToken);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function getUsuario(string $email, string $token)
    {
        $this->strUsuario = $email;
        $this->strToken = $token;
        $sql = "SELECT id_persona FROM persona WHERE
                email_persona = '$this->strUsuario' and
                token = '$this->strToken' and
                status_persona = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function insertPassword(int $idPersona, string $password)
    {
        $this->intIdUsuario = $idPersona;
        $this->strPassword = $password;
        $sql="UPDATE persona SET password_persona = ?, token = ? WHERE id_persona = $this->intIdUsuario";
        $arrData = array($this->strPassword, "");
        $request= $this->update($sql ,$arrData);
        return $request;
    }
}
