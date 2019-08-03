<?php 

class Comment{

    protected static $db_table = "comments";
    protected static $db_table_fields = array('id ', 'photo_id', 'author', 'body');
    public $id;
    public $photo_id;
    public $author;
    public $body;

    public static function create_comment($photo_id, $author = "John Doe", $body){

        if(!empty($photo_id) && !empty($author) && !empty($body)){

            $comment = new Comment();

            $comment->photo_id  = (int)$photo_id;
            $comment->author    = $author;
            $comment->body      = $body;

            return $comment;

        }else{

            return false;
        }
    }

    public static function find_the_comments($photo_id=0){

        global $database;

        $sql = "SELECT * from " . self::$db_table;
        $sql .= " Where photo_id = " . $database->escape_string($photo_id);
        $sql .= " ORDER BY id ASC";

        return self::find_by_query($sql);
    }



// END OF CLASS USER

}


?>