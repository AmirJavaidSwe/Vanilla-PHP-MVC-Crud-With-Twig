<?php
namespace Model;

use PDO;

class CourseModel {
    private $conn;

    public function __construct(PDO $conn) {
        require_once(__DIR__ . '/../../config/config.php');
        $this->conn = $conn;
    }

    public function getAllCourses() {
        $stmt = $this->conn->query('SELECT * FROM courses');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM courses WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCourse($name, $instructor, $description, $credits) {
        $stmt = $this->conn->prepare('INSERT INTO courses (name, instructor, description, credits) VALUES (:name, :instructor, :description, :credits)');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':instructor', $instructor, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':credits', $credits, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateCourse($id, $name, $instructor, $description, $credits) {
        $stmt = $this->conn->prepare('UPDATE courses SET name = :name, instructor = :instructor, description = :description, credits = :credits WHERE id = :id');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':instructor', $instructor, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':credits', $credits, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCourse($id) {
        $stmt = $this->conn->prepare('DELETE FROM courses WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
