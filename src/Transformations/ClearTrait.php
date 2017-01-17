<?php
/**
 * SwiftOtter_Base is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SwiftOtter_Base is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with SwiftOtter_Base. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Joseph Maxwell
 * @copyright SwiftOtter Studios, 12/17/16
 * @package default
 **/

namespace Driver\Magento2\Transformations;

use Driver\Engines\MySql\Sandbox\Utilities;
use Driver\Pipeline\Environment\EnvironmentInterface;

trait ClearTrait
{
    /** @var Utilities $utilities */
    protected $utilities;

    public function clear(EnvironmentInterface $environment)
    {
        array_walk($this->tablesToClear, function ($table) use ($environment) {
            $formattedTable = $this->utilities->tableName($table);

            $environment->addIgnoredTable($formattedTable);
            $this->utilities->clearTable($formattedTable);
        });
    }
}