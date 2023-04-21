<?php declare(strict_types=1);

namespace OrderScheduler\Subscriber;
use Shopware\Core\Checkout\Customer\CustomerEvents;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\Content\MailTemplate\MailTemplateEvents;
use Shopware\Core\Framework\Adapter\Translation\Translator;

class OrderCustomerSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityRepositoryInterface
     */
    private $addressRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private $mailTemplateTypeRepository;

    /**
     * @var Translator
     */
    private $translator;

    public function __construct(
        EntityRepositoryInterface $addressRepository,
        EntityRepositoryInterface $mailTemplateTypeRepository,
        Translator $translator
    )
    {
        $this->addressRepository = $addressRepository;
        $this->mailTemplateTypeRepository = $mailTemplateTypeRepository;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents(): array
    {
        // Return the events to listen to as array like this:  <event to listen to> => <method to execute>
        return [
            CustomerEvents::CUSTOMER_LOADED_EVENT => 'onCustomerLoaded',
            MailTemplateEvents::MAIL_TEMPLATE_LOADED_EVENT => 'onMailLoaded'

        ];
    }

    public function onCustomerLoaded(EntityLoadedEvent $event)
    {
        if(!empty($event->getEntities())){
            foreach($event->getEntities() as $customerData){
                $criteria = new Criteria();
                $criteria->addFilter(new EqualsFilter('customerId',$customerData->getId()));
                $criteria->addAssociation('country');
                $criteria->addAssociation('countryState');
                $userData = $this->addressRepository->search($criteria, Context::createDefaultContext())->getElements();
                $customerData->addExtension('address', new ArrayEntity(['all' => $userData]));
            }
        }
    }
    public function onMailLoaded(EntityLoadedEvent $events)
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('technicalName','order_confirmation_mail'));
        $mailTemplateTypeData = $this->mailTemplateTypeRepository->search($criteria, Context::createDefaultContext())->first();
        foreach($events->getEntities() as $emailData){
            if($emailData->getMailTemplateTypeId() == $mailTemplateTypeData->getId()){
                $string = '{{ lineItem.payload.productNumber|u.wordwrap(80) }}{% endif %}<br>';
                $string .= '{% if lineItem.payload.fromDate is defined %}'.$this->translator->trans('orderScheduler.label-from').' : {{ lineItem.payload.fromDate }} '.$this->translator->trans('orderScheduler.label-until').' : {{ lineItem.payload.untilDate }} , {{ lineItem.payload.weeks }} , '.$this->translator->trans('orderScheduler.label-on').' {{ lineItem.payload.days }}  {% endif %} <br>';
                $string .= '{% if lineItem.payload.address is defined %}'.$this->translator->trans('orderScheduler.label-address').' : {{ lineItem.payload.address }}{% endif %} <br>';
                $html2 = $emailData->getTranslated()['contentHtml'];
                $newHtml2 = str_replace("{{ lineItem.payload.productNumber|u.wordwrap(80) }}{% endif %}",$string,$html2);
                $translatedData =  $emailData->getTranslated();
                $translatedData['contentHtml'] = $newHtml2;
                $emailData->setTranslated($translatedData);
            }
        }
    }
}
