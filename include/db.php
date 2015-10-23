<?php
include 'config.php';

class db {

    public function __construct(){
        //mysqli connection to the database using the credentials from the configuration file
        $this -> db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }

    }
    public function getXmlId($xml_id){
        $sql = "SELECT xml_id FROM mashup WHERE (twitter_id = '$xml_id') OR (facebook_id = '$xml_id')";
        $result = mysqli_query($this ->db, $sql);
        return $result;
    }

    //function that adds a note to the database based on logged in user and the text area content
    public function addNote($user_id,$task_id, $content){
        $sql = "INSERT INTO annotation (user_id, task_id, content) VALUES('$user_id', '$task_id', '$content')";
        $result = mysqli_query($this -> db, $sql);
        return $result;
    }

    //get a list of all the notes from the database
    public function getNotes($user_id){

        $sql = "SELECT id, content FROM annotation WHERE user_id = '$user_id'";
        $result = mysqli_query($this ->db, $sql);
        return $result;

    }

    //get the last ID inserted in the database
    public function lastID(){
        return mysqli_insert_id($this->db);
    }

    //delete note based on the id clicked
    public function deleteNote($id){

        $sql = "DELETE FROM annotation WHERE id='$id'";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }

}