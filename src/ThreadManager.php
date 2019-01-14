<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine;

use Generator;
use Logger;

/**
 * Class that keeps track of all the threads
 */
class ThreadManager {

	/** @var ThreadManager */
	private static $instance = null;

	public static function init() : void {
		self::$instance = new ThreadManager();
	}

	/**
	 * @return ThreadManager
	 */
	public static function getInstance() : ThreadManager {
		return self::$instance;
	}

	/**
	 * @param Worker|Thread $thread
	 */
	public function add($thread) : void {
		if($thread instanceof Thread or $thread instanceof Worker) {
			$this->{spl_object_hash($thread)} = $thread;
		}
	}

	/**
	 * @param Worker|Thread $thread
	 */
	public function remove($thread) : void {
		if($thread instanceof Thread or $thread instanceof Worker) {
			unset($this->{spl_object_hash($thread)});
		}
	}

	/**
	 * @return Worker[]|Thread[]
	 */
	public function getAll() : array {
		$array = [];
		foreach($this as $key => $thread) {
			$array[$key] = $thread;
		}

		return $array;
	}

	/**
	 * @param int $erroredThreads
	 *
	 * @return \Generator
	 */
	public function stopAll(int &$erroredThreads = 0) : Generator {
		foreach($this->getAll() as $thread) {
			yield "Stopping " . $thread->getThreadName() . " thread";
			try {
				$thread->quit();
				yield $thread->getThreadName() . " thread stopped successfully.";
			} catch(\ThreadException $e) {
				++$erroredThreads;
				yield "Could not stop " . $thread->getThreadName() . " thread: " . $e->getMessage();
			}
		}
	}

}