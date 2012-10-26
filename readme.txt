------------------Open Cart Module Notes------------------
Module built for Version: 1.5.2.1 20120322

Consists of the following files:
catalog/controller/payment/ipay.php
catalog/model/payment/ipay.php
catalog/language/english/payment/ipay.php
catalog/view/theme/default/template/payment/ipay.tpl
admin/controller/payment/ipay.php
admin/language/english/payment/ipay.php
admin/view/template/payment/ipay.tpl


After copying these files to the correct locations as indicated, in the Open Cart Administration backend go to Extensions->Payments
Find the ipay entry and click [Install], then click [Edit]
Enter the ipay ID you received from ipay
Enter the ipay Gateway you received from ipay
Test mode on/off as appropriate.
Total is a Open Cart function that will only allow this payment method if the total order reaches a certain amount leave blank is you always want ipay to be an option.
Order Status is what an order should be set to after a successful transaction, the options are Complete or Processing.
Geo Zone allows you to restrict ipay to be only used be people from certain parts of the world; these can be set up by following the main Open Cart documentation, or just leave it set to All Zones.
Status is whether ipay is currently able to be used by your customers should be enabled.
Sort order is for setting the order in which various payment options are displayed.

This extension was based on the payfast opencart module and is released under the GPL license.
