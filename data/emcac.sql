-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Mar-2017 às 16:32
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emcac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `value` float NOT NULL,
  `date` char(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `activities`
--

INSERT INTO `activities` (`id`, `subject`, `value`, `date`, `status`, `room_id`) VALUES
(1, 'Logica de Matematica', 10, '26/02/2017', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `alternative` char(1) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `answers`
--

INSERT INTO `answers` (`id`, `user_id`, `question_id`, `alternative`, `number`) VALUES
(5, 9, 1, 'a', 1),
(7, 9, 2, 'b', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `query` varchar(250) NOT NULL,
  `alternative_a` varchar(250) NOT NULL,
  `alternative_b` varchar(250) NOT NULL,
  `alternative_c` varchar(250) NOT NULL,
  `alternative_d` varchar(250) NOT NULL,
  `alternative_e` varchar(250) NOT NULL,
  `answer` char(1) NOT NULL,
  `value` float NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `questions`
--

INSERT INTO `questions` (`id`, `activity_id`, `query`, `alternative_a`, `alternative_b`, `alternative_c`, `alternative_d`, `alternative_e`, `answer`, `value`, `number`) VALUES
(1, 1, '1 + 1', '2', '3', '1', '11', '0', 'A', 1, 1),
(2, 1, '1 + 2', '2', '3', '1', '11', '0', 'B', 1, 2),
(4, 1, 's', 'a', 'w', 'e', 'a', 'n', 'a', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recoveries`
--

CREATE TABLE `recoveries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'teacher'),
(3, 'student'),
(4, 'secretary');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `year` year(4) NOT NULL,
  `teacher` varchar(45) NOT NULL,
  `shift` varchar(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `year`, `teacher`, `shift`, `status`) VALUES
(2, '1 ano', 2017, 'Deigon Prates', 'Vespertino', 1),
(8, '9 ano', 2017, 'Carlitos Gozaga', 'Matutino', 1),
(11, '2 ano noturno', 2017, 'Deigon Prates Araujo', 'Vespertino', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rooms_users`
--

CREATE TABLE `rooms_users` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT 'NADA CONSTA',
  `username` varchar(100) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `registration` varchar(45) NOT NULL,
  `birth` varchar(11) NOT NULL,
  `sex` varchar(12) NOT NULL,
  `phone` varchar(16) NOT NULL DEFAULT 'NADA CONSTA',
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `username`, `password`, `salt`, `status`, `registration`, `birth`, `sex`, `phone`, `address`) VALUES
(7, 2, 'Professor', 'professor@hotmail.com', 'Deigon', 'ff9f3d0dcc32891e3ac290641b742d66c82bb34aeee3b0883eb6c87ee0b0b157303d3502bf9e4863f54fa3251270ee0b2e9186d67e92985067d4c4d8a84ffbd0', '7da6d91a43885b652dd022ae531937291532771e7a3d5dca19e2e568f0f45b5e69e140ab8aba9ce79128f9c0aad4af857ae3a60c9359e558e84b8bb4a5328689', 1, '1234567890', '05/09/1994', 'Masculino', '(69) 3517-5470', 'Rua Vasco da gama'),
(9, 3, 'testes', 'mts@hotmail.com', 'teste', '86da535da70729630e80a6e106ca46817ac76dc495954b658882b3bd64de55ea7a12e049109fbf3b1072e67c7f5e4130df7b54b8c6c6ce03342f01c7bdcbf9ae', '13768aa0ff1cb126d4483695ea84c36f44779c7c82f175eb940395bfa4a881e9b29f92947837280866cee270af33af53aa60a10d4c26c01a38747194ff392cae', 1, '123', '05/09/1994', 'Masculino', '(69) 3517-5470', 'Rua Brasília, 366');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`,`room_id`),
  ADD KEY `fk_activities_classes1_idx` (`room_id`),
  ADD KEY `rooms_id` (`room_id`),
  ADD KEY `rooms_id_2` (`room_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`,`question_id`,`user_id`),
  ADD KEY `answers_user_id_idx` (`user_id`),
  ADD KEY `answers_question_id_idx` (`question_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `login_attempts_user_id_idx` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`,`activity_id`),
  ADD KEY `fk_questions_activities1_idx` (`activity_id`);

--
-- Indexes for table `recoveries`
--
ALTER TABLE `recoveries`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `passwors_user_id_idx` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_users`
--
ALTER TABLE `rooms_users`
  ADD PRIMARY KEY (`id`,`room_id`,`user_id`),
  ADD KEY `fk_classes_has_users_users1_idx` (`user_id`),
  ADD KEY `fk_classes_has_users_classes1_idx` (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_idx` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `recoveries`
--
ALTER TABLE `recoveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `rooms_users`
--
ALTER TABLE `rooms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `fk_activities_classes1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `answers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_questions_activities1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `recoveries`
--
ALTER TABLE `recoveries`
  ADD CONSTRAINT `passwors_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `rooms_users`
--
ALTER TABLE `rooms_users`
  ADD CONSTRAINT `fk_classes_has_users_classes1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_classes_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
