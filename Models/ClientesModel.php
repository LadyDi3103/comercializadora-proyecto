<?php

// este archivo se comunica con mysql.php para obtener los metodos


class ClientesModel extends Mysql
{
    private $intIdCliente;
    private $strIdentificacion;
    private $strNombresCliente;
    private $strApellidosCliente;
    private $strTelefonoCliente;
    private $strEmailCliente;
    private $strPasswordCliente;
    private $strRfc;
    private $strDireccionFiscal;
    private $intTipoCliente;






    public function __construct()
    {

        parent::__construct();
    }


   
    public function insertCliente(string $identificacion, string $nombresCliente, string $apellidosCliente, string $telefonoCliente, string $emailCliente, string $passwordCliente, string $rfc, string $direccionFiscal, int $tipoCliente)
    {

        $this->strIdentificacion = $identificacion;
        $this->strNombresCliente = $nombresCliente;
        $this->strApellidosCliente = $apellidosCliente;
        $this->strTelefonoCliente = $telefonoCliente;
        $this->strEmailCliente = $emailCliente;
        $this->strPasswordCliente= $passwordCliente;
        $this->strRfc = $rfc;
        $this->strDireccionFiscal = $direccionFiscal;
        $this->intTipoCliente = $tipoCliente;


        $return = 0;

        // Consulta

        $sql = "SELECT * FROM persona WHERE email_persona = '{$this->strEmailCliente}' or identificacion_persona = '{$this->strIdentificacion}'";
        $request = $this->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_insert = "INSERT INTO persona (identificacion_persona, nombres, apellidos, telefono_persona, email_persona, password_persona, rfc_persona, direccion_fiscal, rol_id) VALUES (?,?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->strIdentificacion,
                $this->strNombresCliente,
                $this->strApellidosCliente,
                $this->strTelefonoCliente,
                $this->strEmailCliente,
                $this->strPasswordCliente,
                $this->strRfc,
                $this->strDireccionFiscal,
                $this->intTipoCliente
                

            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

    public function selectClientes()
    {
      
        $sql = "SELECT id_persona, identificacion_persona, nombres, apellidos, telefono_persona, email_persona, rfc_persona, direccion_fiscal,rfc_persona, direccion_fiscal, status_persona
        FROM persona  
        WHERE rol_id = 4 AND status_persona !=0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCliente(int $idPersona)
    {
        $this->intIdCliente = $idPersona;
        $sql = "SELECT id_persona, identificacion_persona, nombres, apellidos, telefono_persona, email_persona, rfc_persona, direccion_fiscal,  status_persona,
       DATE_FORMAT(date_created, '%d-%m-%Y') as fechaRegistro
        FROM persona 
        WHERE id_persona = $this->intIdCliente and rol_id = 4";
        // echo $sql; exit;
        $request = $this->select($sql);
        return $request;
    }

    public function updateCliente(int $idCliente, string $identificacion, string $nombresCliente, string $apellidosCliente, string $telefonoCliente, string $emailCliente, string $passwordCliente, string $rfcCliente, string $direccionFiscal)
    {
        $this->intIdCliente = $idCliente;
        $this->strIdentificacion = $identificacion;
        $this->strNombresUsuario = $nombresCliente;
        $this->strApellidosUsuario = $apellidosCliente;
        $this->strTelefonoUsuario = $telefonoCliente;
        $this->strEmailUsuario = $emailCliente;
        $this->strPasswordUsuario = $passwordCliente;
        $this->strRfc = $rfcCliente;
        $this->strDireccionFiscal = $direccionFiscal;

        // Validacion para identificacion e email existentes

        $sql = "SELECT * FROM persona WHERE (email_persona = '{$this->strEmailUsuario}' AND id_persona != $this->intIdCliente)
        OR (identificacion_persona = '{$this->strIdentificacion}' AND id_persona != $this->intIdCliente)";

        $request = $this->select_all($sql);

        // Valdiacion: si no trae registro se procede a actualizar
        if (empty($request)) {
            // Validacion: si el pass que recibimos es diferente de vacio, entonces, seactualiza el pass
            if ($this->strPasswordUsuario != "") {
                $sql = "UPDATE persona SET identificacion_persona =?, nombres=?, apellidos=?, telefono_persona=?, email_persona=?, password_persona=?, rfc_persona=?, direccion_fiscal=?
                WHERE id_persona = $this->intIdCliente";
                $arrData = array(
                    $this->strIdentificacion,
                    $this->strNombresUsuario,
                    $this->strApellidosUsuario,
                    $this->strTelefonoUsuario,
                    $this->strEmailUsuario,
                    $this->strPasswordUsuario,
                    $this->strRfc,
                    $this->strDireccionFiscal
                );
            } else {
                $sql = "UPDATE persona SET identificacion_persona=?, nombres=?, apellidos=?, telefono_persona=?, email_persona=?, rfc_persona=?, direccion_fiscal=?
                WHERE id_persona = $this->intIdCliente";
                $arrData = array(
                    $this->strIdentificacion,
                    $this->strNombresUsuario,
                    $this->strApellidosUsuario,
                    $this->strTelefonoUsuario,
                    $this->strEmailUsuario,
                    $this->strRfc,
                    $this->strDireccionFiscal
                );
            }
            $request = $this->update($sql, $arrData);
        } else {

            $request = "exist";
        }
        return $request;
    }

    public function deleteCliente(int $idPersona)
    {
        $this->intIdCliente = $idPersona;
        $sql = "UPDATE persona SET status_persona = ? WHERE id_persona = $this->intIdCliente";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

}
