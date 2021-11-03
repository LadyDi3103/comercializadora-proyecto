<?php  

// este archivo hace las consultas a la BD

class Mysql extends Conexion{
    
private $conexion;
private $strquery;
private $arrvalues;

    
function __construct()
{
 $this->conexion = new Conexion;
 $this->conexion= $this->conexion->connect();   
}

// metodo para insertar
 public function insert(string $query, array $arrvalues)
 {
    //  guardamos lo que venga como parametros en la funcion insert
     $this->strquery = $query;
     $this->arrvalues = $arrvalues;

    //  preparamos el query
     $insert = $this->conexion->prepare($this->strquery);
    //  ejecutamos los datos del array para almacenarlos
     $resInsert = $insert->execute($this->arrvalues);
     
    //  validamos si se almacenaron los datos
     if ($resInsert) {
        //  guardamos el ultimo id almacenado, si no se almacena retorna 0
         $lastInsert = $this->conexion->lastInsertId();
     }else{
         $lastInsert =0;
     }
     return $lastInsert;
     
 }


//  metodo para buscar un registro
public function select(string $query)
{
    //  guardamos lo que venga como parametros en la funcion select
    $this->strquery = $query;
    //  preparamos el query
    $result = $this->conexion->prepare($this->strquery);
    $result->execute();
    // se utiliza fetch porque solo devuelve un resultado
    $data = $result->fetch(PDO::FETCH_ASSOC);
    return $data;
}


//  metodo para buscar varios registros
public function select_all(string $query)
{
   $this->strquery = $query;
   $result = $this->conexion->prepare($this->strquery);
   $result->execute();
   $data = $result->fetchall(PDO::FETCH_ASSOC);
   return $data; 
}

// metodo para actualizar
public function update(string $query, array $arrvalues)
{
$this->strquery = $query;
$this->arrvalues = $arrvalues;
$update = $this->conexion->prepare($this->strquery);
$resExecute = $update->execute($this->arrvalues);
return $resExecute;

}

// metodo para eliminar
public function delete(string $query)
{
    $this->strquery = $query;
    $result = $this->conexion->prepare($this->strquery);
    $result_delete =  $result->execute();
    return $result_delete;
}

}
?>