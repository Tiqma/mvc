<?php

namespace App\Adventure;

class Adventure
{
    private $rooms;

    /**
     * @var array<int, string>
     */
    private $inventory = [];

    /**
     * @var string
     */
    private $currentRoom;

    public function __construct($jsonFile = null)
    {
        if ($jsonFile === null) {
            $jsonFile = __DIR__ . '/rooms.json';
        }

        $this->loadWorld($jsonFile);
        $this->currentRoom = 'room_1';
    }

    /**
     * @param string $jsonFile
     * @return void
     */
    private function loadWorld($jsonFile): void
    {
        $jsonData = file_get_contents($jsonFile);
        $this->rooms = json_decode($jsonData, true)['rooms'];
    }

    public function describeCurrentRoom(): string
    {
        $room = $this->rooms[$this->currentRoom];
        return $room['description'] . " Det finns " . implode(", ", $room['items']) . " här.";
    }

    public function getCurrentRoomImage(): string
    {
        return $this->rooms[$this->currentRoom]['image'];
    }

    /**
     * @param string $item
     * @return array{ success: bool, message: string }
     */
    public function pickUpItem(string $item): array
    {
        $room = $this->rooms[$this->currentRoom];

        if (isset($room['locked_items'][$item])) {
            $lock = $room['locked_items'][$item];
            if (in_array($lock['requires_item'], $this->inventory)) {
                if ($item === 'portfölj') {
                    $this->inventory[] = $lock['contains'];
                    unset($this->rooms[$this->currentRoom]['locked_items'][$item]);
                }
            }
            return ['success' => false, 'message' => 'Du behöver ' .
                $lock['requires_item'] . ' för att låsa upp ' . $item . '!'];
        }

        if (in_array($item, $room['items'])) {
            $this->inventory[] = $item;
            $this->rooms[$this->currentRoom]['items'] = array_diff($room['items'], [$item]);
            return ['success' => true, 'message' => 'Du har plockat upp ' . $item . '.'];
        }
    }

    /**
     * @param string $room
     * @return array{ success: bool, message: string }
     */
    public function moveToRoom(string $room): array
    {
        if (!isset($this->rooms[$room])) {
            return ['success' => false, 'message' => 'Det finns inget rum med namnet ' . $room . '.'];
        }

        if (isset($this->rooms[$this->currentRoom]['connected_rooms'][$room]['requires_item'])) {
            $requiredItem = $this->rooms[$this->currentRoom]['connected_rooms'][$room]['requires_item'];
            if (in_array($requiredItem, $this->inventory)) {
                $this->currentRoom = $room;
                return ['success' => true, 'message' => 'Du har flyttat till rummet ' . $room . '.'];
            }
            return ['success' => false, 'message' => 'Du behöver ett ' . $requiredItem . ' för att gå in i rummet.'];
        }

        $this->currentRoom = $room;
        return ['success' => true, 'message' => 'Du har flyttat till rummet ' . $room . '.'];
    }

    /**
     * @param string $item
     * @return array<string, mixed>
     */
    public function throwItem($item): array
    {
        if (!in_array($item, $this->inventory)) {
            return ['success' => false, 'message' => 'Du har inte ' . $item . ' i din inventering.'];
        }

        if ($this->currentRoom === 'room_3' && $item === 'sten') {
            $this->inventory = array_diff($this->inventory, [$item]);
            return ['success' => true, 'message' => 'Du kastade stenen på byggnaden. 
                Du hör hur stenen spräcker ett fönster i tusen bitar... Ganska onödigt...'];
        }

        return ['success' => false, 'message' => 'Du kan inte kasta ' . $item . ' här.'];
    }

    /**
     * @return array<string>
     */
    public function getInventory(): array
    {
        return $this->inventory;
    }

    /**
     * @return array<string>
     */
    public function getConnectedRooms(): array
    {
        return $this->rooms[$this->currentRoom]['connected_rooms'];
    }

    /**
     * @return array<string>
     */
    public function getCurrentRoomItems(): array
    {
        return $this->rooms[$this->currentRoom]['items'];
    }
}
