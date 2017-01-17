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

class ClearOrders extends Command implements CommandInterface
{
    use ClearTrait;

    protected $utilities;
    private $properties;

    protected $tablesToClear = [
        'sales_creditmemo',
        'sales_creditmemo_comment',
        'sales_creditmemo_grid',
        'sales_creditmemo_item',
        'sales_invoice',
        'sales_invoice_comment',
        'sales_invoice_grid',
        'sales_invoice_item',
        'sales_order',
        'sales_order_address',
        'sales_order_grid',
        'sales_order_item',
        'sales_order_payment',
        'sales_order_status_history',
        'sales_shipment',
        'sales_shipment_comment',
        'sales_shipment_grid',
        'sales_shipment_item',
        'sales_shipment_track',
        'sales_invoiced_aggregated',
        'sales_invoiced_aggregated_order',
        'sales_shipping_aggregated',
        'sales_shipping_aggregated_order',
        'sales_payment_transaction',
        'sales_order_aggregated_created',
        'sales_order_aggregated_updated',
        'sales_order_tax',
        'sales_order_tax_item',
        'sendfriend_log',
        'wishlist',
        'report_event',
    ];

    public function __construct(Utilities $utilities, array $properties = [])
    {
        $this->utilities = $utilities;
        $this->properties = $properties;

        parent::__construct('m2-clear-clear-orders');
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function go(TransportInterface $transport, EnvironmentInterface $environment)
    {
        $this->clear($environment);
        return $transport->withStatus(new Status('m2-clear-clear-orders', 'success'));
    }
}