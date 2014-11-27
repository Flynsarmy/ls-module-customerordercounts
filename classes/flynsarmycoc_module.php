<?php

class FlynsarmyCOC_Module extends Core_ModuleBase
{

     /**
     * Creates the module information object
     * @return Core_ModuleInfo
     */
    protected function createModuleInfo()
    {
      return new Core_ModuleInfo(
        "Cusotmer Order Counts",
        "Adds an 'Order Count' column to the customers list in admin",
        "Flynsarmy" );
    }

	public function subscribeEvents()
	{
		Backend::$events->addEvent('shop:onExtendCustomerModel', $this, 'extend_customer_model');
		Backend::$events->addEvent('shop:onExtendOrderModel', $this, 'extend_order_model');
	}

	public function extend_customer_model($customer, $context)
	{
		$customer->calculated_columns['flynsarmycoc_order_count'] = array('sql'=>'select count(shop_orders.id) from shop_orders where shop_orders.customer_id=shop_customers.id', 'type'=>db_number);
		$customer->define_column('flynsarmycoc_order_count', 'Orders')->defaultInvisible()->listTitle('Orders');
	}

	public function extend_order_model($order, $context)
	{
		$order->calculated_columns['flynsarmycoc_order_count'] = array('sql'=>'select count(so2.id) from shop_orders so2 where so2.customer_id=shop_orders.customer_id', 'type'=>db_number);
		$order->define_column('flynsarmycoc_order_count', 'Orders')->defaultInvisible()->listTitle('Orders');
	}
}
?>