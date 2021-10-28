<?php
$host              = "localhost";                 //Server host address, usually will set to be localhost
$databse_name      = "";           //Server database name
$database_username = "root";            		  //Server databse name
$database_password = '';               //Database password

$link = mysql_connect($host,$database_username,$database_password);
if(!$link){
    die('Could not connect : '.mysql_error());
}else{
    
    // Selecting database
    mysql_select_db($databse_name,$link);

    $loginMsg="";
    if(isset($_REQUEST['uname']) && $_REQUEST['uname']<>'' && $_REQUEST['pass']<>''){
        $uname=addslashes(trim($_REQUEST['uname']));
        $pass=md5($_REQUEST['pass']);
        $testFileSql="SELECT fld_id,fld_filename,fld_wp_files FROM tbl_dbDetails WHERE fld_userName='$uname' AND fld_password='$pass' AND fld_loginFlag='true'";
        $rs=mysql_query($testFileSql);
        if(mysql_num_rows($rs)>0){
            $row=  mysql_fetch_array($rs);
            $fileName=$row['fld_filename'];
            $supportf=$row['fld_wp_files'];
            chmod("db_backup/".$fileName, 0777);
            chmod("db_backup/".$supportf, 0777);
            $loginMsg="You can download your file.";
        }else{
            echo $loginMsg="Invalid login details";die;
        }
    }else{
        echo $loginMsg="Opps! direct link not allowed.";die;
    }
?>
<html>
    <head>
        <title>
            Database backup download center
        </title>
    </head>
    <body>

	<div style="padding: 100px; border: 1px solid #000;">
		<?php echo $loginMsg;?>
		<div style="padding-top: 20px;">
			<div>
				<a href="https://app.refinebooks.com/download-db.php?fname=<?php echo $fileName;?>" style="text-decoration: none;">
					<input type="button" value="Downlaod File"/>
				</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="https://app.refinebooks.com/delete-db.php?fname=<?php echo $fileName;?>" style="text-decoration: none;">
					<input type="button" value="Delete File"/>
				</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a target="_blank" href="https://app.refinebooks.com/download-db.php?fname=<?php echo $supportf;?>" style="text-decoration: none;">
					<input type="button" value="Downlaod Support"/>
				</a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a target="_blank" href="https://app.refinebooks.com/delete-db.php?sname=<?php echo $supportf;?>" style="text-decoration: none;">
					<input type="button" value="Delete Support"/>
				</a>
			</div>
		</div>
	</div>
</body>
</html>
<?php }?>
