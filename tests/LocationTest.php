<?php

class LocationTest extends LocatorTest{

    protected static $use_draft_site = true;

    function setUp(){
        parent::setUp();
    }

    function testLocationCreation(){

        $this->logInWithPermission('Location_CREATE');
        $location = $this->objFromFixture('Location', 'dynamic');

        $this->assertTrue($location->canCreate());

        $locationID = $location->ID;

        $this->assertTrue($locationID > 0);

        $getLocal = Location::get()->byID($locationID);
        $this->assertTrue($getLocal->ID == $locationID);

    }

    function testLocationUpdate(){

        $this->logInWithPermission('ADMIN');
        $location = $this->objFromFixture('Location', 'silverstripe');
        $locationID = $location->ID;

        $this->logOut();

        $this->logInWithPermission('Location_EDIT');

        $this->assertTrue($location->canEdit());
        $location = Location::get()->byID($locationID);
        $newTitle = "Updated Title for Location";
        $location->Title = $newTitle;
        $location->write();

        $location = Location::get()->byiD($locationID);

        $this->assertTrue($location->Title == $newTitle);

    }

    function testLocationDeletion(){

        $this->logInWithPermission('ADMIN');
        $location = $this->objFromFixture('Location', 'silverstripe');
        $locationID = $location->ID;

        $this->logOut();

        $this->logInWithPermission('Location_DELETE');

        $this->assertTrue($location->canDelete());
        $location->delete();

        $locations = Location::get()->column('ID');
        $this->assertFalse(in_array($locationID, $locations));

    }

    function testLocationLatLng(){

        $this->logInWithPermission('ADMIN');
        $dynamic = $this->objFromFixture('Location', 'dynamic');
        $dynamic->write();

        $silverstripe = $this->objFromFixture('Location', 'silverstripe');
        $silverstripe->write();

        $dynamicLat = 43.7377;
        $dynamicLng =  -87.72;

        $silverstripeLat = -41.2926;
        $silverstripeLng = 174.779;


        $this->assertTrue($dynamic->Lat == $dynamicLat);
        $this->assertTrue($dynamic->Lng == $dynamicLng);
        $this->assertTrue($silverstripe->Lat == $silverstripeLat);
        $this->assertTrue($silverstripe->Lng == $silverstripeLng);

    }


}