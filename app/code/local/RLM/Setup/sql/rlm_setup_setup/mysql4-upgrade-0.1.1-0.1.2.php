<?php
/* @var $installer RLM_Setup_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->setConfigData('design/footer/copyright', 'Copyright 2013 &copy; RaptorLovesMassacre | Designed by ByAr');

$content = <<<EOF
<span class="close"></span>
<h1>DELIVERY INFO</h1>

<strong>Shipping Lativa</strong>
<p>T-shirt - 2 LVL / 2.85 EUR.</p>
<p>Plugs - 2 LVL / 2.85 EUR.</p>
<p>Shipping 2 days and arrives at 3rd day.</p>

<strong>Shipping Europe</strong>
<p>T-shirt - 4 LVL / 5.7 EUR.</p>
<p>Plugs - 1.5 LVL / 2.2 EUR.</p>
<p>Shipment arrival 1 work week.</p>

<strong>Shipping USA</strong>
<p>T-shirts - 5 LVL / 7.2 EUR.</p>
<p>Plugs - 1.5 LVL / 2.2 EUR.</p>
<p>Once the order is placed, the item is shipped in 24 hours. + Please allow up to 14 working days from the date of ordering (Monday to Friday) for International orders.</p>

<div>
<p>Please allow approximately 2-3 working days from the date of ordering (Monday to Friday) for 'Latvia" orders.</p>
<p>Please allow approximately 5-10 working days from the date of ordering (Monday to Friday) for Europe orders.</p>
</div>

<div>
<p>Unfortunately we don't ship orders to the following countries: Belarus, Congo, Cote D'Ivoire, Cuba, Egypt, Eritrea, Guinea, Iran, Iraq, Liberia, Libya, Myanmar, Somalia, Sudan, Syrian Arab Republic, Tunisia and Zimbabwe.</p></div>
EOF;

$installer->addStaticBlock('delivery_info', 'Delivery info', $content);

$installer->endSetup();