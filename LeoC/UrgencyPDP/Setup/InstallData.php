<?php
namespace LeoC\UrgencyPDP\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create();
		$eavSetup->addAttribute(
			Product::ENTITY,
			'urgency_pdp',
			[
				'group' => 'General',
				'type' => 'int',
				'label' => 'Urgency Promo',
				'input' => 'boolean',
				'source' => 'LeoC\UrgencyPDP\Model\Attribute\Source\Urgency',
				/*'frontend' => 'LeoC\UrgencyPDP\Model\Attribute\Frontend\Urgency',*/
				/*'backend' => 'LeoC\UrgencyPDP\Model\Attribute\Backend\Urgency',*/
				'required' => false,
				'sort_order' => 50,
				'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
				'is_used_in_grid' => false,
				'is_visible_in_grid' => false,
				'is_filterable_in_grid' => false,
				'visible' => true,
				'is_html_allowed_on_front' => true,
				'visible_on_front' => false
			]
		);
	}
}
