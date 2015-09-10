<?php

namespace VORC;

class Vorc
{
	private $db;
	public function __construct ()
    {
        // Create PDO object
        $pdo=new \PDO\Pdo;
        $this->db=$pdo->db();
    }

    /**
     * [db description]
     * @return [type] [description]
     */
    public function db()
    {
        return $this->db;
    }


    public function wikiUsers()
    {
        $sql="SELECT DISTINCT user_created FROM wiki_en WHERE 1 ORDER BY user_created;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $dat=[];
        while($r=$q->fetch()){
            @$dat[$r['user_created']]=$r['user_created'];
        }
        //sort($dat);
        return $dat;
    }

    public function newsUsers()
    {
        $sql="SELECT DISTINCT user_created FROM news_en WHERE 1 ORDER BY user_created;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $dat=[];
        while($r=$q->fetch()){
            @$dat[$r['user_created']]=$r['user_created'];
        }
        //sort($dat);
        return $dat;
    }

    public function categories()
    {
        $sql="SELECT DISTINCT flag_category FROM wiki_en WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $categs=[];
        while($r=$q->fetch()){
            $x=explode(";",$r['flag_category']);
            foreach($x as $k=>$v){
                if(!$v)continue;
                @$categs["$v"]++;
            }
        }
        ksort($categs);
        return $categs;
    }


    public function platforms()
    {
        $sql="SELECT DISTINCT flag_platform FROM wiki_en WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $dat=[];
        while($r=$q->fetch()){
            $x=explode(";",$r['flag_platform']);
            foreach($x as $k=>$v){
                if(!$v)continue;
                @$dat["$v"]++;
            }
        }
        ksort($dat);
        return $dat;
    }

    public function wikiEnCount()
    {
        $sql="SELECT COUNT(*) FROM wiki_en WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['COUNT(*)'];
    }

    public function wikiJpCount()
    {
        $sql="SELECT COUNT(*) FROM wiki_jp WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['COUNT(*)'];
    }

}
