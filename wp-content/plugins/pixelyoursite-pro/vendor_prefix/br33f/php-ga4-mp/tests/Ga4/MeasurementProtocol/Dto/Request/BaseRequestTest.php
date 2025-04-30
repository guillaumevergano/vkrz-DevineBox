<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 16:06
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Request;

use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\ConsentProperty;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\EventCollection;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\UserData;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\UserDataItem;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperties;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Enum\ConsentCode;
use PYS_PRO_GLOBAL\Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Tests\Common\BaseTestCase;

class BaseRequestTest extends BaseTestCase
{
    /**
     * @var BaseRequest
     */
    protected $baseRequest;

    public function testDefaultConstructor()
    {
        $constructedBaseRequest = new BaseRequest();

        $this->assertNotNull($constructedBaseRequest);
    }

    public function testAbstractEventConstructor()
    {
        $event = new BaseEvent();
        $constructedBaseRequest = new BaseRequest(null, $event);

        $this->assertNotNull($constructedBaseRequest);
        $this->assertCount(1, $constructedBaseRequest->getEvents()->getEventList());
        $this->assertEquals($event, $constructedBaseRequest->getEvents()->getEventList()[0]);
    }

    public function testClientId()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $this->baseRequest->setClientId($setClientId);

        $this->assertEquals($setClientId, $this->baseRequest->getClientId());
    }

    public function testUserId()
    {
        $setUserId = $this->faker->asciify('*********');
        $this->baseRequest->setUserId($setUserId);

        $this->assertEquals($setUserId, $this->baseRequest->getUserId());
    }

    public function testTimestampMicros()
    {
        $setTimestampMicros = $this->faker->unixTime * 1000;
        $this->baseRequest->setTimestampMicros($setTimestampMicros);

        $this->assertEquals($setTimestampMicros, $this->baseRequest->getTimestampMicros());
    }

    public function testNonPersonalizedAds()
    {
        $this->assertEquals(null, $this->baseRequest->isNonPersonalizedAds());

        $this->baseRequest->setNonPersonalizedAds(true);
        $this->assertEquals(true, $this->baseRequest->isNonPersonalizedAds());

        $this->baseRequest->setNonPersonalizedAds(false);
        $this->assertEquals(false, $this->baseRequest->isNonPersonalizedAds());
    }

    public function testUserProperties()
    {
        $setUserProperties = new UserProperties();
        $this->baseRequest->setUserProperties($setUserProperties);

        $this->assertEquals($setUserProperties, $this->baseRequest->getUserProperties());
    }

    public function testAddUserProperty()
    {
        $addUserProperty = new UserProperty($this->faker->word, $this->faker->word);
        $this->baseRequest->addUserProperty($addUserProperty);

        $this->assertEquals(1, count($this->baseRequest->getUserProperties()->getUserPropertiesList()));
        $this->assertEquals($addUserProperty, $this->baseRequest->getUserProperties()->getUserPropertiesList()[0]);
    }

    public function testConsent()
    {
        $consent = new ConsentProperty();
        $consent->setAdUserData(ConsentCode::GRANTED);
        $consent->setAdPersonalization(ConsentCode::DENIED);
        $this->baseRequest->setConsent($consent);

        $this->assertNotNull($this->baseRequest->getConsent());
        $this->assertEquals(ConsentCode::GRANTED, $this->baseRequest->getConsent()->getAdUserData());
        $this->assertEquals(ConsentCode::DENIED, $this->baseRequest->getConsent()->getAdPersonalization());
    }

    public function testUserData()
    {
        $setUserData = new UserData();
        $this->baseRequest->setUserData($setUserData);

        $this->assertEquals($setUserData, $this->baseRequest->getUserData());
    }

    public function testAddUserDataItem()
    {
        $addUserDataItem = new UserDataItem($this->faker->word, $this->faker->word);
        $this->baseRequest->addUserDataItem($addUserDataItem);

        $this->assertEquals(1, count($this->baseRequest->getUserData()->getUserDataItemList()));
        $this->assertEquals($addUserDataItem, $this->baseRequest->getUserData()->getUserDataItemList()[0]);
    }

    public function testEvents()
    {
        $setEvents = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEvents->addEvent($event);
        $this->baseRequest->setEvents($setEvents);

        $this->assertEquals($setEvents, $this->baseRequest->getEvents());
    }

    public function testAddEvent()
    {
        $this->baseRequest->setEvents(new EventCollection());

        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));

        $this->baseRequest->addEvent($event);

        $this->assertEquals(1, count($this->baseRequest->getEvents()->getEventList()));
        $this->assertEquals($event, $this->baseRequest->getEvents()->getEventList()[0]);
    }

    public function testValidateClientIdRequiredFailed()
    {
        $newBaseRequest = new BaseRequest();

        $this->expectExceptionCode(ErrorCode::VALIDATION_CLIENT_ID_REQUIRED);
        $newBaseRequest->validate('web');
    }

    public function testValidateAppInstanceIdRequiredFailed()
    {
        $newBaseRequest = new BaseRequest();

        $this->expectExceptionCode(ErrorCode::VALIDATION_APP_INSTANCE_ID_REQUIRED);
        $newBaseRequest->validate('firebase');
    }

    public function testValidateBothClientIdAppInstanceIdRequiredFailed()
    {
        $newBaseRequest = new BaseRequest();
        $setAppInstanceId = $this->faker->bothify('**-########');
        $setFirebaseId = $this->faker->bothify('**-########');

        $newBaseRequest->setAppInstanceId($setAppInstanceId);
        $newBaseRequest->setClientId($setFirebaseId);

        $this->expectExceptionCode(ErrorCode::VALIDATION_CLIENT_IDENTIFIER_MISCONFIGURED);
        $newBaseRequest->validate();
    }

    public function testValidateSuccess()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);
        $newBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $this->assertTrue($newBaseRequest->validate());
    }

    public function testExportOnlyRequiredParameters()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);

        $exportBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $this->assertEquals([
            'client_id' => $setClientId,
            'events' => $setEventCollection->export(),
        ], $exportBaseRequest->export());
    }

    public function testExportAllParameters()
    {
        $setClientId = $this->faker->asciify('********************.********************');
        $setEventCollection = new EventCollection();
        $event = new BaseEvent($this->faker->word);
        $event->addParam($this->faker->word, new BaseParameter($this->faker->word));
        $setEventCollection->addEvent($event);

        $exportBaseRequest = new BaseRequest($setClientId, $setEventCollection);

        $setUserId = $this->faker->asciify('************');
        $exportBaseRequest->setUserId($setUserId);

        $setTimestampMicros = $this->faker->unixTime * 1000;
        $exportBaseRequest->setTimestampMicros($setTimestampMicros);

        $setUserProperties = new UserProperties();
        $exportBaseRequest->setUserProperties($setUserProperties);

        $exportBaseRequest->setNonPersonalizedAds(true);

        $consent = new ConsentProperty();
        $consent->setAdUserData(ConsentCode::GRANTED);
        $consent->setAdPersonalization(ConsentCode::DENIED);
        $exportBaseRequest->setConsent($consent);

        $constructedUserData = new UserData();
        $exportBaseRequest->setUserData($constructedUserData);

        $this->assertEquals([
            'client_id' => $setClientId,
            'events' => $setEventCollection->export(),
            'user_id' => $setUserId,
            'timestamp_micros' => $setTimestampMicros,
            'non_personalized_ads' => true,
            'user_properties' => $setUserProperties->export(),
            'consent' => $consent->export(),
            'user_data' => $constructedUserData->export()
        ], $exportBaseRequest->export());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->baseRequest = new BaseRequest();
    }
}
