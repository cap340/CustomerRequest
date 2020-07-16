<?php

namespace Cap\CustomerRequest\Helper;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_EMAIL_ADMIN_NOTIFY = 'cap_customer_request/email/admin_notify';
    const XML_PATH_EMAIL_ADMIN_SENDER = 'cap_customer_request/email/sender';
    const XML_PATH_EMAIL_ADMIN_TEMPLATE = 'cap_customer_request/email/template';

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Email constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    /**
     * @param $emailData
     */
    public function sendEmailAdmin($emailData)
    {
        $emailTemplate = $this->getConfigEmailAdminTemplate();
        $adminEmail = $this->getConfigEmailAdminNotify();
        $adminEmails = explode(',', $adminEmail);
        $countEmail = count($adminEmails);
        if ($countEmail > 1) {
            foreach ($adminEmails as $value) {
                $value = str_replace(' ', '', $value);
                $emailTemplateData = [
                    'adminEmail' => $value,
                    'requestId' => $emailData['requestId'],
                    'customerName' => $emailData['customerName'],
                    'customerEmail' => $emailData['customerEmail'],
                    'message' => $emailData['message'],
                    'productSku' => $emailData['productSku'],
                    'productName' => $emailData['productName'],
                    'createdAt' => $emailData['createdAt'],
                ];
                $this->sendEmail($value, $emailTemplate, $emailTemplateData);
            }
        } else {
            $emailTemplateData = [
                'adminEmail' => $adminEmail,
                'requestId' => $emailData['requestId'],
                'customerName' => $emailData['customerName'],
                'customerEmail' => $emailData['customerEmail'],
                'message' => $emailData['message'],
                'productSku' => $emailData['productSku'],
                'productName' => $emailData['productName'],
                'createdAt' => $emailData['createdAt'],
            ];
            $this->sendEmail($adminEmail, $emailTemplate, $emailTemplateData);
        }
    }

    /**
     * @return mixed
     */
    public function getConfigEmailAdminTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_ADMIN_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getConfigEmailAdminNotify()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_ADMIN_NOTIFY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param $receivers
     * @param $emailTemplate
     * @param $templateVar
     */
    private function sendEmail($receivers, $emailTemplate, $templateVar)
    {
        try {
            $email = $this->getConfigEmailAdminSender();
            $emailValue = 'trans_email/ident_' . $email . '/email';
            $emailNameValue = 'trans_email/ident_' . $email . '/name';
            $emailNameSender = $this->scopeConfig->getValue(
                $emailNameValue,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $emailSender = $this->scopeConfig->getValue(
                $emailValue,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml($emailNameSender),
                'email' => $this->escaper->escapeHtml($emailSender),
            ];

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($emailTemplate)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($templateVar)
                ->setFrom($sender)
                ->addTo($receivers);

            $transport = $transport->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();

        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addErrorMessage(__('Failed to send email.' . $e->getMessage()));
            return;
        }
    }

    /**
     * @return mixed
     */
    public function getConfigEmailAdminSender()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_ADMIN_SENDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
