-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 19, 2026 at 07:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daily_blogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `mobile`, `password`) VALUES
(1, 'admin', 'kartikkale609@gmail.com', '9876543210', '$2y$10$AGa9u7KhwQdUnkp5euQTI.A1PqsKejgbJaNUbe4lccSBZxsgQR4YW');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `remark` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `user_id`, `title`, `description`, `image`, `status`, `remark`, `created_at`) VALUES
(1, 2, 'Artificial Intelligence (AI) and Machine Learning (ML)', 'Artificial Intelligence (AI) is a branch of computer science that focuses on creating systems capable of performing tasks that usually require human intelligence. These tasks include problem-solving, decision-making, understanding natural language, recognizing images, and even learning from experience. AI can be classified into narrow AI, which is designed for specific tasks like voice assistants, and general AI, which aims to perform any intellectual task a human can do, though this is still largely theoretical.\r\n\r\nMachine Learning (ML) is a subset of AI that enables systems to learn and improve from data without explicit programming. Instead of following fixed instructions, ML algorithms analyze patterns, make predictions, or classify information based on past data. Common applications include recommendation systems, fraud detection, and self-driving cars. ML techniques are broadly categorized into supervised learning, unsupervised learning, and reinforcement learning, each suited for different kinds of problems.\r\n\r\nTogether, AI and ML are revolutionizing industries by enabling automation, enhancing decision-making, and providing smarter solutions to complex problems. As technology advances, the combination of AI and ML continues to expand the possibilities of innovation, making machines more intelligent, adaptive, and capable of interacting naturally with humans.', '1771526218_1768572884_1.jpg', 'Approved', NULL, '2026-02-20 00:06:58'),
(2, 2, 'Cybersecurity and Digital Trust', 'Cybersecurity refers to the practice of protecting computers, networks, programs, and data from unauthorized access, attacks, or damage. With the rise of digital technology, sensitive information like personal details, financial records, and business data is constantly at risk. Cybersecurity involves using tools, processes, and best practices to defend against cyber threats such as malware, phishing, ransomware, and hacking. It ensures that systems remain secure, data stays confidential, and operations continue without disruption.\r\n\r\nDigital trust is the confidence users have in the safety, privacy, and reliability of digital systems and online services. It is built when organizations demonstrate strong cybersecurity measures, ethical data handling, and transparent policies. High digital trust encourages people to share information, use online platforms, and engage in digital transactions without fear.\r\n\r\nTogether, cybersecurity and digital trust are essential for the digital world. While cybersecurity provides the protection mechanisms, digital trust ensures that users feel safe and confident in interacting with technology. Businesses, governments, and individuals all rely on these principles to maintain secure, reliable, and trustworthy digital environments.', '1771526268_1768575032_7.jpg', 'Approved', NULL, '2026-02-20 00:07:48'),
(3, 2, 'Internet of Things (IoT) and Smart Infrastructure', 'The Internet of Things (IoT) is a technology that connects everyday objects—such as sensors, devices, appliances, and vehicles—to the internet, allowing them to collect, share, and act on data. These connected devices communicate with each other and with central systems to improve efficiency, automate tasks, and provide real-time insights. Examples include smart home devices like thermostats, wearable fitness trackers, and industrial sensors in factories.\r\n\r\nSmart infrastructure uses IoT technology to enhance the planning, operation, and maintenance of urban and industrial systems. This includes smart cities with intelligent traffic management, energy-efficient buildings, water and waste monitoring systems, and connected transportation networks. By integrating IoT into infrastructure, cities and organizations can reduce costs, save energy, improve safety, and make better decisions through data-driven insights.\r\n\r\nTogether, IoT and smart infrastructure are transforming how we live, work, and interact with our environment, making systems more efficient, responsive, and sustainable.', '1771526357_1jpg.jpeg', 'Approved', NULL, '2026-02-20 00:09:17'),
(4, 2, 'Cloud and Edge Computing', 'Cloud computing is a technology that allows users to store, manage, and process data over the internet instead of on local computers or servers. It provides on-demand access to computing resources like storage, applications, and processing power, enabling businesses and individuals to scale easily, reduce costs, and access data from anywhere. Popular examples include Google Drive, Amazon Web Services (AWS), and Microsoft Azure. Cloud computing is highly flexible and supports collaboration, big data processing, and complex applications without heavy investment in physical infrastructure.\r\n\r\nEdge computing, on the other hand, brings computation and data storage closer to the source of data generation, such as sensors, devices, or local servers. This reduces latency, improves real-time processing, and decreases dependency on centralized cloud servers. It is widely used in IoT devices, autonomous vehicles, and smart factories, where quick decision-making is critical.\r\n\r\nTogether, cloud and edge computing complement each other, enabling scalable, efficient, and fast data processing for modern applications and connected systems.', '1771526433_2.jpg', 'Approved', NULL, '2026-02-20 00:10:33'),
(5, 2, 'Blockchain and Decentralized Systems', 'Blockchain is a digital technology that records information in a secure, transparent, and tamper-proof way. It stores data in a chain of blocks, where each block contains a record of transactions linked to the previous one. This makes it nearly impossible to alter past records without the agreement of the network, ensuring trust and security. Blockchain is widely known for cryptocurrencies like Bitcoin, but it is also used in supply chain management, digital identity, voting systems, and more.\r\n\r\nDecentralized systems operate without a central authority, distributing control across multiple nodes or participants. In these systems, each participant has access to the same information, reducing the risk of single-point failures, fraud, or data manipulation. Decentralization improves transparency, resilience, and fairness in digital networks.\r\n\r\nTogether, blockchain and decentralized systems are reshaping finance, governance, and digital services by providing secure, transparent, and trustable ways to store, share, and manage data.', '1771526505_1768574647_4.jpg', 'Approved', NULL, '2026-02-20 00:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `email`, `password`) VALUES
(1, 'testuser', 'testuser@example.com', '$2y$10$O8Zy6/cnZx9Jq1xzCdc5tOguF6fJt5ZFmXD0nWShMEJ5v15vC6dCu'),
(2, 'kartik40', 'k@gmail.com', '$2y$10$7byPDIRx2M09Dt5KLN.VzeF/vWLeEbBTCwZyJ.YgKUoaQm0OcKUqC');

-- --------------------------------------------------------

--
-- Table structure for table `page_visits`
--

CREATE TABLE `page_visits` (
  `id` int(11) NOT NULL,
  `visits` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_visits`
--

INSERT INTO `page_visits` (`id`, `visits`) VALUES
(1, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `page_visits`
--
ALTER TABLE `page_visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
