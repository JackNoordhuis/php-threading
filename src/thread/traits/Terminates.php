<?php

/**
 * Terminates.php – threading-php
 *
 * Copyright (C) 2019 Jack Noordhuis
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Jack
 *
 */

declare(strict_types=1);

namespace pocketmine\thread\traits;

use function call_user_func;
use pocketmine\thread\TerminationInfo;

trait Terminates {

	/** @var callable */
	private static $terminationTraceBuilder = null;

	/** @var \pocketmine\thread\TerminationInfo|null */
	protected $terminationInfo = null;

	/**
	 * Set the function used to build the trace from exceptions.
	 *
	 * @param callable $function
	 */
	public static function setTerminationTraceBuilder(callable $function) {
		self::$terminationTraceBuilder = $function;
	}

	/**
	 * Get information termination about termination of the thread.
	 *
	 * @return \pocketmine\thread\TerminationInfo
	 */
	public function getTerminationInfo() : ?TerminationInfo {
		return $this->terminationInfo;
	}

	/**
	 * Set the termination reason.
	 *
	 * @param \Throwable $e
	 */
	protected function terminate(\Throwable $e) : void {
		$trace = "";
		if(self::$terminationTraceBuilder !== null) {
			$trace = call_user_func(self::$terminationTraceBuilder, $e->getTrace());
		}
		$this->terminationInfo = new TerminationInfo($e->getMessage(), $e->getFile(), $e->getLine(), $trace);
	}

}