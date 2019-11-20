<?php

namespace Iweb\Note\Model\Rewrite\Order\Pdf;

use \Magento\Sales\Model\Order\Pdf\Invoice as CoreInvoice;

class Invoice extends CoreInvoice
{
    public function getPdf($invoices = [])
    {
        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');

        $pdf = new \Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $this->_setFontBold($style, 10);

        foreach ($invoices as $invoice) {
            if ($invoice->getStoreId()) {
                $this->_localeResolver->emulate($invoice->getStoreId());
                $this->_storeManager->setCurrentStore($invoice->getStoreId());
            }
            $page = $this->newPage();
            $order = $invoice->getOrder();
            /* Add image */
            $this->insertLogo($page, $invoice->getStore());
            /* Add address */
            $this->insertAddress($page, $invoice->getStore());
            /* Add head */
            $this->insertOrder(
                $page,
                $order,
                $this->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );
            /* Add document text and number */
            $this->insertDocumentNumber($page, __('Invoice # ') . $invoice->getIncrementId());
            /* Add table */
            $this->_drawHeader($page);
            /* Add body */
            foreach ($invoice->getAllItems() as $item) {
                if ($item->getOrderItem()->getParentItem()) {
                    continue;
                }
                /* Draw item */
                $this->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
            /* Add totals */
            $this->insertTotals($page, $invoice);
            if ($invoice->getStoreId()) {
                $this->_localeResolver->revert();
            }
            if ($deliveryNote = $order->getDeliveryNote()) {
                $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
                $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
                $page->setLineWidth(0.5);
                $page->drawRectangle(25, $this->y , 570, $this->y - 20);
                $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                $this->_setFontBold($page, 12);
                $page->drawText('Delivery Note: ', 35, $this->y - 15, 'UTF-8');
                $this->_setFontRegular($page, 10);
                $page->drawText($deliveryNote, 35, $this->y - 35, 'UTF-8');
                $page->drawLine(25, $this->y - 20, 25, $this->y - 45);
                $page->drawLine(25, $this->y - 45, 570, $this->y - 45);
                $page->drawLine(570, $this->y - 45, 570, $this->y - 20);
            }
        }
        $this->_afterGetPdf();
        return $pdf;
    }
}
