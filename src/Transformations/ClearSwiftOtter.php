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
 * @copyright SwiftOtter Studios, 12/5/16
 * @package default
 **/

namespace Driver\Magento2\Transformations;

use Driver\Commands\CommandInterface;
use Driver\Engines\MySql\Sandbox\Connection;
use Driver\Engines\MySql\Sandbox\Utilities;
use Driver\Pipeline\Environment\EnvironmentInterface;
use Driver\Pipeline\Transport\Status;
use Driver\Pipeline\Transport\TransportInterface;
use Symfony\Component\Console\Command\Command;

class ClearSwiftOtter extends Command implements CommandInterface
{
    use ClearTrait;

    protected $utilities;
    private $properties;

    protected $tablesToClear = [
//        'swiftotter_adminhtml_token',
//        'swiftotter_inventory_adjustment_log',
//        'swiftotter_report_product_sale_region',
//        'swiftotter_sales_order_product',
//        'swiftotter_search_cache',
//        'swiftotter_strikeiron_salestax_record'
    ];

    public function __construct(Utilities $utilities, array $properties = [])
    {
        $this->utilities = $utilities;
        $this->properties = $properties;

        parent::__construct('m2-clear-clear-swiftotter');
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function go(TransportInterface $transport, EnvironmentInterface $environment)
    {
        $this->clear($environment);
        return $transport->withStatus(new Status('m2-clear-clear-swiftotter', 'success'));
    }
}