<?php
/*
 * This file is part of the Address Validation package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\AddressValidation\Lib;

interface Contract
{
    /**
     * Validate whether a given address is valid.
     * @param  string $address
     * @return Mixed
     */
    public function validate(string $address);

    /**
     * Retrieve the place information.
     * @return collection
     */
    public function retrieve();

    /**
     * Retrieve the 'lat' and 'lng' for a given place.
     * @return array
     */
     public function location();
}
