<?php

namespace App\Adventure;

use PHPUnit\Framework\TestCase;

class AdventureTest extends TestCase
{
    private Adventure $adventure;

    protected function setUp(): void
    {
        $jsonFile = __DIR__ . '/rooms.json';
        $this->adventure = new Adventure($jsonFile);
    }

    public function testDescribeCurrentRoom(): void
    {
        $description = $this->adventure->describeCurrentRoom();
        $expectedItems = implode(", ", $this->adventure->getCurrentRoomItems());
        $expectedDescription = "Du befinner dig i en skog och i fjärran står en skyskrapa. Du vet inte hur du hamnade här men allt som går genom din kropp just nu är en sak. Överlevnad. Det finns " . $expectedItems . " här.";
        $this->assertEquals($expectedDescription, $description);
    }

    public function testGetCurrentRoomImage(): void
    {
        $image = $this->adventure->getCurrentRoomImage();
        $this->assertEquals("room_1.jpeg", $image);
    }

    public function testPickUpItem(): void
    {
        $this->adventure->moveToRoom("room_2");
        $result = $this->adventure->pickUpItem("sten");
        $this->assertTrue($result['success']);
        $this->assertEquals('Du har plockat upp sten.', $result['message']);
        $this->assertContains("sten", $this->adventure->getInventory());
    }

    public function testPickUpLockedItemWithoutKey(): void
    {
        $this->adventure->moveToRoom("room_2");
        $result = $this->adventure->pickUpItem("portfölj");
        $this->assertFalse($result['success']);
        $this->assertEquals('Du behöver nyckel för att låsa upp portfölj!', $result['message']);
    }

    public function testMoveToRoom(): void
    {
        $result = $this->adventure->moveToRoom("room_2");
        $this->assertTrue($result['success']);
        $this->assertEquals('Du har flyttat till rummet room_2.', $result['message']);
    }

    public function testMoveToRoomWithoutCard(): void
    {
        $this->adventure->moveToRoom("room_4");
        $result = $this->adventure->moveToRoom("room_5");
        $this->assertFalse($result['success']);
        $this->assertEquals('Du behöver ett kort för att gå in i rummet.', $result['message']);
    }

    public function testMoveToRoomWithCard(): void
    {
        $this->adventure->moveToRoom("room_4");
        $this->adventure->pickUpItem("nyckel");
        $this->adventure->moveToRoom("room_2");
        $this->adventure->pickUpItem("portfölj");

        $this->adventure->moveToRoom("room_4");
        $result = $this->adventure->moveToRoom("room_5");
        $this->assertTrue($result['success']);
        $this->assertEquals('Du har flyttat till rummet room_5.', $result['message']);
    }

    public function testThrowItem(): void
    {
        $this->adventure->moveToRoom("room_2");
        $this->adventure->pickUpItem("sten");
        $this->adventure->moveToRoom("room_3");
        $result = $this->adventure->throwItem("sten");
        $this->assertTrue($result['success']);
        $this->assertEquals('Du kastade stenen på byggnaden. Du hör hur stenen spräcker ett fönster i tusen bitar... Ganska onödigt...', $result['message']);
    }

    public function testGetInventory(): void
    {
        $this->adventure->moveToRoom("room_2");
        $this->adventure->pickUpItem("sten");
        $inventory = $this->adventure->getInventory();
        $this->assertContains("sten", $inventory);
    }

    public function testGetConnectedRooms(): void
    {
        $connectedRooms = $this->adventure->getConnectedRooms();
        $this->assertArrayHasKey("room_2", $connectedRooms);
    }

    public function testGetCurrentRoomItems(): void
    {
        $this->adventure->moveToRoom("room_2");
        $items = $this->adventure->getCurrentRoomItems();
        $this->assertContains("portfölj", $items);
        $this->assertContains("sten", $items);
    }
}
