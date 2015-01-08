<?php

class MobWeb_AutomaticallyOpenPDF_Model_Observer
{
	public function salesOrderInvoiceSaveAfter($observer)
	{
		// After an invoice has been created, save its ID in the session
		Mage::getSingleton('core/session')->setPrintInvoiceId($observer->getInvoice()->getId());
	}

	public function salesOrderShipmentSaveAfter($observer)
	{
		// After a shipment has been created, save its ID in the session
		Mage::getSingleton('core/session')->setPrintShipmentId($observer->getShipment()->getId());
	}

	public function controllerFrontSendResponseBefore($observer)
	{
		// Every time a page is loaded, check if it's an order view page in the adminhtml
		if(Mage::app()->getRequest()->getRouteName() === "adminhtml" && Mage::app()->getRequest()->getActionName() === "view" && Mage::app()->getRequest()->getControllerName() === "sales_order") {

			// Check if a shipment PDF has to be opened
			if(($printShipmentId = Mage::getSingleton('core/session')->getPrintShipmentId()) && $printShipmentId > 1) {

				// Unset the session variable
				Mage::getSingleton('core/session')->unsPrintShipmentId();

				// Get the redirect URL that redirects to the PDF for this shipment
				$redirectUrl = Mage::helper('adminhtml')->getUrl('*/sales_order_shipment/print', array('invoice_id' => $printShipmentId));

				// Inject a JS redirection into the response body
				$response = $observer->getFront()->getResponse();
				$responseBody = $response->getBody() . Mage::helper('automaticallyopenpdf')->getJavascriptPopupScript($redirectUrl);
				$response->setBody($responseBody);
			}

			// Check if an invoice PDF has to be opened
			if(($printInvoiceId = Mage::getSingleton('core/session')->getPrintInvoiceId()) && $printInvoiceId > 1) {

				// Unset the session variable
				Mage::getSingleton('core/session')->unsPrintInvoiceId();

				// Get the redirect URL that redirects to the PDF for this shipment
				$redirectUrl = Mage::helper('adminhtml')->getUrl('*/sales_order_invoice/print', array('invoice_id' => $printInvoiceId));

				// Inject a JS redirection into the response body
				$response = $observer->getFront()->getResponse();
				$responseBody = $response->getBody() . Mage::helper('automaticallyopenpdf')->getJavascriptPopupScript($redirectUrl);
				$response->setBody($responseBody);
			}
		}
	}
}