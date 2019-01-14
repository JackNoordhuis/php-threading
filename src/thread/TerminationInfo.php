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
	protected $class;

	/** @var string */
	protected $message;

	/** @var string */
	protected $file;

	/** @var int */
	protected $line;

	/** @var array */
	protected $trace;

	public function __construct(string $class, string $message, string $file, int $line, array $trace) {
		$this->class = $class;
		$this->message = $message;
		$this->file = $file;
		$this->line = $line;
		$this->trace = $trace;
	}

	/**
	 * @return string
	 */
	public function getClass() : string {
		return $this->class;
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
	 * @return array
	 */
	public function getTrace() : array {
		return $this->trace;
	}

}