<?php
if(isset($_SESSION['id']))
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    include_once "$root/SipsewanaEDU/config.php";
    $conn = new Conn();
    $con = $conn->getConn();

    class Subject
    {
        protected $subject_id;
        private $subjectname;
        private $description;
        private $fee;
        private $type;
        private $medium;

        function getId($subject_name)
        {
            try {
                global $con;
                $result = $con->query("SELECT subject.subject_id FROM subject WHERE subjectname='".$subject_name."'");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['subject_id'];
                    }
                    return $id;
                } else {
                    return null;
                }
                $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        function getSubName()
        {

        }

        function getSType($student_id)
        {
            try {
                global $con;
                $result = $con->query("SELECT s.type FROM student_reg sr, subject s WHERE sr.st_sub_id=s.subject_id AND sr.st_reg_id='".$student_id."'");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $type = $row['type'];
                    }
                    return $type;
                } else {
                    return null;
                }
                $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        function getRegSubName($student_id)
        {
            $type = $this->getSType($student_id);
            try {
                global $con;
                $data = array();
                $result = $con->query("SELECT subject.subjectname FROM student_reg,subject WHERE subject.subject_id!=(SELECT subject.subject_id FROM student_reg,subject WHERE student_reg.st_sub_id=subject.subject_id AND student_reg.st_reg_id='".$student_id."') AND subject.type='".$type."'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $row = array_map('stripslashes', $row);
                            $data[] = $row;
                        }
                        return $data;
                    } else {
                        return null;
                    }
                }
                // $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
            
        }

        function getRegSubNameLec($lecturer_id)
        {
            try {
                global $con;
                $data = array();
                $result = $con->query("SELECT DISTINCT s.subjectname FROM lecturer_reg lr, subject s WHERE s.subject_id NOT IN (SELECT s.subject_id FROM lecturer_reg lr, subject s WHERE lr.lec_sub_id=s.subject_id AND lr.lec_reg_id='".$lecturer_id."');-- AND s.type='O/L'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $row = array_map('stripslashes', $row);
                            $data[] = $row;
                        }
                        return $data;
                    } else {
                        return null;
                    }
                }
                // $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
            
        }

        function getRegSubNameL($lecturer_id)
        {
            try {
                global $con;
                $data = array();
                $result = $con->query("SELECT s.subjectname FROM lecturer_reg lr, subject s WHERE lr.lec_sub_id=s.subject_id AND lr.lec_reg_id='".$lecturer_id."'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $row = array_map('stripslashes', $row);
                            $data[] = $row;
                        }
                        return $data;
                    } else {
                        return null;
                    }
                }
                // $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
            
        }

        function getFee($subject_name)
        {
            try {
                global $con;
                $result = $con->query("SELECT subject.fee FROM subject WHERE subject.subjectname='".$subject_name."'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $fee = $row['fee'];
                        }
                        return $fee;
                    } else {
                        return null;
                    }
                }
                $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        function getRegFee($student_id)
        {
            try {
                global $con;
                $data = array();
                $result = $con->query("SELECT subject.fee FROM student_reg,subject WHERE subject.subject_id NOT IN (SELECT subject.subject_id FROM student_reg,subject WHERE student_reg.st_sub_id=subject.subject_id AND student_reg.st_reg_id='".$student_id."') AND subject.type='O/L'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $row = array_map('stripslashes', $row);
                            $data[] = $row;
                        }
                        return $data;
                    } else {
                        return null;
                    }
                }
                $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        function getLRegFee($lecturer_id)
        {
            try {
                global $con;
                $data = array();
                $result = $con->query("SELECT DISTINCT s.fee FROM lecturer_reg lr, subject s WHERE s.subject_id NOT IN (SELECT s.subject_id FROM lecturer_reg lr, subject s WHERE lr.lec_sub_id=s.subject_id AND lr.lec_reg_id='".$lecturer_id."');-- AND s.type='O/L'");
                if ($result) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $row = array_map('stripslashes', $row);
                            $data[] = $row;
                        }
                        return $data;
                    } else {
                        return null;
                    }
                }
                $con->close();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    }
}
else
{
    header('location:../pages/Student/Login.php');
}

?>