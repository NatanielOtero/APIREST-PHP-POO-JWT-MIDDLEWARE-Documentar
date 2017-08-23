<?php

require_once "AccesoDatos.php";
/**
 *
 */
class user
{
  public $user;
  public $pass;
  public $est;
  public $id;



public static function traerUs($id)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `user`, `pass`, `est`, `id` FROM `usuario`  WHERE id = $id");
    $consulta->execute();
    $cdBuscado= $consulta->fetchObject('user');
    return $cdBuscado;


}

public  function traerTodos()
{
  $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
  $consulta =$objetoAccesoDato->RetornarConsulta("SELECT `user`, `pass`, `est`, `id` FROM `usuario` ");
  $consulta->execute();
  return $consulta->fetchAll(PDO::FETCH_CLASS, "user");
}

  public function bajaUs()
 {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta =$objetoAccesoDato->RetornarConsulta("
      update usuario
      set est = 0
      WHERE id=:id");
      $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
      $consulta->execute();
      return $consulta->rowCount();
 }
 public function altaUs()
 {
      $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
      $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (user,pass,est,id)values('$this->user','$this->pass',1,$this->id)");
      $consulta->execute();
      return $objetoAccesoDato->RetornarUltimoIdInsertado();


 }
public function modUs()
 {
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta =$objetoAccesoDato->RetornarConsulta("
      update usuario
      set user=:us,
      pass=:p
      WHERE id=:id");
    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
    $consulta->bindValue(':us',$this->user, PDO::PARAM_INT);
    $consulta->bindValue(':p', $this->pass, PDO::PARAM_STR);
    return $consulta->execute();
 }






}






 ?>
