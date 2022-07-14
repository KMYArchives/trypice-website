<?php

	/*
	*
	* PHP-PDO-MySQL-Class
	* https://github.com/lincanbin/PHP-PDO-MySQL-Class
	*
	* Copyright 2015 Canbin Lin (lincanbin@hotmail.com)
	* http://www.94cb.com/
	*
	* Licensed under the Apache License, Version 2.0:
	* http://www.apache.org/licenses/LICENSE-2.0
	* 
	* A PHP MySQL PDO class similar to the Python MySQLdb. 
	*
	*/
	require_once 'pdo/class.pdo_log.php';
	require_once 'pdo/class.pdo_iterator.php';

	/** 
	 * 
	 * Class DB
	 * 
	 * @property PDO pdo PDO object
	 * @property PDOLog PDOLog logObject
	 * @property PDOStatement sQuery PDOStatement
	 * 
	**/

	class DB {

		public $pdo;
		public $Dsn;
		public $Host;
		public $DBChar;
		public $DBPort;
		public $DBName;
		public $DBUser;
		public $sQuery;
		public $logObject;
		public $DBPassword;
		public $parameters;
		public $rowCount = 0;
		public $querycount = 0;
		public $columnCount = 0;
		public $connectionStatus = false;

		const RETRY_ATTEMPTS = 3;
		public $retryAttempt = 0;
		const AUTO_RECONNECT = true;
		
		private function Connect() {
			try {
				$dsn	=	$this->Dsn . ':';
				$dsn	.=	'host=' . $this->Host . ';';
				$dsn	.=	'port=' . $this->DBPort . ';';
				if (!empty($this->DBName)) { $dsn .= 'dbname=' . $this->DBName . ';'; }

				$dsn	.=	'charset=' . $this->DBChar . ';';
				$this->pdo = new PDO($dsn, $this->DBUser,  $this->DBPassword, [
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
					PDO::MYSQL_ATTR_FOUND_ROWS => true
				]);

				$this->connectionStatus = true;
			} catch (PDOException $e) {
				$this->ExceptionLog($e, '', 'Connect');
			}
		}

		private function SetFailureFlag() {
			$this->pdo = null;
			$this->connectionStatus = false;
		}
		
		private function BuildParams($query, $params = null) {
			if (!empty($params)) {
				$array_parameter_found = false;

				foreach ($params as $parameter_key => $parameter) {
					if (is_array($parameter)){
						$in = "";
						$array_parameter_found = true;

						foreach ($parameter as $key => $value){
							$name_placeholder = $parameter_key."_".$key;
							$in .= ":".$name_placeholder.", ";
							$params[$name_placeholder] = $value;
						}

						$in = rtrim($in, ", ");
						$query = preg_replace("/:".$parameter_key."/", $in, $query);
						unset($params[$parameter_key]);
					}
				}

				if ($array_parameter_found) $this->parameters = $params;
			}

			return $query;
		}

		private function Init($query, $parameters = null, $driverOptions = []) {
			if (!$this->connectionStatus) { $this->Connect(); }
			
			try {
				$this->parameters = $parameters;
				$this->sQuery	= $this->pdo->prepare($this->BuildParams($query, $this->parameters), $driverOptions);
				
				if (!empty($this->parameters)) {
					if (array_key_exists(0, $parameters)) {
						$parametersType = true;
						array_unshift($this->parameters, "");
						unset($this->parameters[0]);
					} else {
						$parametersType = false;
					}

					foreach ($this->parameters as $column => $value) {
						$this->sQuery->bindParam(
							$parametersType ? intval($column) : ":" . $column, $this->parameters[$column]
						);
					}
				}

				if (!isset($driverOptions[PDO::ATTR_CURSOR])) { $this->sQuery->execute(); }
				$this->querycount++;
			} catch (PDOException $e) {
				$this->ExceptionLog($e, $this->BuildParams($query), 'Init', array('query' => $query, 'parameters' => $parameters));
			}
			
			$this->parameters = [];
		}
		
		private function ExceptionLog(PDOException $e, $sql = "", $method = '', $parameters = []) {
			$message	=	$e->getMessage();
			$exception	=	'Unhandled Exception. <br>';
			$exception	.=	$message;
			$exception	.=	'<br> You can find the error back in the log.';
			
			if (!empty($sql)) { $message .= "\r\nRaw SQL : " . $sql; }
			$this->logObject->write($message, $this->DBName . md5($this->DBPassword));

			if (
				self::AUTO_RECONNECT
				&& $this->retryAttempt < self::RETRY_ATTEMPTS
				&& stripos($message, 'server has gone away') !== false
				&& !empty($method)
				&& !$this->inTransaction()
			) {
				$this->SetFailureFlag();
				$this->retryAttempt ++;
				$this->logObject->write('Retry ' . $this->retryAttempt . ' times', $this->DBName . md5($this->DBPassword));
				call_user_func_array(array($this, $method), $parameters);
			} else {
				if (($this->pdo === null || !$this->inTransaction()) && php_sapi_name() !== 'cli') {
					header("HTTP/1.1 500 Internal Server Error");
					header("Status: 500 Internal Server Error");
					echo $exception;
					exit();
				} else {
					throw $e;
				}
			}
		}

		public function __construct(bool|string $change = false) {
			error_reporting(0);
			Utils::load_env();
			
			$this->parameters	=	[];
			$this->logObject	=	new PDOLog;
			
			$this->DBName		=	$_ENV['DATABASE_DB'];
			$this->Dsn			=	$_ENV['DATABASE_DSN'];
			$this->DBUser		=	$_ENV['DATABASE_USER'];
			$this->Host			=	$_ENV['DATABASE_HOST'];
			$this->DBPort		=	$_ENV['DATABASE_PORT'];
			$this->DBPassword	=	$_ENV['DATABASE_PASS'];
			$this->DBChar		=	$_ENV['DATABASE_CHARSET'];

			if ($change) {
				$this->DBName	=	match($change) {
					'core'		=>	$_ENV['DATABASE_DB_CORE'],
					'account'	=>	$_ENV['DATABASE_DB_ACCOUNT'],
				};
			}

			$this->Connect();
		}
		
		public function single($query, $params = null) {
			$this->Init($query, $params);
			return $this->sQuery->fetchColumn();
		}
		
		public function column($query, $params = null) {
			$this->Init($query, $params);

			$resultColumn		=	$this->sQuery->fetchAll(PDO::FETCH_COLUMN);
			$this->rowCount		=	$this->sQuery->rowCount();
			$this->columnCount	=	$this->sQuery->columnCount();
			$this->sQuery->closeCursor();

			return $resultColumn;
		}
		
		public function insert($tableName, $params = null) {
			$keys		=	array_keys($params);
			$rowCount	=	$this->query(
				'INSERT INTO `' . $tableName . '` (`' . implode('`,`', $keys) . '`) 
				VALUES (:' . implode(',:', $keys) . ')',
				$params
			);

			if ($rowCount === 0) { return false; }
			return $this->lastInsertId();
		}
		
		public function closeConnection() { $this->pdo = null; }

		public function commit() { return $this->pdo->commit(); }

		public function rollBack() { return $this->pdo->rollBack(); }

		public function inTransaction() { return $this->pdo->inTransaction(); }
		
		public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC) {
			$this->Init($query, $params);
			$resultRow			=	$this->sQuery->fetch($fetchmode);
			$this->rowCount		=	$this->sQuery->rowCount();
			$this->columnCount	=	$this->sQuery->columnCount();
			$this->sQuery->closeCursor();

			return $resultRow;
		}

		public function beginTransaction() { return $this->pdo->beginTransaction(); }
		
		public function query($query, $params = null, $fetchMode = PDO::FETCH_ASSOC) {
			$query			=	trim($query);
			$rawStatement	=	explode(" ", $query);
			$this->Init($query, $params);
			$statement		=	strtolower($rawStatement[0]);

			if ($statement === 'select' || $statement === 'show') {
				return $this->sQuery->fetchAll($fetchMode);
			} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
				return $this->sQuery->rowCount();
			} else {
				return NULL;
			}
		}

		public function iterator($query, $params = null, $fetchMode = PDO::FETCH_ASSOC) {
			$query			=	trim($query);
			$rawStatement	=	explode(" ", $query);
			$this->Init($query, $params, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$statement		=	strtolower($rawStatement[0]);

			if ($statement === 'select' || $statement === 'show') {
				return new PDOIterator($this->sQuery, $fetchMode);
			} elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
				return $this->sQuery->rowCount();
			} else {
				return NULL;
			}
		}
		
	}