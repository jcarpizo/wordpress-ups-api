<?php

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

class UpsApi extends WP_REST_Controller
{

    public function init()
    {

        if (!function_exists('register_rest_route')) {
            return false;
        }

        register_rest_route('ups/v1', '/shipment', [
                [
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => array(__CLASS__, 'post_shipment_details'),
                ]
            ]);

        register_rest_route('ups/v1', '/print/label', [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => array(__CLASS__, 'print_ups_label'),
                    'args' => [
                        [
                            'orderId' => [
                                'validate_callback' => 'is_numeric'
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function post_shipment_details($request)
    {

        $shipment = new Ups\Entity\Shipment;
        $shipper = $shipment->getShipper();
        $shipper->setShipperNumber(getenv('SHIPPER_NO'));
        $shipper->setName(getenv('SHIPPER_NAME'));
        $shipper->setAttentionName(getenv('SHIPPER_ATTENTION_NAME'));
        $shipperAddress = $shipper->getAddress();
        $shipperAddress->setAddressLine1(getenv('SHIPPER_ADDRESS_ONE'));
        $shipperAddress->setPostalCode(getenv('SHIPPER_POSTAL_CODE'));
        $shipperAddress->setCity(getenv('SHIPPER_CITY'));
        $shipperAddress->setStateProvinceCode(getenv('SHIPPER_STATE_PROVINCE_CODE')); // required in US
        $shipperAddress->setCountryCode(getenv('SHIPPER_COUNTRY_CODE'));
        $shipper->setAddress($shipperAddress);
        $shipper->setEmailAddress(getenv('SHIPPER_EMAIL_ADDRESS'));
        $shipper->setPhoneNumber(getenv('SHIPPER_PHONE_NUMBER'));
        $shipment->setShipper($shipper);

        // From address
        $address = new \Ups\Entity\Address();
        $address->setAddressLine1($shipperAddress->getAddressLine1());
        $address->setPostalCode($shipperAddress->getPostalCode());
        $address->setCity($shipperAddress->getCity());
        $address->setStateProvinceCode($shipperAddress->getStateProvinceCode());
        $address->setCountryCode($shipperAddress->getCountryCode());
        $shipFrom = new \Ups\Entity\ShipFrom();
        $shipFrom->setAddress($address);
        $shipFrom->setName($shipper->getAttentionName());
        $shipFrom->setAttentionName($shipper->getAttentionName());
        $shipFrom->setCompanyName($shipper->getAttentionName());
        $shipFrom->setEmailAddress($shipper->getEmailAddress());
        $shipFrom->setPhoneNumber($shipper->getPhoneNumber());
        $shipment->setShipFrom($shipFrom);

        // To address
        $address = new \Ups\Entity\Address();
        $address->setAddressLine1($request['toaddress_one']);
        $address->setPostalCode($request['toaddress_postal_code']);
        $address->setCity($request['toaddress_city']);
        $address->setStateProvinceCode($request['toaddress_province_code']);  // Required in US
        $address->setCountryCode($request['toaddress_country_code']);
        $shipTo = new \Ups\Entity\ShipTo();
        $shipTo->setAddress($address);
        $shipTo->setCompanyName($request['tocompany_name']);
        $shipTo->setAttentionName($shipTo->getCompanyName());
        $shipTo->setEmailAddress($request['toaddress_email']);
        $shipTo->setPhoneNumber($request['toaddress_phone_number']);
        $shipment->setShipTo($shipTo);

        // Sold to
        $addressSold = new \Ups\Entity\Address();
        $addressSold->setAddressLine1($address->getAddressLine1());
        $addressSold->setPostalCode($address->getPostalCode());
        $addressSold->setCity($address->getCity());
        $addressSold->setCountryCode($address->getCountryCode());
        $addressSold->setStateProvinceCode($address->getStateProvinceCode());
        $soldTo = new \Ups\Entity\SoldTo;
        $soldTo->setAddress($addressSold);
        $soldTo->setAttentionName($shipTo->getAttentionName());
        $soldTo->setCompanyName($shipTo->getCompanyName());
        $soldTo->setEmailAddress($shipTo->getEmailAddress());
        $soldTo->setPhoneNumber($shipTo->getPhoneNumber());
        $shipment->setSoldTo($soldTo);

        // Set service
        $service = new \Ups\Entity\Service;
        $service->setCode(\Ups\Entity\Service::S_AIR_1DAY);
        $service->setDescription($service->getName());
        $shipment->setService($service);

        // Mark as a return (if return)
        if ($return) {
            $returnService = new \Ups\Entity\ReturnService;
            $returnService->setCode(\Ups\Entity\ReturnService::PRINT_RETURN_LABEL_PRL);
            $shipment->setReturnService($returnService);
        }

        // Set description
        //$shipment->setDescription('test');

        // Add Package
        $package = new \Ups\Entity\Package();
        $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
        $package->getPackageWeight()->setWeight(1);
        $unit0 = new \Ups\Entity\UnitOfMeasurement;
        $unit0->setCode(\Ups\Entity\UnitOfMeasurement::UOM_LBS);
        $package->getPackageWeight()->setUnitOfMeasurement($unit0);

        // Set dimensions
        $dimensions = new \Ups\Entity\Dimensions();
        $dimensions->setHeight(1);
        $dimensions->setWidth(1);
        $dimensions->setLength(1);
        $unit1 = new \Ups\Entity\UnitOfMeasurement;
        $unit1->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);
        $dimensions->setUnitOfMeasurement($unit1);
        $package->setDimensions($dimensions);
        // Add descriptions because it is a package
        //$package->setDescription('XX');
        // Add this package
        $shipment->addPackage($package);

        $shipment->setPaymentInformation(new \Ups\Entity\PaymentInformation(
            'prepaid',
            (object)array('AccountNumber' => getenv('SHIPPER_NO'))
        ));

        // Ask for negotiated rates (optional)
        $rateInformation = new \Ups\Entity\RateInformation;
        $rateInformation->setNegotiatedRatesIndicator(1);
        $shipment->setRateInformation($rateInformation);

        try {
            $api = new Ups\Shipping(getenv('ACCESS_KEY'), getenv('USER_ID'), getenv('PASSWORD'));

            $confirm = $api->confirm(\Ups\Shipping::REQ_VALIDATE, $shipment);

            if ($confirm) {
                $accept = $api->accept($confirm->ShipmentDigest);
                $folder = get_template_directory() . '/assets/images/ups-label/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $label_file = uniqid() . ".gif";
                $base64_string = $accept->PackageResults->LabelImage->GraphicImage;
                $imageFile = $folder . $label_file;
                $ifp = fopen($imageFile, 'wb');
                fwrite($ifp, base64_decode($base64_string));
                fclose($ifp);

                self::traceRecord($request, $label_file, $confirm);

                $transport = (new Swift_SmtpTransport(getenv('EMAIL_SMTP'), getenv('EMAIL_PORT')))
                    ->setUsername(getenv('EMAIL_USERNAME'))
                    ->setPassword(getenv('EMAIL_PASSWORD'))
                    ->setEncryption(getenv('EMAIL_ENCRYPTION'));
                $mailer = new Swift_Mailer($transport);
                $message = new Swift_Message();
                $message->setSubject('Your UPS Label.');
                $message->setFrom([$shipper->getEmailAddress() => $shipper->getAttentionName()]);
                $message->addTo($request['toaddress_email'], $request['tocompany_name']);
                $message->setBody(
                    '<html>' .
                    ' <body>' .
                    '  UPS Label / Shipment Identification Number <br/>'.$confirm->ShipmentIdentificationNumber.' <img src="' .
                    $message->embed(Swift_Image::fromPath($imageFile)) .
                    '" alt="Image" />' .
                    ' </body>' .
                    '</html>',
                    'text/html'
                );
                $message->attach(Swift_Attachment::fromPath($imageFile)->setDisposition('inline'));

                $result = $mailer->send($message);
                if ($result) {
                    $message = [
                        'data' => ['shipment_identification_no' => $confirm->ShipmentIdentificationNumber],
                        'message' => 'Successfully Created',
                    ];
                    return new WP_REST_Response($message, 200);
                } else {
                    return new WP_REST_Response(['error_message' => 'Email failed'], 400);
                }
            }
        } catch (\Exception $e) {
            $message = [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode()
            ];
            return new WP_REST_Response($message, 400);
        }
    }

    public static function traceRecord($request, $imageFile, $confirm)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ups_shipment';

        return $wpdb->insert(
            $table_name,
            [
                'to_address_one' => $request['toaddress_one'],
                'to_address_postal_code' => $request['toaddress_postal_code'],
                'to_address_city' => $request['toaddress_city'],
                'to_address_province_code' => $request['toaddress_province_code'],
                'to_address_countyr_code' => $request['toaddress_country_code'],
                'to_company_name' => $request['tocompany_name'],
                'to_company_attention_name' => $request['tocompany_name'],
                'to_company_email' => $request['toaddress_email'],
                'to_company_phone_number' => $request['toaddress_phone_number'],
                'ups_label' => $imageFile,
                'shipment_identification_no' => $confirm->ShipmentIdentificationNumber
            ]
        );
    }
}
