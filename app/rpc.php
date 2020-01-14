<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace rpc\contract\OperationService;

interface OperationInterface
{
	const RPC = 'OperationService';

	/**
	 * 加法运算
	 *
	 * @param [type] $a
	 * @param [type] $b
	 * @return void
	 */
	public function add($a, $b);
}
