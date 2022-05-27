<?php
namespace LeoC\UrgencyPDP\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Boolean;

class Urgency extends Boolean
{
	const VALUE_YES = 1;
	const VALUE_NO = 0;

	public function getAllOptions()
	{
		if (!$this->_options) {
			$this->_options = [
				['label' => __('Yes'), 'value' => self::VALUE_YES],
				['label' => __('No'), 'value' => self::VALUE_NO],
			];
		}
		return $this->_options;
	}
}