<?php

	include 'xmec.inc';
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}

	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}

        $dbh =& XMEC::getDB();

        if (!(is_object($dbh) &&
              is_subclass_of($dbh, "db_common"))) {
            $this->error = "Invalid database object ";
            return FALSE;
        }

        //$user = new XMEC_user();

        $query="select id from xmec_user";
        $entry=null;
        $res=$dbh->getAll($query, DB_FETCHMODE_ASSOC);
        foreach ($res as $entry)
        {
            $eid=$entry['id'];$yr=null;
            if(!strcasecmp(substr($eid, 0, 2),"CS") || !strcasecmp(substr($eid, 0, 2),"EC") || !strcasecmp(substr($eid, 0, 2),"EB") || !strcasecmp(substr($eid, 0, 2),"EE"))
            {
                list($yr,$tmp) = split('/', $eid);
                $yr=substr($yr, 2);
                if(preg_match('/[A-Z]/i', $yr))
                {
                    $yr=substr($yr, 1);
                }
                $yr=substr($yr, 0, 2)+2004;
            }
            else        // old roll no. format
            {
                list($tmp,$yr) = split('/', $eid);
                $yr+=4;
            }

            $query="update xmec_user set batch='$yr' where id='$eid'";
            $dbh->getAll($query, DB_FETCHMODE_ASSOC);
        }

?>