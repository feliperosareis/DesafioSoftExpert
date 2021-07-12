<?php

require_once("./helpers/DBConnection.php");

class TiposModel extends DBConnection
{
    protected $con;

    public function __construct()
    {
        $this->con = new DBConnection();
    }

    public function getTypes()
    {
        $query = "SELECT * FROM tipos ORDER BY nome";
        $result = pg_query($query);
        $types = pg_fetch_all($result);

        return $types;
    }

    public function save($type)
    {
        if (empty($type['id']))
        {
            if ($this->hasTipo($type['nome']))
            {
                return false;               
            }
            else
            {
                $result = pg_query("INSERT INTO tipos (nome, aliquota, descricao) VALUES ('".$type['nome']."', '".$type['aliquota']."', '".$type['descricao']."')");
            }
        }
        else
        {
            $result = pg_query("UPDATE tipos SET nome='".$type['nome']."', aliquota=".$type['aliquota'].", descricao='".$type['descricao']."' WHERE id=".$type['id']);                
        }

        if ($result) 
        {
            return true;
        } 
        else 
        {
            return false;
        }

    }

    public function findType($id)
    {
        $query = "SELECT * FROM tipos WHERE id=" . $id;
        $result = pg_query($query);
        $type = pg_fetch_assoc($result);

        print_r(json_encode($type));
    }

    public function hasTipo($name)
    {
        $query = "SELECT * FROM tipos WHERE nome='" . $name . "'";
        $result = pg_query($query);

        if (pg_num_rows($result)) {
            return true;
        }
        return false;
    }


    public function deleteType($id)
    {
        $result = pg_query("DELETE FROM tipos WHERE id=" . $id);
    }
}