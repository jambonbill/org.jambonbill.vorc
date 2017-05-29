<?php

/**
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace VORC;


/**
* @brief Class providing django users
* @see http://www.djangoproject.com
*
* Authentification backend to authenticate agains a django webapplication using
* django.contrib.auth.
*/
class UserDjango
{
    public $db=null;
    public $DEBUG=false;
    private $user=[];
    private $session=null;
    private $log=null;

    public function __construct ($db)
    {

        $this->db = $db;

    }


    /**
     * Return the current user_id
     * @return [type] [description]
     */
    public function user_id()
    {
        if(isset($this->user['id'])){
            return $this->user['id'];
        }
        return 0;
    }



    /**
    * @brief Check if the password is correct
    * @param $uid The username
    * @param $password The password
    * @returns true/false
    *
    * Check if the password is correct without logging in the user
    */
    public function checkPassword($email = '', $password = '')
    {
        if (!$this->db) {
            return false;
        }

        //echo __FUNCTION__."\n";

        $query  = $this->db->prepare('SELECT id, email, password, is_active, is_superuser FROM auth_user WHERE email =  ?');

        if ($query->execute(array($email))) {
            $row = $query->fetch(\PDO::FETCH_ASSOC);
            //var_dump($row);
            if (!empty($row)) {
                //print_r($row);
                $storedHash=$row['password'];
                if (self::beginsWith($storedHash, 'sha1')) {
                    $chunks = preg_split('/\$/', $storedHash, 3);
                    $salt   = $chunks[1];
                    $hash   = $chunks[2];

                    if (sha1($salt.$password) === $hash) {
                        return $row;
                    } else {
                        return false;
                    }

                } elseif (self::beginsWith($storedHash, 'pbkdf2')) {
                    $chunks = preg_split('/\$/', $storedHash, 4);
                    list($pbkdf, $algorithm) = preg_split('/_/', $chunks[0]);
                    $iter = $chunks[1];
                    $salt = $chunks[2];
                    $hash = $chunks[3];

                    //echo "<li>pbkdf2<br />";
                    //echo "<li>algorithm=$algorithm<br />";
                    //echo "<li>iter=$iter<br />";
                    //echo "<li>salt=$salt<br />";
                    //echo "<li>hash=$hash<br />";

                    if ($algorithm === 'sha1') {
                        $digest_size = 20;
                    } elseif ($algorithm === 'sha256') {
                        $digest_size = 32;
                    } else {
                        return false;
                    }

                    if (base64_encode(PhpsecCrypt::pbkdf2($password, $salt, $iter, $digest_size, $algorithm)) === $hash) {
                        return $row;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

    /**
    * @brief Helper function for checkPassword
    * @param $str The String to be searched
    * @param $sub The String to be found
    * @returns true/false
    */
    private function beginsWith($str, $sub)
    {
        return (substr($str, 0, strlen($sub)) === $sub );
    }


    /**
     * Jambon function, get a string, return it converted to a django password
     * @param  string $password [description]
     * @return [type]           [description]
     */
    public function djangopassword($password = '')
    {
        $algorithm='sha256';
        $iter='10000';
        //$salt='O1KgfAei96fL';
        $salt = substr(md5(rand(0, 999999)), 0, 12);
        $digest_size = 32;
        $b64hash=base64_encode(PhpsecCrypt::pbkdf2($password, $salt, $iter, $digest_size, $algorithm));

        return "pbkdf2_".$algorithm.'$'.$iter.'$'.$salt.'$'.$b64hash;
    }


    /**
     * Save php session id to `django_session` table.
     * The idea is to make sur the user isnt logged in twice, and keeping the standard django scheme
     * @param  [type] $session_id [description]
     * @param  [type] $userid     [description]
     * @return [type]             [description]
     */
    public function djangoSessionRegister($session_id = '', $userid = 0)
    {
        $userid*=1;

        //echo "djangoSessionRegister( $session_id, $userid);";
        $session_id=session_id();

        $sql = "INSERT IGNORE INTO django_session ( session_key, session_data, expire_date ) ";
        $sql.= "VALUES ('$session_id','$userid', NOW());";

        $this->db->query($sql) or die( print_r($this->db->errorInfo()) );

        return true;
    }


    /**
     * Return current session data.
     * @return [type] [description]
     */
    public function djangoSession()
    {

        //echo __FUNCTION__."()\n";
        //echo self::$db;

        $sid=session_id();
        $sql = "SELECT * FROM django_session WHERE session_key='$sid';";
        //$q=$this->db->query($sql);// or die( $this->db->)
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo()));
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        //var_dump($r);
        return $r;
    }


    /**
     * Autoconnect with given sessionid (from cookie)
     * @param  [type] $sessionId [description]
     * @return [type]            [description]
     */
    public function loginWithSessionId($sessionId='')
    {
        if(!$sessionId)return false;

        if($this->DEBUG)echo __FUNCTION__."($sessionId)\n";

        $sql = "SELECT session_data FROM django_session WHERE session_key LIKE ".$this->db->quote($sessionId)." LIMIT 1;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo()));

        if($this->DEBUG)echo "$sql\n";

        $r=$q->fetch(\PDO::FETCH_ASSOC);

        if (!$r) {
            if($this->DEBUG)echo "session record not found\n";
            return false;
        }

        $sData=$r['session_data'];

        if($this->DEBUG)echo "data=".print_r($sData,true);

        $re = '/user_idX\x01(\d+)\w+\x12/';
        preg_match($re, str_replace("\0",'',base64_decode($sData)), $o);

        if ($o&&$o[1]>1) {
            if($this->DEBUG)echo "data=".print_r($o,true);
            $sid=session_id();
            $this->djangoSessionRegister($sid, $o[1]);
            return $o[1]*1;
        }else{
            if($this->DEBUG)echo "couldnt decode data";
        }

        return false;
    }

    /**
     * Log in (jambon session system)
     * @return bool true on success
     */
    public function login($email = '', $pass = '')
    {
        $this->user = $this->checkPassword($email, $pass);
        //print_r($user);exit;
        if ($this->user && $this->user['is_active']) {// && $this->user['is_superuser']
            //Create a new session, deleting the previous session data
            @session_regenerate_id(true);
            $sid=session_id();
            $this->djangoSessionRegister($sid, $this->user['id']);
            //$this->log->addInfo(__FUNCTION__, ['email' => $email,'id' => $this->user['id']]);
            //$this->log->addInfo(__FUNCTION__."($email,pass)", array('user_id'  => $this->user['id'] ));
            return true;
        }else{
            //$this->log->addInfo("logfail($email,$pass)", array('user_id'=>0));
        }
        return false;
    }



    /**
     * Stop/Delete current session (jambon system)
     */
    public function logout()
    {
        //echo __FUNCTION__."()\n";
        //echo "<pre>";print_r($this->user);exit;
        $sid=session_id();
        $sql = "DELETE FROM django_session WHERE session_key='$sid';";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo()));

        //$this->log->addInfo(__FUNCTION__."()", array('user_id'=>$this->user['id']));

        //ob_clean();//this clear the output buffer, i'm not sure why i need it

        if (@session_regenerate_id(true)) {
            @$_SESSION['configfile']='';
            return session_id();
        }

        return false;
    }


    /**
    * @brief Get a list of all users
    * @returns array with all active usernames
    *
    * Get a list of all users.
    */
    public function getUsers($search = '', $limit = 10, $offset = 0)
    {
        if (!$this->db) {
            return array();
        }

        $query  = $this->db->prepare('SELECT id, username, email, is_active, is_staff FROM `auth_user` WHERE is_active=1 ORDER BY username');
        $users  = array();
        if ($query->execute()) {
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }
        }
        return $users;
    }

    /**
    * @brief check if a user exists
    * @param string $uid the username
    * @return boolean
    */
    public function userExists($uid)
    {
        if (!$this->db) {
            return false;
        }

        $query  = $this->db->prepare('SELECT username FROM `auth_user` WHERE username = ? AND is_active=1');
        if ($query->execute(array($uid))) {
            $row = $query->fetch();
            return !empty($row);
        }
        return false;
    }

    /**
     * Return django auth_user data
     * @param  integer $uid [description]
     * @return [type]       [description]
     */
    public function user($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT * FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        $r=$q->fetch(\PDO::FETCH_ASSOC);
        return $r;
    }

    public function isActive($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_active FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql);
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }

    public function isStaff($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_staff FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo()));
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }

    public function isSuperuser($uid = 0)
    {
        $uid*=1;
        if (!$uid) {
            return false;
        }

        $sql="SELECT is_superuser FROM auth_user WHERE id=$uid LIMIT 1;";
        $q=$this->db->query($sql) or die(print_r($this->db->errorInfo()));
        return $q->fetch(\PDO::FETCH_ASSOC)[0];
    }
}
