-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2018 at 11:01 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuitionacademy`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `username`, `password`, `name`, `contact`, `email`) VALUES
(1, 'admin1', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Administrator 1', '0300-1111111', 'admin1@tuitionacademy.com'),
(2, 'admin2', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Administrator 2', '0301-1111111', 'admin2@tuitionacademy.com');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `admission_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `fees` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admission_id`, `student_id`, `date`, `fees`) VALUES
(1, 1, '2016-09-05', 10000),
(2, 2, '2016-09-05', 10000),
(3, 3, '2016-09-05', 10000),
(4, 4, '2018-12-17', 10000),
(5, 5, '2018-12-19', 10000),
(6, 6, '2018-12-19', 10000),
(7, 7, '2018-12-19', 10000),
(8, 8, '2018-12-19', 10000),
(9, 9, '2018-12-19', 10000),
(10, 10, '2018-12-19', 10000),
(11, 11, '2018-12-19', 10000),
(12, 12, '2018-12-19', 10000),
(13, 13, '2018-12-19', 10000),
(14, 14, '2018-12-19', 10000),
(15, 15, '2018-12-19', 10000),
(16, 16, '2018-12-19', 10000),
(17, 17, '2018-12-19', 10000),
(18, 18, '2018-12-19', 10000),
(19, 19, '2018-12-19', 10000),
(20, 20, '2018-12-19', 10000),
(21, 21, '2018-12-19', 10000),
(22, 22, '2018-12-19', 10000),
(23, 23, '2018-12-19', 10000),
(24, 24, '2018-12-19', 10000),
(25, 25, '2018-12-19', 10000),
(26, 26, '2018-12-19', 10000),
(27, 27, '2018-12-19', 10000),
(28, 28, '2018-12-19', 10000),
(29, 29, '2018-12-19', 10000),
(30, 30, '2018-12-19', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `no` int(1) NOT NULL,
  `marks` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `fee` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `code`, `title`, `description`, `fee`) VALUES
(1, 'COMP 102', 'Programming I', 'Basic skills of problem solving and programming, problem analysis, algorithm design, program development and testing, structured design techniques, object-oriented thought process and basic tools.', 21000),
(2, 'COMP 111', 'Programming II', 'The course includes the concepts and practical application of classes, inheritance, class hierarchy, polymorphism, basic data structures, basic searching and sorting techniques.', 22000),
(3, 'COMP 113', 'Discrete Mathematics', 'Foundations of discrete mathematics as they apply to Computer Science, understanding and appreciation of the finite nature inherent in most Computer Science problems and structures through study of logic, set theory, functions, recursive relations, combinatorial reasoning, iterative procedures, predicate calculus, tree and graph structures.', 18000),
(4, 'COMP 200', 'Data Structures and Algorithms', 'Foundations of discrete mathematics as they apply to Computer Science, understanding and appreciation of the finite nature inherent in most Computer Science problems and structures through study of logic, set theory, functions, recursive relations, combinatorial reasoning, iterative procedures, predicate calculus, tree and graph structures.', 23000),
(5, 'COMP 206', 'Digital Logic Design', 'Fundamentals of hardware system design, beginning at the digital logic level with bits, binary representations, and basic binary operations, Minimization techniques, combinational and sequential logic circuits and gates , basic functional units, higher level computing functions, hardware description languages, basic elements of some real life architectures.', 19000),
(6, 'COMP 213', 'Database Systems', 'Databases, various data models, data storage and retrieval techniques and database design techniques, relational data model, relational algebra as a basis for queries in SQL and normalization techniques to optimize database structures.', 22000),
(7, 'COMP 220', 'Software Engineering', 'Basics of Software Engineering, the terminologies involved and various principles, methods, tools and techniques used to produce quality software, two fundamental approaches of software engineering: structural and object-oriented. Various techniques used for requirements engineering, system/software design, implementation, and testing, fundamental issues of software measurement and project management.', 21000),
(8, 'COMP 300', 'Computer Organization with Assembly Language', 'Introduction to computer systems and architectures, CPU operations, buses, memory, instruction sets, machine code, use of assembly language for optimization and control, low-level logic employed for problem solving while using assembly language as a tool, trace low level code of instruction, interrupt handling and multi-tasking systems, writing moderately complex assembly language subroutines and interfacing them to any high level language.', 23000),
(9, 'COMP 301', 'Operating Systems', 'Construction and working of operating systems, understanding management and sharing of the computer resources communication and concurrency, developing effective and efficient applications, problems and issues regarding multi-user, multi-tasking, and distributed systems.', 22000),
(10, 'COMP 302', 'Theory of Automata', 'Mathematical models of computation, definition and properties of formal languages and grammars, finite automata, regular languages and regular expressions, pushdown automata and context free languages, pumping lemmas and normal forms, Turing machines, Church\'s Thesis, Halting Problem and undecidability, overview of the theory of computational complexity.', 22000),
(11, 'COMP 303', 'Design and Analysis of Algorithms', 'Basic notions of the design of algorithms and the underlying data structures, analysis of complexity of algorithms, techniques of algorithms.', 21000),
(12, 'COMP 311', 'Computer Networks', 'Engineering concepts underlying computer communication, including analog and digital transmission, circuit switching and packet switching, logical network structure and operation including network layers, network models (OSI, TCP/IP) and protocol standards, understanding of modern network concepts.', 21000),
(13, 'COMP 360', 'Introduction to AI', 'This course introduces principles and practices of Artificial Intelligence, elements of intelligent behavior, techniques of knowledge representations, optimal solutions and complexities with heuristics, production systems and expert systems, introduction to machine learning, languages and their usage for implementation of intelligent behavior.', 24000),
(14, 'COMP 401', 'Ethics for Computing Professionals', 'Introduction to ethical questions faced by designers, developers, managers and users of information systems including intellectual property rights, privacy concerns, professional responsibilities and deliberate harmful use of IT resources.', 18000),
(15, 'COMP 405', 'Human Computer Interaction', 'Exploration of the differences in information processing by humans and machines using insights from psychology and cognitive science, design of human-computer interfaces and systems involving both human and computer components.', 22000),
(16, 'COMP 421', 'Information Security', 'Introduction to information security from a theoretical and practical perspective, details of different security vulnerabilities of information systems and computer networks, methods to defend against the attacks for vulnerabilities exploited by adversaries and hackers, cryptographic techniques and protocols, network security protocols and practices, digital signatures and authentication protocols and wireless network security.', 22000),
(17, 'COMP 451', 'Compiler Construction', 'Organization of compilers, different types of translators, lexical and syntax analysis, parsing techniques, object code generation and optimization, detection and recovery from errors.', 24000),
(18, 'COMP 452', 'Computer Architecture', 'This course provides an understanding of design issues of computer systems from the perspective of performance measures and cost-performance tradeoffs. The course covers fundamentals of modern processor design. Topics include instruction set design, RISC vs. CISC architectures, memory management, caches, memory hierarchies, interrupts, I/O structures, pipelining, parallelism, and multiprocessor systems.', 24000);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `midterm` int(11) DEFAULT NULL,
  `final` int(11) DEFAULT NULL,
  `grade` char(1) DEFAULT NULL,
  `due_fee` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`enrollment_id`, `student_id`, `section_id`, `midterm`, `final`, `grade`, `due_fee`) VALUES
(1, 1, 6, NULL, NULL, NULL, 18000),
(2, 1, 10, NULL, NULL, NULL, 19000),
(3, 1, 24, NULL, NULL, NULL, 21000),
(4, 2, 1, NULL, NULL, NULL, 21000),
(5, 2, 4, NULL, NULL, NULL, 22000),
(6, 2, 15, NULL, NULL, NULL, 23000),
(7, 3, 2, NULL, NULL, NULL, 21000),
(8, 3, 12, NULL, NULL, NULL, 22000),
(9, 3, 19, NULL, NULL, NULL, 22000),
(10, 4, 15, NULL, NULL, NULL, 23000),
(11, 4, 17, NULL, NULL, NULL, 22000),
(12, 4, 25, NULL, NULL, NULL, 24000),
(13, 5, 3, NULL, NULL, NULL, 22000),
(14, 5, 9, NULL, NULL, NULL, 19000),
(15, 5, 18, NULL, NULL, NULL, 22000),
(16, 6, 4, NULL, NULL, NULL, 22000),
(17, 6, 16, NULL, NULL, NULL, 23000),
(18, 6, 27, NULL, NULL, NULL, 18000),
(19, 7, 1, NULL, NULL, NULL, 21000),
(20, 7, 4, NULL, NULL, NULL, 22000),
(21, 7, 21, NULL, NULL, NULL, 21000),
(22, 8, 5, NULL, NULL, NULL, 18000),
(23, 8, 16, NULL, NULL, NULL, 23000),
(24, 8, 29, NULL, NULL, NULL, 22000),
(25, 9, 2, NULL, NULL, NULL, 21000),
(26, 9, 11, NULL, NULL, NULL, 22000),
(27, 9, 28, NULL, NULL, NULL, 22000),
(28, 10, 1, NULL, NULL, NULL, 21000),
(29, 10, 19, NULL, NULL, NULL, 22000),
(30, 10, 31, NULL, NULL, NULL, 24000),
(31, 11, 8, NULL, NULL, NULL, 23000),
(32, 11, 19, NULL, NULL, NULL, 22000),
(33, 11, 30, NULL, NULL, NULL, 24000),
(34, 12, 2, NULL, NULL, NULL, 21000),
(35, 12, 14, NULL, NULL, NULL, 21000),
(36, 12, 22, NULL, NULL, NULL, 21000),
(37, 13, 3, NULL, NULL, NULL, 22000),
(38, 13, 10, NULL, NULL, NULL, 19000),
(39, 13, 23, NULL, NULL, NULL, 21000),
(40, 14, 3, NULL, NULL, NULL, 22000),
(41, 14, 21, NULL, NULL, NULL, 21000),
(42, 14, 31, NULL, NULL, NULL, 24000),
(43, 15, 5, NULL, NULL, NULL, 18000),
(44, 15, 7, NULL, NULL, NULL, 23000),
(45, 15, 26, NULL, NULL, NULL, 24000),
(46, 16, 13, NULL, NULL, NULL, 21000),
(47, 16, 20, NULL, NULL, NULL, 22000),
(48, 16, 28, NULL, NULL, NULL, 22000),
(49, 17, 6, NULL, NULL, NULL, 18000),
(50, 17, 25, NULL, NULL, NULL, 24000),
(51, 17, 27, NULL, NULL, NULL, 18000),
(52, 18, 5, NULL, NULL, NULL, 18000),
(53, 18, 7, NULL, NULL, NULL, 23000),
(54, 18, 19, NULL, NULL, NULL, 22000),
(55, 19, 6, NULL, NULL, NULL, 18000),
(56, 19, 8, NULL, NULL, NULL, 23000),
(57, 19, 21, NULL, NULL, NULL, 21000),
(58, 20, 14, NULL, NULL, NULL, 21000),
(59, 20, 17, NULL, NULL, NULL, 22000),
(60, 20, 29, NULL, NULL, NULL, 22000),
(61, 21, 11, NULL, NULL, NULL, 22000),
(62, 21, 13, NULL, NULL, NULL, 21000),
(63, 21, 25, NULL, NULL, NULL, 24000),
(64, 22, 9, NULL, NULL, NULL, 19000),
(65, 22, 12, NULL, NULL, NULL, 22000),
(66, 22, 15, NULL, NULL, NULL, 23000),
(67, 23, 16, NULL, NULL, NULL, 23000),
(68, 23, 29, NULL, NULL, NULL, 22000),
(69, 23, 31, NULL, NULL, NULL, 24000),
(70, 24, 10, NULL, NULL, NULL, 19000),
(71, 24, 18, NULL, NULL, NULL, 22000),
(72, 24, 24, NULL, NULL, NULL, 21000),
(73, 25, 13, NULL, NULL, NULL, 21000),
(74, 25, 26, NULL, NULL, NULL, 24000),
(75, 25, 31, NULL, NULL, NULL, 24000),
(76, 26, 20, NULL, NULL, NULL, 22000),
(77, 26, 22, NULL, NULL, NULL, 21000),
(78, 26, 23, NULL, NULL, NULL, 21000),
(79, 27, 5, NULL, NULL, NULL, 18000),
(80, 27, 15, NULL, NULL, NULL, 23000),
(81, 27, 28, NULL, NULL, NULL, 22000),
(82, 28, 8, NULL, NULL, NULL, 23000),
(83, 28, 26, NULL, NULL, NULL, 24000),
(84, 28, 30, NULL, NULL, NULL, 24000),
(85, 29, 1, NULL, NULL, NULL, 21000),
(86, 29, 10, NULL, NULL, NULL, 19000),
(87, 29, 22, NULL, NULL, NULL, 21000),
(88, 30, 13, NULL, NULL, NULL, 21000),
(89, 30, 18, NULL, NULL, NULL, 22000),
(90, 30, 23, NULL, NULL, NULL, 21000);

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `fee_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `amount` int(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`manager_id`, `username`, `password`, `name`, `contact`, `email`) VALUES
(1, 'manager1', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Manager 1', '0300-0987654', 'manager1@tuitionacademy.com'),
(2, 'manager2', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Manager 2', '0301-0987654', 'manager2@tuitionacademy.com');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `no` int(1) NOT NULL,
  `marks` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `no` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `teacher_id`, `course_id`, `no`) VALUES
(1, 1, 1, 'A'),
(2, 2, 1, 'B'),
(3, 3, 2, 'A'),
(4, 4, 2, 'B'),
(5, 5, 3, 'A'),
(6, 5, 3, 'B'),
(7, 6, 4, 'A'),
(8, 7, 4, 'B'),
(9, 8, 5, 'A'),
(10, 8, 5, 'B'),
(11, 9, 6, 'A'),
(12, 9, 6, 'B'),
(13, 10, 7, 'A'),
(14, 11, 7, 'B'),
(15, 12, 8, 'A'),
(16, 12, 8, 'B'),
(17, 13, 9, 'A'),
(18, 13, 9, 'B'),
(19, 2, 10, 'A'),
(20, 2, 10, 'B'),
(21, 14, 11, 'A'),
(22, 14, 11, 'B'),
(23, 15, 12, 'A'),
(24, 15, 12, 'B'),
(25, 16, 13, 'A'),
(26, 16, 13, 'B'),
(27, 9, 14, 'A'),
(28, 9, 15, 'A'),
(29, 11, 16, 'A'),
(30, 12, 17, 'A'),
(31, 16, 18, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `username`, `password`, `name`, `contact`, `email`) VALUES
(1, 'usman', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Mohammad Usman', '0300-4567890', 'usman@tuitionacademy.student.com'),
(2, 'wahab', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Abdul Wahab', '0301-4567890', 'wahab@tuitionacademy.student.com'),
(3, 'omer', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Omer Khalil', '0302-4567890', 'omer@tuitionacademy.student.com'),
(4, 'sharif', '$2y$10$trVkpgOOEXrGdYTNfTVHIOR1VCOm2hbv/BZTjtKJRQLH7DIt/ugl6', 'Sharif Hayat', '0303-4567890', 'sharif@tuitionacademy.student.com'),
(5, 'haseeb', '$2y$10$n8Kc1panm1TUM9zjX/h5ZudkoekNs7.keky5PHVCo9XL9YHDcuchu', 'Abdul Haseeb', '0304-4567890', 'haseeb@tuitionacademy.student.com'),
(6, 'wasay', '$2y$10$.pxSpvZyGOL0Es8MxTyUqed2GA1e3ch0BjgXA4vLc8DS2ctNYEnPi', 'Abdul Wasay', '0305-4567890', 'wasay@tuitionacademy.student.com'),
(7, 'abeer', '$2y$10$ETAkx.FhF5RKbjRgyAifceOEoy/AXWqI0CE07H9JKGGto9pzjITNG', 'Abeer Butt', '0306-4567890', 'abeer@tuitionacademy.student.com'),
(8, 'adan', '$2y$10$0daAcryzBeusFlUYWZ.syesdWsGea33OhQtWnCQ.TXlDWS3CPUCHm', 'Adan Nelson', '0307-4567890', 'adan@tuitionacademy.student.com'),
(9, 'ahmed', '$2y$10$10lbKVZdey6ZgrS3Hi5GN.HH9d7.GUK7DdKSVZO6zIOPIdMFrsJmS', 'Ahmed Mansoor', '0308-4567890', 'ahmed@tuitionacademy.student.com'),
(10, 'aimen', '$2y$10$B5auNX8beBd3ZhrBiK0nOuYZyefDVOuGr7TjXL49NG9sSlVtV.b8u', 'Aimen Shahid', '0309-4567890', 'aimen@tuitionacademy.student.com'),
(11, 'ali', '$2y$10$Zg4iA9JrFcdYnDSWstCRy.gWmYaTUXQz84ApwEf/Pd2eQ//pkByTG', 'Ali Abbas', '0310-4567890', 'ali@tuitionacademy.student.com'),
(12, 'aamin', '$2y$10$QK4pyMoivJhYzw0odKdRa.05.aL17R.zwDstS1EqDCCpi0qHxoRJC', 'Aamin Baig', '0311-4567890', 'aamin@tuitionacademy.student.com'),
(13, 'asad', '$2y$10$K.fB5igFBEIrZfoJ9TnpFuX0.TG7KouC35EgCEM6uaHSp0NipSdqu', 'Asad Inam', '0312-4567890', 'asad@tuitionacademy.student.com'),
(14, 'ased', '$2y$10$JkLU2JtrmqXiu3P9TnedGuHFiel0p/oNLDwJXBRAOzSh4BDm47Bre', 'Ased Waseem', '0313-4567890', 'ased@tuitionacademy.student.com'),
(15, 'bushra', '$2y$10$r8npFpMfNIwkebJT9OZYyugp/vWohHJWrOtHuGV.K9BSb14k8gtj.', 'Bushra Habib', '0314-4567890', 'bushra@tuitionacademy.student.com'),
(16, 'danish', '$2y$10$5V.t51E0h7EDowHaUwMU9eOV5NgOjyiHDEg1G/Q/ZUDJ0GAzg/8Aa', 'Danish Ali', '0315-4567890', 'danish@tuitionacademy.student.com'),
(17, 'faizan', '$2y$10$uf7LE5rCO8crFhl7TTM44exeYNON0u.K9J4vlXmdIct/8TLzwxWNG', 'Faizan Siddiqui', '0316-4567890', 'faizan@tuitionacademy.student.com'),
(18, 'fateh', '$2y$10$MBIbpvm//uoanP0CxtFvleOzutR87.b8T1wf/Yu9Ty1GWRd5tpPmi', 'Fateh Muhammad', '0317-4567890', 'fateh@tuitionacademy.student.com'),
(19, 'hamza', '$2y$10$S1ztVr1em/tt1QreN0YxfOJhQj0ZQgIE4txdBobUrf4ctuvAvzYZu', 'Hamza Butt', '0318-4567890', 'hamza@tuitionacademy.student.com'),
(20, 'haris', '$2y$10$0AxTAKs6O5XWe.DLVJE4reITgJJOscZ48YusUrcL5K.rHW8ViNfbi', 'Haris Naseer', '0319-4567890', 'haris@tuitionacademy.student.com'),
(21, 'hurmat', '$2y$10$aPpN7rWQ/MUvlgi0r5.LR.b2zbB15JWhhrgzqQcTbdrawrYyzpacy', 'Hurmat Shahid', '0320-4567890', 'hurmat@tuitionacademy.student.com'),
(22, 'jahanzaib', '$2y$10$3uVvP5TN78ne86t3jmq/JeV8cN5SYJ2w9fICCKGj/W6wupKFZ6JDm', 'Jahanzaib Tariq', '0321-4567890', 'jahanzaib@tuitionacademy.student.com'),
(23, 'khuzaima', '$2y$10$aoWUDVZOBxpOFpCDzrcawOFMjAr9uJdvup4tNQgHQ8gzSpNaaKl..', 'Khuzaima Lodhi', '0322-4567890', 'khuzaima@tuitionacademy.student.com'),
(24, 'momeer', '$2y$10$FwEWvN2UUz2Gu5GZjFM06.ZT4uA9bZoj.4E3fPbi1r1V/AdKPsACm', 'Momeer Rafaqat', '0323-4567890', 'momeer@tuitionacademy.student.com'),
(25, 'muneeb', '$2y$10$NPtj32tXX0BpW/3HVRYCP.oP8zbsGuYmak6MeeYyn7hdkwvAuod.i', 'Muneeb Amer', '0324-4567890', 'muneeb@tuitionacademy.student.com'),
(26, 'nabeel', '$2y$10$7Br20bpmrBnnepaeEazcXeUmFq/o4uDjFO56qlI.hPWrnBJGqb7W.', 'Nabeel Hassan', '0325-4567890', 'nabeel@tuitionacademy.student.com'),
(27, 'qasim', '$2y$10$m2keSX1.kB2lZStHdD5FJ.YZYyzFmRXiaXP5BGqsWQdAqwrvkDHCS', 'Qasim Tariq', '0326-4567890', 'qasim@tuitionacademy.student.com'),
(28, 'samar', '$2y$10$XoxSfhHsH8a.SztQFkhkfuf45PmhougUr/eZyyEmgnEgNheUdFjU2', 'Samar Sohail', '0327-4567890', 'samar@tuitionacademy.student.com'),
(29, 'shamir', '$2y$10$8GS2BQ3oOkZTWu7uICgCpOkj4.Yqf3G3MmSaY7d7KoIs9LAZDOHa6', 'Shamir Javed', '0328-4567890', 'shamir@tuitionacademy.student.com'),
(30, 'shayan', '$2y$10$VJDrienaHT0dI.1kXsPhn.ew4Z2zfkARdqGR0bxv00JnQ5F8fm1W.', 'Shayan Zafar', '0329-4567890', 'shayan@tuitionacademy.student.com');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `username`, `password`, `name`, `contact`, `email`) VALUES
(1, 'umbernisar', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Umber Nisar', '0300-1234567', 'umbernisar@tuitionacademy.com'),
(2, 'saaraasif', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Saara Asif', '0301-1234567', 'saaraasif@tuitionacademy.com'),
(3, 'samiaasloob', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Samia Asloob Qureshi', '0302-1234567', 'samiaasloobqureshi@tuitionacademy.com'),
(4, 'alifaheem', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Ali Faheem', '0303-1234567', 'alifaheem@tuitionacademy.com'),
(5, 'mariatamoor', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Maria Tamoor', '0304-1234567', 'mariatamoor@tuitionacademy.com'),
(6, 'fakhirshaheen', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Fakhir Shaheen', '0305-1234567', 'fakhirshaheen@tuitionacademy.com'),
(7, 'adilmukhtar', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Adil Mukhtar', '0306-1234567', 'adilmukhtar@tuitionacademy.com'),
(8, 'sidraminhas', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Sidra Minhas', '0307-1234567', 'sidraminhas@tuitionacademy.com'),
(9, 'sarwanabbasi', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Sarwan Altaf Abbasi', '0308-1234567', 'sarwanaltafabbasi@tuitionacademy.com'),
(10, 'sabakhaliltoor', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Saba Khalil Toor', '0309-1234567', 'sabakhaliltoor@tuitionacademy.com'),
(11, 'saadbinsaleem', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Saad bin Saleem', '0310-1234567', 'saadbinsaleem@tuitionacademy.com'),
(12, 'raufbutt', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Muhammad Rauf Butt', '0311-1234567', 'muhammadraufbutt@tuitionacademy.com'),
(13, 'salmanchaudhry', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Muhammad Salman Chaudhry', '0312-1234567', 'muhammadsalmanchaudhry@tuitionacademy.com'),
(14, 'mumtazali', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Mumtaz Ali Sheikh', '0313-1234567', 'mumtazalisheikh@tuitionacademy.com'),
(15, 'mubasharmushtaq', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Mubashar Mushtaq', '0314-1234567', 'mubasharmushtaq@tuitionacademy.com'),
(16, 'amaratariq', '$2y$10$hgGMFSAdIkYlqcC8/UA3qOVXxfZw8W.tY8JyseQra1/SDwhm75Gm2', 'Amara Tariq', '0315-1234567', 'amaratariq@tuitionacademy.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`admission_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`fee_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `admission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `manager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission`
--
ALTER TABLE `admission`
  ADD CONSTRAINT `admission_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `fee`
--
ALTER TABLE `fee`
  ADD CONSTRAINT `fee_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
