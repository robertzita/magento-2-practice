<?php

namespace Iweb\Note\Plugin\Adminhtml;

class InsertDeliveryNoteToInvoicePdf 
{
    public function afterGetPdf(\Magento\Sales\Model\Order\Pdf\Invoice $subject, \Zend_Pdf $pdf, $invoices = [])
    {
        foreach ($invoices as $_invoice) {
            if($deliveryNote = $_invoice->getOrder()->getDeliveryNote()) {
                $page = end($pdf->pages);
                $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
                $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
                $page->setLineWidth(0.5);
                $page->drawRectangle(25, $subject->y , 570, $subject->y - 20);
                $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                $page->drawText('Delivery Note: ', 35, $subject->y - 15, 'UTF-8');
                $page->drawText($deliveryNote, 35, $subject->y - 35, 'UTF-8');
                $page->drawLine(25, $subject->y - 20, 25, $subject->y - 45);
                $page->drawLine(25, $subject->y - 45, 570, $subject->y - 45);
                $page->drawLine(570, $subject->y - 45, 570, $subject->y - 20);
            }
        }
        return $pdf;
    }
}
