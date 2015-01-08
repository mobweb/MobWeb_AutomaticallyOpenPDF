# MobWeb_AutomaticallyOpenPDF extension for Magento

After creating an invoice or shipment, the PDF for the current invoice or shipment is automatically opened, so that it can be downloaded or printed.

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Configuration

No configuration added for simplicity. If you would like to deactivate the automatic opening of the PDF for either the invoices or shipments, just comment out the relevant line in `Observer.php` (the one that starts with `Mage::getSingleton('core/session')` in either the `salesOrderInvoiceSaveAfter` or `salesOrderShipmentSaveAfter` method).

## How it works

We are observing the `sales_order_invoice_save_after` and `sales_order_shipment_save_after` events. Once these are fired, we save the ID of the current invoice or shipment in the session.

We are also observing the `controller_front_send_response_before` event, and we use it to check if the current page is the order page in the Admin Panel. If it is, we check if an invoice or shipment ID is stored in the session. If it is, we modify the response body to include Javascript that redirects to the invoice or shipment's "print" page after the body has been loaded.

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).