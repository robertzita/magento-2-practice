<?php

namespace Iweb\Support\Ui\Component\Listing\Support\Column;

class SupportActions extends \Magento\Ui\Component\Listing\Columns\Column
{
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
                if (isset($item['id']) && $item['solved'] == 'no') {
                    $item[$this->getData('name')] = [
                        'reply' => [
                            'href' => $this->urlBuilder->getUrl(
                                'support/supportpage/reply',
                                [
                                    'support_id' => $item['id']
                                ]
                            ),
                            'label' => __('View replies')
                        ]
                    ];
                } else {
                    $item[$this->getData('name')] = [
                        'reply' => [
                            'href' => $this->urlBuilder->getUrl(
                                'support/supportpage/reply',
                                [
                                    'support_id' => $item['id']
                                ]
                            ),
                            'label' => __('View replies')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                'support/supportpage/delete',
                                [
                                    'support_id' => $item['id'] 
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $item['title']),
                                'message' => __('Are you sure you want to delete a %1 record?', $item['title']),
                            ],
                            'post' => true,
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
