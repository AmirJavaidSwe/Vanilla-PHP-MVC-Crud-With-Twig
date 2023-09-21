<?php
namespace Controller;

use Model\CourseModel;
use Twig\Environment;

class CourseController {
    private $twig;
    private $courseModel; // Declare a private property for CourseModel

    public function __construct(Environment $twig, CourseModel $courseModel) {
        $this->twig = $twig;
        $this->courseModel = $courseModel; // Initialize the CourseModel
    }

    public function index() {
        $courses = $this->courseModel->getAllCourses();
        foreach ($courses as &$course) {
            $course['credits'] = json_decode($course['credits'], true); // Decode JSON data
        }
        echo $this->twig->render('course-list.twig', ['courses' => $courses, 'page_title' => 'Course - Course List']);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $instructor = $_POST['instructor'];
            $description = $_POST['description'];
            $credits = [];
            foreach($_POST['credit_name'] as $key => $value) {
                $credits[$value] = $_POST['credit_points'][$key];
            }
            $credits = json_encode($credits);
            $this->courseModel->addCourse($name, $instructor, $description, $credits);
            header('Location: /');
            exit;
        } else {
            echo $this->twig->render('course-form.twig', ['page_title' => 'Course - Add New Course']);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $instructor = $_POST['instructor'];
            $description = $_POST['description'];
            $credits = [];
            foreach($_POST['credit_name'] as $key => $value) {
                $credits[$value] = $_POST['credit_points'][$key];
            }
            $credits = json_encode($credits);
            $this->courseModel->updateCourse($id, $name, $instructor, $description, $credits);
            header('Location: /');
            exit;
        } else {
            $course = $this->courseModel->getCourseById($id);
            $course['credits'] = json_decode($course['credits'], true); // Decode JSON data
            echo $this->twig->render('course-edit.twig', ['course' => $course, 'page_title' => 'Course - Edit Course']);
        }
    }

    public function delete($id) {
        $this->courseModel->deleteCourse($id);
        header('Location: /');
        exit;
    }
}
?>
