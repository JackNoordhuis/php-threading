<?php

/**
 * TerminationInfo.php – threading-php
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

namespace pocketmine\thread;

class TerminationInfo {

	/** @var string */
	protected $message;

	/** @var string */
	protected $file;

	/** @var int */
	protected $line;

	/** @var string */
	protected $trace;

	public function __construct(string $message, string $file, int $line, string $trace) {
		$this->message = $message;
		$this->file = $file;
		$this->line = $line;
		$this->trace = $trace;
	}


	/**
	 * @return string
	 */
	public function getMessage() : string {
		return $this->message;
	}

	/**
	 * @return string
	 */
	public function getFile() : string {
		return $this->file;
	}

	/**
	 * @return int
	 */
	public function getLine() : int {
		return $this->line;
	}

	/**
	 * @return string
	 */
	public function getTrace() : string {
		return $this->trace;
	}

}