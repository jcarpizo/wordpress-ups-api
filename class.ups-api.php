<?php

class UpsApi extends WP_REST_Controller
{

    const ACCESS_KEY = null;
    const USER_ID = null;
    const PASSWORD = null;

    private $shipment = null;

    public function __construct(\Ups\Entity\Shipment $shipment)
    {

    }

    public function init()
    {
        if (!function_exists('register_rest_route')) {
            return false;
        }

        register_rest_route('ups/v1', '/shipment', [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => array('UpsApi', 'post_shipment_details'),
                ]
            ]
        );

        register_rest_route('ups/v1', '/print/label', [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => array('UpsApi', 'print_ups_label'),
                    'args' => [
                        [
                            'orderId' => [
                                'validate_callback' => 'is_numeric'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    public function post_shipment_details($request)
    {

        $requestData = $request->get_params();

        $shipment = new Ups\Entity\Shipment;
        $shipper = $shipment->getShipper();
        $shipper->setShipperNumber($requestData->shipper_number);
        $shipper->setName($requestData->shipment_name);
        $shipper->setAttentionName($requestData->shipment_name);
        $shipperAddress = $shipper->getAddress();
        $shipperAddress->setAddressLine1($requestData->shipment_address);
        $shipperAddress->setPostalCode($requestData->shipment_postal_code);
        $shipperAddress->setCity($requestData->city);
        $shipperAddress->setStateProvinceCode($requestData->shipment_province_code); // required in US
        $shipperAddress->setCountryCode($requestData->shipment_country_code);
        $shipper->setAddress($shipperAddress);
        $shipper->setEmailAddress($requestData->shipment_email_address);
        $shipper->setPhoneNumber($requestData->shipment_phone_number);
        $shipment->setShipper($shipper);


        // To address
        $address = new \Ups\Entity\Address();
        $address->setAddressLine1($requestData->toaddress_one);
        $address->setPostalCode($requestData->toaddress_postal_code);
        $address->setCity($requestData->toaddress_city);
        $address->setStateProvinceCode($requestData->toaddress_province_code);  // Required in US
        $address->setCountryCode($requestData->toaddress_country_code);
        $shipTo = new \Ups\Entity\ShipTo();
        $shipTo->setAddress($address);
        $shipTo->setCompanyName($requestData->tocompany_name);
        $shipTo->setAttentionName($requestData->toaddress_attention_name);
        $shipTo->setEmailAddress($requestData->toaddress_email);
        $shipTo->setPhoneNumber($requestData->toaddress_phone_number);
        $shipment->setShipTo($shipTo);


        // From address
        $address = new \Ups\Entity\Address();
        $address->setAddressLine1($requestData->fromaddress_one);
        $address->setPostalCode($requestData->fromaddress_postal_code);
        $address->setCity($requestData->fromaddress_city);
        $address->setStateProvinceCode($requestData->fromaddress_province_code);
        $address->setCountryCode($requestData->fromaddress_country_code);
        $shipFrom = new \Ups\Entity\ShipFrom();
        $shipFrom->setAddress($address);
        $shipFrom->setName($requestData->fromcompany_name);
        $shipFrom->setAttentionName($shipFrom->getName());
        $shipFrom->setCompanyName($shipFrom->getName());
        $shipFrom->setEmailAddress($requestData->fromaddress_email);
        $shipFrom->setPhoneNumber($requestData->fromaddress_phone_number);
        $shipment->setShipFrom($shipFrom);

        // Sold to
        $address = new \Ups\Entity\Address();
        $address->setAddressLine1($requestData->soldaddress_one);
        $address->setPostalCode($requestData->soldaddress_postal_code);
        $address->setCity($requestData->soldaddress_city);
        $address->setCountryCode($requestData->soldaddress_country_code);
        $address->setStateProvinceCode($requestData->soldaddress_province_code);
        $soldTo = new \Ups\Entity\SoldTo;
        $soldTo->setAddress($address);
        $soldTo->setAttentionName($requestData->soldaddress_attention_name);
        $soldTo->setCompanyName($soldTo->getAttentionName());
        $soldTo->setEmailAddress($requestData->soldaddress_email);
        $soldTo->setPhoneNumber($requestData->soldaddress_phone_number);
        $shipment->setSoldTo($soldTo);

        // Set service
        $service = new \Ups\Entity\Service;
        $service->setCode(\Ups\Entity\Service::S_STANDARD);
        $service->setDescription($service->getName());
        $shipment->setService($service);

        // Mark as a return (if return)
        if ($return) {
            $returnService = new \Ups\Entity\ReturnService;
            $returnService->setCode(\Ups\Entity\ReturnService::PRINT_RETURN_LABEL_PRL);
            $shipment->setReturnService($returnService);
        }

        // Set description
        $shipment->setDescription('XX');

        // Add Package
        $package = new \Ups\Entity\Package();
        $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
        $package->getPackageWeight()->setWeight(10);
        $unit = new \Ups\Entity\UnitOfMeasurement;
        $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_KGS);
        $package->getPackageWeight()->setUnitOfMeasurement($unit);

        // Set dimensions
        $dimensions = new \Ups\Entity\Dimensions();
        $dimensions->setHeight(50);
        $dimensions->setWidth(50);
        $dimensions->setLength(50);
        $unit = new \Ups\Entity\UnitOfMeasurement;
        $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_CM);
        $dimensions->setUnitOfMeasurement($unit);
        $package->setDimensions($dimensions);

        // Add descriptions because it is a package
        $package->setDescription('XX');

        // Add this package
        $shipment->addPackage($package);

        // Set Reference Number
        $referenceNumber = new \Ups\Entity\ReferenceNumber;
        if ($return) {
            $referenceNumber->setCode(\Ups\Entity\ReferenceNumber::CODE_RETURN_AUTHORIZATION_NUMBER);
            $referenceNumber->setValue($return_id);
        } else {
            $referenceNumber->setCode(\Ups\Entity\ReferenceNumber::CODE_INVOICE_NUMBER);
            $referenceNumber->setValue($order_id);
        }
        $shipment->setReferenceNumber($referenceNumber);

        // Set payment information
        $shipment->setPaymentInformation(new \Ups\Entity\PaymentInformation('prepaid', (object)array('AccountNumber' => 'XX')));

        // Ask for negotiated rates (optional)
        $rateInformation = new \Ups\Entity\RateInformation;
        $rateInformation->setNegotiatedRatesIndicator(1);
        $shipment->setRateInformation($rateInformation);

        // Get shipment info
        try {
            $api = new Ups\Shipping(self::ACCESS_KEY, self::USER_ID, self::PASSWORD);

            $confirm = $api->confirm(\Ups\Shipping::REQ_VALIDATE, $shipment);
            var_dump($confirm); // Confirm holds the digest you need to accept the result

            if ($confirm) {
                $accept = $api->accept($confirm->ShipmentDigest);
                return new WP_REST_Response($accept, 200);
                // var_dump($accept); // Accept holds the label and additional information
            }
        } catch (\Exception $e) {
            return new WP_REST_Response($e->getMessage(), 400);
        }
    }


    public function print_ups_label($order_id)
    {
        $label_file = $order_id . ".gif";
        $base64_string = $accept->PackageResults->LabelImage->GraphicImage;
        $ifp = fopen($label_file, 'wb');
        fwrite($ifp, base64_decode($base64_string));
        fclose($ifp);
    }

}