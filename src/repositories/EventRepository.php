<?php

require_once 'Repository.php';
require_once 'UserRepository.php';
require_once __DIR__.'/../models/User.php';

class EventRepository extends Repository
{
    public function getUserEvents(int $creator_id): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id WHERE e.creator_id = :creator_id OR ue.user_id = :creator_id;
        ');
        $stmt->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['category'],
                $event['date'],
                $event['location'],
                $event['picture']
            );
        }

        return $result;
    }
    public function getEvents($user_id): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT e.event_id, category, date, location, picture
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            GROUP BY e.event_id
            
            EXCEPT
            
            SELECT e.event_id, category, date, location, picture
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            WHERE creator_id=:creator_id OR ue.user_id=:creator_id
            GROUP BY e.event_id
        ');
        $stmt->bindParam(':creator_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event) {
            $result[] = new Event(
                $event['category'],
                $event['date'],
                $event['location'],
                $event['picture']
            );
        }

        return $result;
    }

    public function addEvent(User $user, Event $event){
        $userRepository = new UserRepository();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO events (category, date, location, picture, creator_id)
            VALUES (?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $event->getCategory(),
            $event->getDate(),
            $event->getLocation(),
            $event->getPicture(),
            $userRepository->getUserIdByEmail($user->getEmail())
        ]);
    }

    public function getEventByTitle(int $user_id, string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT e.event_id, category, date, location, picture
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            WHERE LOWER(category) LIKE :search OR LOWER(location) LIKE :search
            GROUP BY e.event_id
            
            EXCEPT
            
            SELECT e.event_id, category, date, location, picture
            FROM events e LEFT JOIN user_event ue on e.event_id = ue.event_id
            WHERE creator_id=:creator_id OR ue.user_id=:creator_id
            GROUP BY e.event_id
        ');
        $stmt->bindParam(':creator_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
