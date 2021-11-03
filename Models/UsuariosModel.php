<?php

// este archivo se comunica con mysql.php para obtener los metodos


class UsuariosModel extends Mysql
{
    private $intIdUsuario;
    private $strIdentificacion;
    private $strNombresUsuario;
    private $strApellidosUsuario;
    private $strTelefonoUsuario;
    private $strEmailUsuario;
    private $strPasswordUsuario;
    private $strRfc;
    private $strDireccionFiscalUsuario;
    private $strTokenUsuario;
    private $intTipoUsuario;
    private $intEstado;


    public function __construct()
    {

        parent::__construct();
    }

    public function insertUsuario(string $identificacion, string $nombresUsuario, string $apellidosUsuario, string $telefonoUsuario, string $emailUsuario, string $passwordUsuario, int $tipoUsuario, int $estadoUsuario)
    {

        $this->strIdentificacion = $identificacion;
        $this->strNombresUsuario = $nombresUsuario;
        $this->strApellidosUsuario = $apellidosUsuario;
        $this->strTelefonoUsuario = $telefonoUsuario;
        $this->strEmailUsuario = $emailUsuario;
        $this->strPasswordUsuario = $passwordUsuario;

        $this->intTipoUsuario = $tipoUsuario;
        $this->intEstado = $estadoUsuario;
        $return = 0;

        // Consulta

        $sql = "SELECT * FROM persona WHERE email_persona = '{$this->strEmailUsuario}' or identificacion_persona = '{$this->strIdentificacion}'";
        $request = $this->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_insert = "INSERT INTO persona (identificacion_persona, nombres, apellidos, telefono_persona, email_persona, password_persona, rol_id, status_persona) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->strIdentificacion,
                $this->strNombresUsuario,
                $this->strApellidosUsuario,
                $this->strTelefonoUsuario,
                $this->strEmailUsuario,
                $this->strPasswordUsuario,
                $this->intTipoUsuario,
                $this->intEstado
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

    public function selectUsuarios()
    {
        $admin = "";
        if ($_SESSION['idUsuario'] != 1) {
            $admin = " and p.id_persona != 1";
        }
        $sql = "SELECT p.id_persona, p.identificacion_persona, p.nombres, p.apellidos, p.telefono_persona, p.email_persona, p.password_persona, r.id_rol, r.nombre_rol, p.status_persona
        FROM persona p INNER JOIN rol r ON p.rol_id = r.id_rol
        WHERE p.status_persona !=0" . $admin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectUsuario(int $idPersona)
    {
        $this->intIdUsuario = $idPersona;
        $sql = "SELECT p.id_persona, p.identificacion_persona, p.nombres, p.apellidos, p.telefono_persona, p.email_persona, r.id_rol, r.nombre_rol, p.status_persona,
       DATE_FORMAT(p.date_created, '%d-%m-%Y') as fechaRegistro
        FROM persona p INNER JOIN rol r ON p.rol_id = r.id_rol
        WHERE p.id_persona = $this->intIdUsuario";
        // echo $sql; exit;
        $request = $this->select($sql);
        return $request;
    }

    public function updateUsuario(int $idUsuario, string $identificacion, string $nombresUsuario, string $apellidosUsuario, string $telefonoUsuario, string $emailUsuario, string $passwordUsuario, int $tipoUsuario, int $estadoUsuario)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombresUsuario = $nombresUsuario;
        $this->strApellidosUsuario = $apellidosUsuario;
        $this->strTelefonoUsuario = $telefonoUsuario;
        $this->strEmailUsuario = $emailUsuario;
        $this->strPasswordUsuario = $passwordUsuario;
        $this->intTipoUsuario = $tipoUsuario;
        $this->intEstado = $estadoUsuario;

        // Validacion para identificacion e email existentes

        $sql = "SELECT * FROM persona WHERE (email_persona = '{$this->strEmailUsuario}' AND id_persona != $this->intIdUsuario)
        OR (identificacion_persona = '{$this->strIdentificacion}' AND id_persona != $this->intIdUsuario)";

        $request = $this->select_all($sql);

        // Valdiacion: si no trae registro se procede a actualizar
        if (empty($request)) {
            // Validacion: si el pass que recibimos es diferente de vacio, entonces, seactualiza el pass
            if ($this->strPasswordUsuario != "") {
                $sql = "UPDATE persona SET identificacion_persona =?, nombres=?, apellidos=?, telefono_persona=?, email_persona=?, password_persona=?, rol_id=?, status_persona=?
                WHERE id_persona = $this->intIdUsuario";
                $arrData = array(
                    $this->strIdentificacion,
                    $this->strNombresUsuario,
                    $this->strApellidosUsuario,
                    $this->strTelefonoUsuario,
                    $this->strEmailUsuario,
                    $this->strPasswordUsuario,
                    $this->intTipoUsuario,
                    $this->intEstado
                );
            } else {
                $sql = "UPDATE persona SET identificacion_persona=?, nombres=?, apellidos=?, telefono_persona=?, email_persona=?, rol_id=?, status_persona=?
                WHERE id_persona = $this->intIdUsuario";
                $arrData = array(
                    $this->strIdentificacion,
                    $this->strNombresUsuario,
                    $this->strApellidosUsuario,
                    $this->strTelefonoUsuario,
                    $this->strEmailUsuario,
                    $this->intTipoUsuario,
                    $this->intEstado
                );
            }
            $request = $this->update($sql, $arrData);
        } else {

            $request = "exist";
        }
        return $request;
    }


    public function deleteUsuario(int $idPersona)
    {
        $this->intIdUsuario = $idPersona;
        $sql = "UPDATE persona SET status_persona = ? WHERE id_persona = $this->intIdUsuario";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }


    public function updatePeril(int $idUsuario, string $nombresUsuario, string $apellidosUsuario, string $telefonoUsuario, string $passwordUsuario)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strNombresUsuario = $nombresUsuario;
        $this->strApellidosUsuario = $apellidosUsuario;
        $this->strTelefonoUsuario = $telefonoUsuario;
        $this->strPasswordUsuario = $passwordUsuario;

        // validacion si la contraseña no esta vacia
        if ($this->strPasswordUsuario != "") {
            $sql = "UPDATE persona SET nombres=?, apellidos=?, telefono_persona=?, password_persona=?
                    WHERE id_persona = $this->intIdUsuario";

            $arrData = array(
                $this->strNombresUsuario,
                $this->strApellidosUsuario,
                $this->strTelefonoUsuario,
                $this->strPasswordUsuario
            );
        }else{
            $sql = "UPDATE persona SET nombres=?, apellidos=?, telefono_persona=?
                    WHERE id_persona = $this->intIdUsuario";

            $arrData = array(
                $this->strNombresUsuario,
                $this->strApellidosUsuario,
                $this->strTelefonoUsuario,
            
            );
        }
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function updateDatosFiscales(int $idUsuario, string $rfc, string $direccionFiscalUsuario)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strRfc = $rfc;
        $this->strDireccionFiscalUsuario = $direccionFiscalUsuario;

       $sql ="UPDATE persona SET rfc_persona=?, direccion_fiscal =? WHERE id_persona = $this->intIdUsuario";
       $arrData = array($this->strRfc,
                        $this->strDireccionFiscalUsuario);
       
       $request = $this->update($sql, $arrData);
       return $request;
    }
}
