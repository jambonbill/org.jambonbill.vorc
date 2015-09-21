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


    // WIKI //
    // WIKI //
    // WIKI //

    public function wikiJpUsers()
    {
        $sql="SELECT DISTINCT user_created FROM wiki_jp WHERE 1 ORDER BY user_created;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $dat=[];
        while($r=$q->fetch()){
            @$dat[$r['user_created']]=$r['user_created'];
        }
        //sort($dat);
        return $dat;
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

    /**
     * Find a Wiki id, for a given pagename.
     * Usually marked as [[pagename]] in the wiki
     * @param  string $pagename [description]
     * @return [type]           [description]
     */
    public function wikiEnPageId($pagename='')
    {
        
        //echo __FUNCTION__."($pagename);<br />";
        
        $sql="SELECT id FROM wiki_en WHERE name_wikipage LIKE '".$pagename."' LIMIT 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        if($r=$q->fetch()){
            return $r['id'];
        }
        return false;
    }


    /**
     * Find a Wiki id, for a given pagename.
     * Usually marked as [[pagename]] in the wiki
     * @param  string $pagename [description]
     * @return [type]           [description]
     */
    public function wikiJpPageId($pagename='')
    {
        
        //echo __FUNCTION__."($pagename);<br />";
        
        $sql="SELECT id FROM wiki_jp WHERE name_wikipage LIKE '".$pagename."' LIMIT 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        if($r=$q->fetch()){
            return $r['id'];
        }
        return false;
    }



    /**
     * Process wiki page text
     * https://sites.google.com/site/viceexp/
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public function process_en($str)
    {
        //echo __FUNCTION__."()";
        

        // Process Lines //
        $rows=explode("\n",$str);
        foreach($rows as $k=>$row){
            
            preg_match("/^##(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<h2>".$o[1]."</h2>";
            }

            preg_match("/^#(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<h1>".$o[1]."</h1>";
            }
            
            preg_match("/^-(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<li>".$o[1]."</li>";
            }
        }

        $str=implode("\n",$rows);// reblob //


        // Link to a wiki page
        preg_match_all("/\[\[([a-z 0-9_-]+)\]\]/i",$str,$o);
        if (count($o[1])) {
            //echo "<pre>WIKI";print_r($o);echo "</pre>";    
            foreach($o[1] as $k=>$pagename){
                $id=$this->wikiEnPageId($pagename);
                if ($id) {
                    $str=str_replace($o[0][$k],"<a href='../wiki_en/page.php?id=$id'>".$o[0][$k]."</a>",$str);
                }else{
                    $str=str_replace($o[0][$k],"<b title='Not found' style='color:#c00'>".$o[0][$k]."</b>",$str);    
                }
            }
        }
        
        // Link to a URL
        preg_match_all("/{{([a-z\. 0-9\/:-]+)}}/i",$str,$o);
        if (count($o[1])) {
            //echo "<pre>URLS";print_r($o[1]);echo "</pre>";    
            foreach($o[1] as $k=>$strurl){
                $str=str_replace($o[0],"<a href='".$o[1][$k]."'>".$o[1][$k]."</a>",$str);
            }
        }

        // NL 2 BR
        $html=nl2br($str);

        return $html;
    }

    /**
     * Process wiki page text
     * https://sites.google.com/site/viceexp/
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    public function process_jp($str)
    {
        //echo __FUNCTION__."()";
        

         // Process Lines //
        $rows=explode("\n",$str);
        foreach ($rows as $k=>$row) {

            preg_match("/^##(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<h2>".$o[1]."</h2>";
            }

            preg_match("/^#(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<h1>".$o[1]."</h1>";
            }

            preg_match("/^-(.*)$/",$row,$o);
            if (isset($o[1])) {
                $rows[$k]="<li>".$o[1]."</li>";
            }
        }

        $str=implode("\n",$rows);// reblob //



        // Link to a wiki page
        preg_match_all("/\[\[([a-z 0-9_-]+)\]\]/i",$str,$o);
        if (count($o[1])) {
            //echo "<pre>WIKI";print_r($o);echo "</pre>";    
            foreach($o[1] as $k=>$pagename){
                $id=$this->wikiJpPageId($pagename);
                if ($id) {
                    $str=str_replace($o[0][$k],"<a href='../wiki_jp/page.php?id=$id'>".$o[0][$k]."</a>",$str);
                }else{
                    $str=str_replace($o[0][$k],"<b title='Not found' style='color:#c00'>".$o[0][$k]."</b>",$str);    
                }
            }
        }
        
        // Link to a URL
        preg_match_all("/{{([a-z\. 0-9\/:-]+)}}/i",$str,$o);
        if (count($o[1])) {
            //echo "<pre>URLS";print_r($o[1]);echo "</pre>";    
            foreach($o[1] as $k=>$strurl){
                $str=str_replace($o[0],"<a href='".$o[1][$k]."'>".$o[1][$k]."</a>",$str);
            }
        }
                
        // NL 2 BR
        $html=nl2br($str);

        return $html;
    }



    public function wikiflag_en($str){
        $sql="SELECT COUNT(*) FROM wiki_en WHERE 1;";
        return $id;
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


    public function wiki_en_delete($id=0)
    {
        $sql="DELETE FROM wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }
    
    public function wiki_jp_delete($id=0)
    {
        $sql="DELETE FROM wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }





    // NEWS //
    // NEWS //
    // NEWS //
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


    public function news_en_delete($id=0)
    {
        $sql="DELETE FROM wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }
    
    public function news_jp_delete($id=0)
    {
        $sql="DELETE FROM wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }

}
