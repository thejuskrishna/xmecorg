<?php
include_once 'xmec.inc';
        $fb= new Facebook(array(
          'appId'  => '101039650020031',
          'secret' => '4cd18604efbe1d7691981b26532c7c0b',
          'cookie' => true,
        ));

        $uid=$fb->getUser();
        if($uid!=0)
        {
            $user_profile = $fb->api('/me');
        }
        else
        {

            return FALSE;
        }
echo "ha ha";
//var_dump($user_profile);
var_dump($user_profile["education"]['school']['name']);
?>
