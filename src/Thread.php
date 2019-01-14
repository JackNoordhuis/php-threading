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

use jacknoordhuis\Autoload\ThreadedClassLoader;
use pocketmine\thread\traits\Terminates;

/**
 * This class must be extended by all custom threading classes
 */
class Thread extends \Thread {
	use Terminates;

	/** @var \jacknoordhuis\Autoload\ThreadedClassLoader */
	protected $classLoader;

	/** @var bool */
	protected $isKilled = false;

	/**
	 * @return \jacknoordhuis\Autoload\ThreadedClassLoader
	 */
	public function getClassLoader() {
		return $this->classLoader;
	}

	/**
	 * @param \jacknoordhuis\Autoload\ThreadedClassLoader $classLoader
	 */
	public function setClassLoader(ThreadedClassLoader $classLoader) : void {
		$this->classLoader = $classLoader;
	}

	/**
	 * Registers the class loader for this thread.
	 *
	 * WARNING: This method MUST be called from any child threads' run() method to make auto-loading usable.
	 * If you do not do this, you will not be able to use new classes that were not loaded when the thread was started
	 * (unless you are using a custom autoloader).
	 */
	public function registerClassLoader() : void {
		if($this->classLoader !== null) {
			$this->classLoader->register(false);
		}
	}

	public function start(?int $options = \PTHREADS_INHERIT_ALL) {
		ThreadManager::getInstance()->add($this);

		if(!$this->isRunning() and !$this->isJoined() and !$this->isTerminated()) {
			return parent::start($options);
		}

		return false;
	}

	/**
	 * Stops the thread using the best way possible. Try to stop it yourself before calling this.
	 */
	public function quit() : void {
		$this->isKilled = true;

		$this->notify();

		if(!$this->isJoined()) {
			if(!$this->isTerminated()) {
				$this->join();
			}
		}

		ThreadManager::getInstance()->remove($this);
	}

	public function getThreadName() : string {
		return (new \ReflectionClass($this))->getShortName();
	}

}