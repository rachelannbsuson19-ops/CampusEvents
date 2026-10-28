<?php
class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEvents() {
        $stmt = $this->pdo->query("SELECT * FROM seminars ORDER BY event_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEvent($title, $description, $event_date, $venue, $organizer, $username) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO seminars (title, description, event_date, venue, organizer) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $event_date, $venue, $organizer]);

            // Log transaction for Add action
            $log = $this->pdo->prepare("INSERT INTO transactions (username, action_type, details) VALUES (?, 'CREATE', ?)");
            $log->execute([$username, "Added seminar: $title at $venue"]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("addEvent failed: " . $e->getMessage());
            return false;
        }
    }

    public function updateEvent($id, $title, $description, $event_date, $venue, $organizer, $username) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("UPDATE seminars SET title = ?, description = ?, event_date = ?, venue = ?, organizer = ? WHERE id = ?");
            $stmt->execute([$title, $description, $event_date, $venue, $organizer, $id]);

            // Log transaction for Update action
            $log = $this->pdo->prepare("INSERT INTO transactions (username, action_type, details) VALUES (?, 'UPDATE', ?)");
            $log->execute([$username, "Updated seminar ID $id: $title"]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("updateEvent failed: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEvent($id, $username) {
        try {
            $this->pdo->beginTransaction();

            // Fetch title first for logging details before deleting
            $getStmt = $this->pdo->prepare("SELECT title FROM seminars WHERE id = ?");
            $getStmt->execute([$id]);
            $row = $getStmt->fetch(PDO::FETCH_ASSOC);
            $title = $row['title'] ?? 'Unknown';

            $stmt = $this->pdo->prepare("DELETE FROM seminars WHERE id = ?");
            $stmt->execute([$id]);

            // Log transaction for Delete action
            $log = $this->pdo->prepare("INSERT INTO transactions (username, action_type, details) VALUES (?, 'DELETE', ?)");
            $log->execute([$username, "Deleted seminar: $title"]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("deleteEvent failed: " . $e->getMessage());
            return false;
        }
    }
}
?>