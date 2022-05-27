<?php
namespace LeoC\UrgencyPDP\Block;

class UrgencyBlock extends \Magento\Framework\View\Element\Template
{
	public $registry;
	public $timezone;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\Stdlib\DateTime\Timezone $timezone,
		array $data = []
	) {
		$this->registry = $registry;
		$this->timezone = $timezone;
		parent::__construct($context, $data);
	}
	
	/**
	* Uso questo metodo nel phtml per attivare la urgency
	* solo se il prodotto ha questo attributo ed è attivo.
	*/
	public function getCurrentProduct()
	{
		return $this->registry->registry('current_product');
	}

	/**
	* Uso questo metodo nel phtml per passare la timezone
	* del negozio al timer JavaScript.
	*/
	public function getStoreTimezone()
	{
		return $this->timezone->getConfigTimezone();
	}
}