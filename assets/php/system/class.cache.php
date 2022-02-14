<?php

	use Phpfastcache\Helper\Psr16Adapter;

	class Cache {

		private $cache;

		public $driver = 'Files';

		public function __construct() {
			$this->cache = new \Phpfastcache\Helper\Psr16Adapter(
				$this->driver
			);
		}

		public function config(array $config) {
			$this->cache->config($config);
		}

		public function append(string $key, mixed $value) {
			$this->cache->append(
				$key, $value
			);
		}

		public function set(string $key, mixed $value, int $time = 300) {
			if (is_array($value)) {
				$value = json_encode($value);
			}

			return $this->cache->set(
				$key, $value, $time
			);
		}

		public function clean() {
			return $this->cache->clear();
		}

		public function has($key) {
			return $this->cache->has($key); 
		}

		public function delete($key) {
			return $this->cache->delete($key);
		}

		public function get(string $key) {
			$value = $this->cache->get($key);

			if (is_array($value)) {
				$value = json_decode(
					$value, true
				);
			}

			return $value;
		}

		public function getDriver() {
			return $this->cache->getDriver();
		}

		public function getInfo() {
			return $this->cache->getInfo();
		}

		public function setDriver(string $driver) {
			return $this->cache->setDriver($driver);
		}

		public function setDefaultTtl(int $ttl) {
			return $this->cache->setDefaultTtl($ttl);
		}

		public function setDirectoryLevel(int $directoryLevel) {
			return $this->cache->setDirectoryLevel($directoryLevel);
		}

		public function setFileNameProtection(bool $fileNameProtection) {
			return $this->cache->setFileNameProtection($fileNameProtection);
		}

		public function setItemTtl(string $key, int $ttl) {
			return $this->cache->setItemTtl($key, $ttl);
		}

		public function setNamespace(string $namespace) {
			return $this->cache->setNamespace($namespace);
		}

		public function setReadControlType(string $type) {
			return $this->cache->setReadControlType($type);
		}

		public function getInstalledDrivers() {
			return $this->cache->getInstalledDrivers();
		}

		public function getStats() {
			return $this->cache->getStats();
		}

		public function getVersion() {
			return $this->cache->getVersion();
		}

		public function getWriteFileHandler() {
			return $this->cache->getWriteFileHandler();
		}

		public function getReadFileHandler() {
			return $this->cache->getReadFileHandler();
		}

		public function getWriteMemHandler() {
			return $this->cache->getWriteMemHandler();
		}

		public function getReadMemHandler() {
			return $this->cache->getReadMemHandler();
		}

		public function getWriteMemStreamHandler() {
			return $this->cache->getWriteMemStreamHandler();
		}

		public function getReadMemStreamHandler() {
			return $this->cache->getReadMemStreamHandler();
		}

		public function getWriteStreamHandler() {
			return $this->cache->getWriteStreamHandler();
		}

		public function getReadStreamHandler() {
			return $this->cache->getReadStreamHandler();
		}

		public function getWriteFileStreamHandler() {
			return $this->cache->getWriteFileStreamHandler();
		}

		public function getReadFileStreamHandler() {
			return $this->cache->getReadFileStreamHandler();
		}

		public function getWriteMemMmapHandler() {
			return $this->cache->getWriteMemMmapHandler();
		}

		public function getReadMemMmapHandler() {
			return $this->cache->getReadMemMmapHandler();
		}	

		public function getWriteFileMmapHandler() {
			return $this->cache->getWriteFileMmapHandler();
		}

		public function getReadFileMmapHandler() {
			return $this->cache->getReadFileMmapHandler();
		}

		public function getWriteMemMmapStreamHandler() {
			return $this->cache->getWriteMemMmapStreamHandler();
		}

		public function getReadMemMmapStreamHandler() {
			return $this->cache->getReadMemMmapStreamHandler();
		}

		public function getWriteFileMmapStreamHandler() {
			return $this->cache->getWriteFileMmapStreamHandler();
		}

		public function getReadFileMmapStreamHandler() {
			return $this->cache->getReadFileMmapStreamHandler();
		}

		public function getWriteMemMmapFileHandler() {
			return $this->cache->getWriteMemMmapFileHandler();
		}

		public function getReadMemMmapFileHandler() {
			return $this->cache->getReadMemMmapFileHandler();
		}

		public function getWriteFileMmapFileHandler() {
			return $this->cache->getWriteFileMmapFileHandler();
		}

		public function getReadFileMmapFileHandler() {
			return $this->cache->getReadFileMmapFileHandler();
		}

		public function getWriteMemMmapFileStreamHandler() {
			return $this->cache->getWriteMemMmapFileStreamHandler();
		}

		public function getReadMemMmapFileStreamHandler() {
			return $this->cache->getReadMemMmapFileStreamHandler();
		}

		public function getWriteFileMmapFileStreamHandler() {
			return $this->cache->getWriteFileMmapFileStreamHandler();
		}

		public function getReadFileMmapFileStreamHandler() {
			return $this->cache->getReadFileMmapFileStreamHandler();
		}

		public function getWriteMemMmapFileMmapHandler() {
			return $this->cache->getWriteMemMmapFileMmapHandler();
		}

		public function getReadMemMmapFileMmapHandler() {
			return $this->cache->getReadMemMmapFileMmapHandler();
		}

		public function getWriteFileMmapFileMmapHandler() {
			return $this->cache->getWriteFileMmapFileMmapHandler();
		}

		public function getReadFileMmapFileMmapHandler() {
			return $this->cache->getReadFileMmapFileMmapHandler();
		}

		public function getWriteMemMmapFileMmapStreamHandler() {
			return $this->cache->getWriteMemMmapFileMmapStreamHandler();
		}

		public function getReadMemMmapFileMmapStreamHandler() {
			return $this->cache->getReadMemMmapFileMmapStreamHandler();
		}

		public function getWriteFileMmapFileMmapStreamHandler() {
			return $this->cache->getWriteFileMmapFileMmapStreamHandler();
		}

	}