<?php

namespace VORC;

class Vorc
{
    private $start;
    private $config;
    private $db;
	private $UD;

    public function __construct ()
    {
        // start/stop watch
        $this->start=microtime(true);

        $filename=__DIR__."/../../profiles/".$_SERVER['HTTP_HOST'].".json";

        if (is_file($filename)) {
            // Load configuration
            $this->config = json_decode(file_get_contents($filename));
        }else{
            throw new \RuntimeException(__FUNCTION__.' error: no config file like '.$filename);
        }

        // Create PDO object
        $pdo=new Pdo;
        $this->db=$pdo->db();


        //User
        $this->UD=new UserDjango($this->db);
        $session = $this->UD->djangoSession();//
        //echo "<pre>session:";print_r($session);
        $this->user = $this->UD->user($session['session_data']);
    }


    /**
     * [db description]
     * @return [type] [description]
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * End user session
     * @return [type] [description]
     */
    public function logout()
    {
        $this->UD->logout();
        return true;
    }


    /**
     * Return current user id !
     * @return [type] [description]
     */
    public function user()
    {
        //print_r($this->user);
        return $this->user;
    }


    /**
     * Return true if user is staff
     * @return boolean [description]
     */
    public function is_staff(){
        return $this->user['is_staff'];
    }




    /**
     * Return auth_user record for a given user_id
     * @return [type] [description]
     */
    public function auth_user($user_id=0)
    {
        $user_id*=1;
        if(!$user_id)return false;

        $sql="SELECT * FROM `jambonbill.org`.auth_user WHERE id=$user_id LIMIT 1;";
        $q = $this->db->query($sql) or die(print_r($this->db()->errorInfo(), true) . "<hr />$sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r;
    }


    public function username($user_id=0)
    {
        $user_id*=1;
        if(!$user_id)return false;

        $sql="SELECT username FROM `jambonbill.org`.auth_user WHERE id=$user_id LIMIT 1;";
        $q = $this->db->query($sql) or die(print_r($this->db()->errorInfo(), true) . "<hr />$sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['username'];

    }


    /**
     * Return current user id !
     * @return [type] [description]
     */
    public function user_id()
    {
        return $this->user['id'];
    }


    // WIKI //
    // WIKI //
    // WIKI //

    public function wikiJpUsers()
    {
        $sql="SELECT DISTINCT user_created FROM vorc.wiki_jp WHERE 1 ORDER BY user_created;";
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
        $sql="SELECT DISTINCT user_created FROM vorc.wiki_en WHERE 1 ORDER BY user_created;";
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
        $sql="SELECT DISTINCT vorc.flag_category FROM vorc.wiki_en WHERE 1;";
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
        $sql="SELECT DISTINCT vorc.flag_platform FROM vorc.wiki_en WHERE 1;";
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

        $sql="SELECT id FROM vorc.wiki_en WHERE name_wikipage LIKE '".$pagename."' LIMIT 1;";
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

        $sql="SELECT id FROM vorc.wiki_jp WHERE name_wikipage LIKE '".$pagename."' LIMIT 1;";
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



    public function toMarkdown($str='')
    {
        //convert [[slug]] to [slug](http://slug)


        // Link to a wiki page
        preg_match_all("/\[\[([a-z 0-9_-]+)\]\]/i",$str,$o);
        if (count($o[1])) {
            //echo "<pre>WIKI";print_r($o);echo "</pre>";
            foreach($o[1] as $k=>$slug){
                //$id=$this->wikiEnPageId($pagename);
                $str=str_replace($o[0][$k],"<a href='?slug=$slug'>".$o[0][$k]."</a>",$str);
            }
        }


        return $str;
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
        $sql="SELECT COUNT(*) FROM vorc.wiki_en WHERE 1;";
        return $id;
    }


    public function wikiEnCount()
    {
        $sql="SELECT COUNT(*) FROM vorc.wiki_en WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['COUNT(*)'];
    }

    public function wikiJpCount()
    {
        $sql="SELECT COUNT(*) FROM vorc.wiki_jp WHERE 1;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r['COUNT(*)'];
    }

    /*
    public function wiki_en_delete($id=0)
    {
        $sql="DELETE FROM vorc.wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }

    public function wiki_jp_delete($id=0)
    {
        $sql="DELETE FROM vorc.wiki_jp WHERE xxx;";
        $q=$this->db()->query($sql) or die("Error: $sql");
    }
    */




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

    /*
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
    */


    // NEW WIKI //
    // NEW WIKI //
    // NEW WIKI //

    public function wikiUrls($id=0)
    {
        $sql="SELECT * FROM vorc.wiki_url WHERE wu_id>0 AND wu_wiki_id=$id;";
        $q=$this->db()->query($sql) or die("Error: $sql");
        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[]=$r;
        }
        return $dat;
    }


    public function wikiUrlAdd($wiki_id=0,$url='')
    {
        $wiki_id*=1;
        $url=trim($url);

        $sql="INSERT INTO vorc.wiki_url ( wu_wiki_id, wu_url, wu_updated, wu_updater) ";
        $sql.="VALUES ($wiki_id,".$this->db()->quote($url).",NOW(), ".$this->user_id().");";
        $q=$this->db()->query($sql) or die("Error: $sql");

        return true;
    }

    public function wikiUrlDelete($wu_id=0)
    {
        $wu_id*=1;
        if(!$wu_id)return false;

        $sql="UPDATE vorc.wiki_url SET wu_id=-wu_id, wu_updated=NOW() wu_updater=".$this->user_id();
        $sql.=" WHERE wu_id=$wu_id LIMIT 1;";

        $this->db()->query($sql) or die("Error: $sql");
        return true;
    }


    public function wiki_categories()
    {
        $sql="SELECT wc_id, wc_name FROM vorc.wiki_categories WHERE wc_id>0;";
        $q=$this->db()->query($sql) or die("Error: $sql");

        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[]=$r;
        }
        return $dat;
    }


    public function wiki_platforms()
    {
        $sql="SELECT wp_id, wp_name FROM vorc.wiki_platforms WHERE wp_id>0;";
        $q=$this->db()->query($sql) or die("Error: $sql");

        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[]=$r;
        }
        return $dat;
    }

    public function platformNames()
    {
        $sql="SELECT wp_id, wp_name FROM vorc.wiki_platforms WHERE wp_id>0;";
        $q=$this->db()->query($sql) or die("Error: $sql");

        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[$r['wp_id']]=$r['wp_name'];
        }
        return $dat;
    }

    public function categoryNames()
    {
        $sql="SELECT wc_id, wc_name FROM vorc.wiki_categories WHERE wc_id>0;";
        $q=$this->db()->query($sql) or die("Error: $sql");

        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[$r['wc_id']]=$r['wc_name'];
        }
        return $dat;
    }


    public function random_slug()
    {
        $sql="SELECT w_slug FROM vorc.wiki WHERE w_slug IS NOT NULL ORDER BY RAND();";
        $q=$this->db()->query($sql) or die("Error: $sql");
        return $r=$q->fetch(\PDO::FETCH_ASSOC);
    }


    public function addPlatform($w_id=0, $platform_id=0)
    {
        $w_id*=1;
        $platform_id*=1;

        $sql="INSERT INTO vorc.wiki_platform (wp_wiki_id, wp_platform_id, wp_updated, wp_updater) ";
        $sql.="VALUES ($w_id, $platform_id,NOW(),".$this->user_id().");";
        $this->db()->query($sql) or die("Error: $sql");

        return true;
    }

    public function addCategory($w_id=0, $category_id=0)
    {
        $w_id*=1;
        $category_id*=1;

        $sql="INSERT INTO vorc.wiki_category (wc_wiki_id, wc_category_id, wc_updated, wc_updater) ";
        $sql.="VALUES ($w_id, $category_id, NOW(),".$this->user_id().");";
        $this->db()->query($sql) or die(print_r($this->db()->errorInfo(), true) . "<hr />$sql");

        return true;
    }

    public function pageCategories($w_id=0)
    {
        $w_id*=1;

        $sql="SELECT * FROM vorc.wiki_category WHERE wc_wiki_id=$w_id;";
        $q=$this->db()->query($sql) or die(print_r($this->db()->errorInfo(), true) . "<hr />$sql");
        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[]=$r;
        }
        return $dat;
    }

    public function pagePlatforms($w_id=0)
    {
        $w_id*=1;

        $sql="SELECT * FROM vorc.wiki_platform WHERE wp_wiki_id=$w_id;";
        $q=$this->db()->query($sql) or die(print_r($this->db()->errorInfo(), true) . "<hr />$sql");
        $dat=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $dat[]=$r;
        }
        return $dat;
    }


}


