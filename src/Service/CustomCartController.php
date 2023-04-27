<?php declare(strict_types=1);

namespace OrderScheduler\Service;

use DateTime;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Checkout\Cart\Cart;

/**
 * @RouteScope(scopes={"storefront"})
 */
class CustomCartController extends StorefrontController
{
    /**
     * @var CustomCartHandler
     */
    private $factory;

    /**
     * @var CartService
     */
    private $cartService;

    public function __construct(CustomCartHandler $factory, CartService $cartService)
    {
        $this->factory = $factory;
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cartAdd", name="frontend.custom.addtocart", methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function add(Cart $cart, SalesChannelContext $context, RequestDataBag $requestDataBag, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $options = array();
        $finalDatesWithday = [];
        $lineItems = $request->request->get('lineItems', []);
        $product = \reset($lineItems);
        $optionsarray = array();
        $optionsarray['address'] = $requestDataBag->get('option')->get('address');
        $optionsarray['fromDate'] = $requestDataBag->get('option')->get('fromDate');
        $optionsarray['untilDate'] = $requestDataBag->get('option')->get('untilDate');
        $optionsarray['weeks'] = $requestDataBag->get('option')->get('weeks');
        $days = $requestDataBag->get('option')->get('day', []);
        $days = \reset($days);
        if (!empty($days)) {
            $optionsarray['days'] = implode(', ', $days);
        } else {
            $optionsarray['days'] = '';
        }

        // input start and end date
        $startDate = $optionsarray['fromDate'];
        $endDate = $optionsarray['untilDate'];

        $resultDays = array('Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
            'Sunday' => 0);

        // change string to date time object
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        // iterate over start to end date
        while ($startDate <= $endDate) {
            // find the timestamp value of start date
            $timestamp = strtotime($startDate->format('d-m-Y'));

            // find out the day for timestamp and increase particular day
            $weekDay = date('l', $timestamp);

            $resultDays[$weekDay] = $resultDays[$weekDay] + 1;
            // increase startDate by 1
            $startDate->modify('+1 day');
        }
//        $totalQuantity = 0;
        $finalArray = [];
        $datesWithdays = array();
        foreach ($days as $day) {
            foreach ($resultDays as $key => $resultDay) {
                if ($key == $day) {
                    $quantityCount = $product['quantity'] * $resultDay;
                    array_push($finalArray, $quantityCount);
                }
            }
            //        Extra=============>
            $date = new DateTime($optionsarray['fromDate']);
            $end = new DateTime($optionsarray['untilDate']);
            $day_of_week = strtolower($day);
            while ($date <= $end) {
                $day = strtolower($date->format('l'));
                if ($day == $day_of_week) {
                    $datesWithdays[$day][] = array(
                    'date' => $date->format('Y-m-d'),
                    'day_name' => $date->format('l')
                );
                }
                $date->modify('+1 day');
            }
        }
//        $totalQuantity = array_sum($finalArray);

        $oneWeekArray = [];
        if($optionsarray['weeks'] == 'One Week'){
            foreach ($datesWithdays as $datesWithday){
                foreach ($datesWithday as $diffDay){
                    $finalDatesWithday[] = $diffDay;
                }
                $totalQuantity = count($finalDatesWithday);
            }
        }elseif($optionsarray['weeks'] == 'Two Weeks'){
            foreach ($datesWithdays as $datesWithday){
                // Remove elements at odd indices
                foreach ($datesWithday as $index => $value) {
                    if ($index % 2 == 0) {
                        $finalDatesWithday[] = $value;
                    }
                }
                $totalQuantity = count($finalDatesWithday);
            }
        }elseif($optionsarray['weeks'] == 'Three Weeks'){
            foreach ($datesWithdays as $datesWithday){
                foreach ($datesWithday as $index => $value) {
                    if ($index % 3 == 0) {
                        $finalDatesWithday[] = $value;
                    }
                }
                $totalQuantity = count($finalDatesWithday);
            }
        }elseif($optionsarray['weeks'] == 'Four Weeks'){
            foreach ($datesWithdays as $datesWithday){
                foreach ($datesWithday as $index => $value) {
                    if ($index % 4 == 0) {
                        $finalDatesWithday[] = $value;
                    }
                }
                $totalQuantity = count($finalDatesWithday);
            }
        }elseif($optionsarray['weeks'] == 'Five Weeks'){
            foreach ($datesWithdays as $datesWithday){
                foreach ($datesWithday as $index => $value) {
                    if ($index % 5 == 0) {
                        $finalDatesWithday[] = $value;
                    }
                }
                $totalQuantity = count($finalDatesWithday);
            }
        }
        $lineItem = $this->factory->create([
            'type' => LineItem::PRODUCT_LINE_ITEM_TYPE, // Results in 'product'
            'referencedId' => $product['referencedId'], // this is not a valid UUID, change this to your actual ID!
            'quantity' => $totalQuantity,
            'payload' => $requestDataBag->get('option')
        ], $context);
        $lineItem->setRemovable(true);
        $lineItem->setStackable(true);
        $lineItem->setPayload([
        'productNumber'=>$optionsarray,
        'finalDatesWithday'=>$finalDatesWithday]);

        $this->cartService->add($cart, $lineItem, $context);

        return $this->finishAction($cart, $request);
    }

    private function finishAction(Cart $cart, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        return $this->createActionResponse($request);

    }
}
