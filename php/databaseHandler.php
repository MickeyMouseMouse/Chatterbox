<?php
class DatabaseHandler {
	private const OPTIONS = "host=localhost port=5432 dbname=chatterbox user=chatterbox_user password=user";
	private $db;
	private $userID;
	
	public function __construct() { 
		$this->db = pg_connect(self::OPTIONS);
		
		if (session_status() == PHP_SESSION_ACTIVE)
			$this->userID = $_SESSION['userID'];
		else
			$this->userID = null;
	}
	
	private function updateLastAccessTime() {
		$time = time();
		pg_query($this->db, "UPDATE Users SET last_access_time=$time WHERE user_id=$this->userID;");
	}
	
	public function execute($sql) {
		if ($this->userID != null) $this->updateLastAccessTime();
		return pg_query($this->db, $sql);
	}
	
	public function close() { pg_close($this->db); }
}
?>