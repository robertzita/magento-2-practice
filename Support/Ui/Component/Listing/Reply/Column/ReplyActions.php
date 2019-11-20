<?php

namespace Iweb\Support\Ui\Component\Listing\Reply\Column;

class ReplyActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_EDIT   = 'support/reply/edit';
    const URL_PATH_DELETE = 'support/reply/delete';
    
    protected $urlBuilder;
    
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []    
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if(isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'reply_id' => $item['id'],
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'reply_id' => $item['id'],
                                ]
                            ),
                            'label' => __('Delete')
                        ]
                    ];
                } 
            }
        }
        return $dataSource;
    }
}
